<?php

namespace Agentsquidflaps\Picture;

use Agentsquidflaps\Picture\Adapter\AdapterInterface;
use Agentsquidflaps\Picture\Traits\ChecksForSetValuesTrait;
use Agentsquidflaps\Picture\Traits\RequiresAttributeMarkupTrait;
use Agentsquidflaps\Picture\Traits\isSourceTrait;
use Symfony\Component\HttpFoundation\Request;

use function \rawurlencode;
use function \array_filter;
use function \in_array;
use function \preg_match;
use function \is_string;
use function \strcasecmp;

/**
 * Class AbstractSource
 * @package Agentsquidflaps\Picture
 */
abstract class Source implements AdapterInterface
{
    const POSITION_TOP = 1;
    const POSITION_RIGHT = 2;
    const POSITION_BOTTOM = 3;
    const POSITION_LEFT = 4;
    const POSITION_TOP_RIGHT = 5;
    const POSITION_BOTTOM_RIGHT = 6;
    const POSITION_BOTTOM_LEFT = 7;
    const POSITION_TOP_LEFT = 8;

    const POSITIONS = [
        self::POSITION_TOP => 'top',
        self::POSITION_RIGHT => 'right',
        self::POSITION_BOTTOM => 'bottom',
        self::POSITION_LEFT => 'left',
        self::POSITION_TOP_RIGHT => 'top-right',
        self::POSITION_BOTTOM_RIGHT => 'bottom-right',
        self::POSITION_TOP_LEFT => 'top-left',
        self::POSITION_BOTTOM_LEFT => 'bottom-left'
    ];

    const STRATEGY_ENTROPY = 16;
    const STRATEGY_ATTENTION = 17;

    const IMAGE_FORMAT_JPEG = 'jpeg';
    const IMAGE_FORMAT_JPG = 'jpg';
    const IMAGE_FORMAT_WEBP = 'webp';
    const IMAGE_FORMAT_PNG = 'png';

    /** @var string Preserving aspect ratio, ensure the image covers both provided dimensions by cropping/clipping to fit. */
    const FIT_COVER = 'cover'; // resize w/aspect ratio
    /** @var string Preserving aspect ratio, contain within both provided dimensions using "letterboxing" where necessary. */
    const FIT_CONTAIN = 'contain'; // fit
    /** @var string Ignore the aspect ratio of the input and stretch to both provided dimensions. */
    const FIT_FILL = 'fill'; // resize w/upsizing
    /** @var string Preserving aspect ratio, resize the image to be as large as possible while ensuring its dimensions are less than or equal to both those specified. */
    const FIT_INSIDE = 'inside';
    /** @var string Preserving aspect ratio, resize the image to be as small as possible while ensuring its dimensions are greater than or equal to both those specified. */
    const FIT_OUTSIDE = 'outside';

    const TAG_IMG = 'img';
    const TAG_SOURCE = 'source';

    /** @var MediaQuery | null */
    private $mediaQuery;

    /** @var string | null */
    private $extension = null;

    use ChecksForSetValuesTrait;
    use RequiresAttributeMarkupTrait;
    use isSourceTrait;

    /**
     * @return MediaQuery|null
     */
    public function getMediaQuery()
    {
        return $this->mediaQuery;
    }

    /**
     * @param MediaQuery|null $mediaQuery
     * @return self
     */
    public function setMediaQuery(MediaQuery $mediaQuery): self
    {
        $this->mediaQuery = $mediaQuery;
        return $this;
    }

    /**
     * @return string
     */
    public function getMarkup()
    {
        $this->setDefaults();

        if ($this->isSupported()) {
            $markup = $standardSrc = $retinaStandardSrc = $webpSrc = '';

            if ($this->getPath()) {
                $standardSrc = $this->get();

                if ($this->isWebp()) {
                    $webpImage = clone $this;
                    $webpSrc = $webpImage->setFormat(self::IMAGE_FORMAT_WEBP)->get();
                }

                // If no width or height is set, it'll just be half the size...
                if ($this->isRetina() && ($this->getWidth() || $this->getHeight())) {
                    $retinaStandardSrc = $standardSrc . ' 1x';

                    if ($this->isWebp()) {
                        $webpSrc .= ' 1x';
                    }

                    foreach ($this->getRetinaSizes() as $retinaSize) {
                        $retinaImage = clone $this;

                        if ($this->getWidth()) {
                            $retinaImage->setWidth(ceil($this->getWidth() * $retinaSize));
                        }

                        if ($this->getHeight()) {
                            $retinaImage->setHeight(ceil($this->getHeight() * $retinaSize));
                        }

                        if ($this->isWebp()) {
                            $retinaWebpImage = clone $retinaImage;
                            $webpSrc .= sprintf(', %s %sx', $retinaWebpImage->setFormat(self::IMAGE_FORMAT_WEBP)->get(), $retinaSize);
                        }

                        if ($this->tag === self::TAG_SOURCE) {
                            $retinaStandardSrc .= sprintf(', %s %sx', $retinaImage->get(), $retinaSize);
                        } else {
                            $markup .= $this->sourceMarkup(sprintf('%s, %s %sx', $retinaStandardSrc, $retinaImage->get(), $retinaSize), $this->getExtension());
                        }
                    }
                }

                if ($this->isWebp()) {
                    $markup = $this->sourceMarkup($webpSrc, self::IMAGE_FORMAT_WEBP) . $markup;
                }
            }

            if ($standardSrc) {
                $markup .= $this->getTag() === self::TAG_IMG ? $this->imgMarkup($standardSrc) : $this->sourceMarkup($retinaStandardSrc ?: $standardSrc, $this->getExtension());
            }
        } else {
            $markup = $this->imgMarkup($this->getPath());
        }

        return $markup;
    }

    /**
     * @param string $src
     * @param string $format
     * @return string
     */
    protected function sourceMarkup(string $src, string $format)
    {
        $allowedAttributes = [
            'media'
        ];

        $attributes = array_filter($this->getAttributes(), function ($k) use ($allowedAttributes) {
            return in_array($k, $allowedAttributes);
        }, ARRAY_FILTER_USE_KEY);

        if ($this->isLazyLoaded()) {
            $attributes['srcset'] = $this->getBaseImg();
            $attributes['data-srcset'] = $src;
        } else {
            $attributes['srcset'] = $src;
        }

        $attributes['type'] = $this->type($format);

        if ($this->getMediaQuery()) {
            $attributes['media'] = $this->getMediaQuery()->getMarkup();
        }

        return '<source ' . $this->attributes($attributes) . '/>';
    }

    /**
     * @param string $src
     * @return string
     */
    protected function imgMarkup(string $src)
    {
        $attributes = $this->getAttributes();

        unset($attributes['media']);

        if ($this->isLazyLoaded()) {
            $class = $attributes['class'] ?? '';
            $attributes = [
                    'src' => $this->getBaseImg(),
                    'data-src' => $src,
                    'class' => $class . ($class ? ' ' : '') . 'lazyload'
                ] + $attributes;
        } else {
            $attributes['src'] = $src;
        }

        $attributes['alt'] = $this->getDescription();
        return '<img ' . $this->attributes($attributes) . '/>';
    }

    /**
     * @return string
     */
    protected function getBaseImg()
    {
        $width = $this->getWidth() ?: '100%';
        $height = $this->getHeight() ?: '100%';
        $svgString = "<svg width='%s' height='%s' xmlns='http://www.w3.org/2000/svg'><rect x='0' y='0' width='%s' height='%s' rx='5' ry='5' fill='%s' fill-opacity='%s'/></svg>";
        $replacedSvgString = sprintf($svgString, $width, $height, $width, $height, $this->getFill(), $this->getFillAlpha());
        return "data:image/svg+xml," . rawurlencode($replacedSvgString);
    }

    /**
     * @return mixed|string
     */
    protected function type($format)
    {
        if (!$this->getPath()) {
            return '';
        }

        return ImageMimeType::getMimeTypeFromExtension($format);
    }

    /**
     * @return string | null
     */
    protected function getExtension()
    {
        if ($this->extension === null) {
            preg_match('/\.((?!.*\.)[\w]+)/', $this->getPath(), $matches);

            $this->extension = $matches[1] ?? '';
        }

        return $this->extension;
    }

    protected function setDefaults()
    {
        $this->setOptions($this->getSelectedDefaults() + [
                'fill' => '#000000',
                'fillAlpha' => 0.1,
                'tag' => self::TAG_SOURCE,
                'lazyLoaded' => false,
                'retina' => true,
                'webp' => true,
                'fit' => Source::FIT_COVER,
                'retinaSizes' => [2],
                'quality' => 80,
                'version' => 1
            ]);

        if ($this->isAjaxRequest()) {
            $this->setLazyLoaded(false);
        }
    }

    /**
     * @return array
     */
    protected function getSelectedDefaults()
    {
        return array_filter([
            'fill' => $this->getFill(),
            'fillAlpha' => $this->getFillAlpha(),
            'tag' => $this->getTag(),
            'lazyLoaded' => $this->isLazyLoaded(),
            'retina' => $this->isRetina(),
            'webp' => $this->isWebp(),
            'fit' => $this->getFit(),
            'retinaSizes' => $this->getRetinaSizes(),
            'quality' => $this->getQuality(),
            'version' => $this->getVersion()
        ], [$this, 'valueIsSet']);
    }

    /**
     * @return bool
     */
    protected function isAjaxRequest()
    {
        $request = Request::createFromGlobals();
        $requestedWith = $request->server->get('HTTP_X_REQUESTED_WITH');

        if (is_string($requestedWith) && strcasecmp($requestedWith, 'XMLHttpRequest') === 0) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function isSupported()
    {
        if ($this->getExtension() === 'svg') {
            return false;
        }

        return true;
    }

    public function __toString()
    {
        return $this->getMarkup();
    }
}
