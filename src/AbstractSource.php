<?php

namespace Agentsquidflaps\Picture;

use Agentsquidflaps\Picture\Adapter\AdapterInterface;
use Agentsquidflaps\Picture\Traits\RequiresAttributeMarkup;
use Agentsquidflaps\Picture\Traits\SourceTrait;
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
abstract class AbstractSource implements AdapterInterface
{
	const POSITION_TOP = 1;
	const POSITION_RIGHT = 2;
	const POSITION_BOTTOM = 3;
	const POSITION_LEFT = 4;
	const POSITION_RIGHT_TOP = 5;
	const POSITION_RIGHT_BOTTOM = 6;
	const POSITION_LEFT_BOTTOM = 7;
	const POSITION_LEFT_TOP = 8;

	const POSITIONS = [
		self::POSITION_TOP => 'top',
		self::POSITION_RIGHT => 'right',
		self::POSITION_BOTTOM => 'bottom',
		self::POSITION_LEFT => 'left',
		self::POSITION_RIGHT_TOP => 'top-right',
		self::POSITION_RIGHT_BOTTOM => 'bottom-right',
		self::POSITION_LEFT_TOP => 'top-left',
		self::POSITION_LEFT_BOTTOM => 'bottom-left'
	];

	const STRATEGY_ENTROPY = 16;
	const STRATEGY_ATTENTION = 17;

	const IMAGE_FORMAT_JPEG = 'jpeg';
	const IMAGE_FORMAT_JPG = 'jpg';
	const IMAGE_FORMAT_WEBP = 'webp';
	const IMAGE_FORMAT_PNG = 'png';

	const TAG_IMG = 'img';
	const TAG_SOURCE = 'source';

	/** @var MediaQuery | null */
	private $mediaQuery;

	/** @var string | null */
	private $extension = null;

	use RequiresAttributeMarkup;
	use SourceTrait;

	/**
	 * @return MediaQuery|null
	 */
	public function getMediaQuery(): ?MediaQuery
	{
		return $this->mediaQuery;
	}

	/**
	 * @param MediaQuery|null $mediaQuery
	 * @return self
	 */
	public function setMediaQuery(?MediaQuery $mediaQuery): self
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

		$markup = $standardSrc = $webpSrc= '';

		if ($this->getPath()) {
			if ($this->isExtensionAllowed($this->getExtension())) {
				$standardSrc = $this->get();

				if ($this->webp) {
					$webpImage = clone $this;
					$webpSrc = $webpImage->setFormat(self::IMAGE_FORMAT_WEBP)->get();
				}

				// If no width or height is set, it'll just be half the size...
				if ($this->isRetina() && ($this->getWidth() || $this->getHeight())) {
					$retinaImage = clone $this;

					if ($this->getWidth()) {
						$retinaImage->setWidth($this->getWidth() * 2);
					}

					if ($this->getHeight()) {
						$retinaImage->setHeight($this->getHeight() * 2);
					}

					if ($this->webp) {
						$retinaWebpImage = clone $retinaImage;
						$webpSrc .= ' 1x, ' . $retinaWebpImage->setFormat(self::IMAGE_FORMAT_WEBP)->get() . ' 2x';
					}

					if ($this->tag === self::TAG_SOURCE) {
						$standardSrc .= ' 1x, ' . $retinaImage->get() . ' 2x';
					} else {
						$markup .= $this->sourceMarkup($standardSrc . ' 1x, ' . $retinaImage->get() . ' 2x', $this->getExtension());
					}
				}

				if ($this->webp) {
					$markup = $this->sourceMarkup($webpSrc, self::IMAGE_FORMAT_WEBP) . $markup;
				}
			}
		}

		if ($standardSrc) {
			$markup .= $this->getTag() === self::TAG_IMG ? $this->imgMarkup($standardSrc) : $this->sourceMarkup($standardSrc, $this->getExtension());
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
		return "data:image/svg+xml," . rawurlencode("<svg width='{$this->width}' height='{$this->height}' viewBox='0 0 {$this->width} {$this->height}' xmlns='http://www.w3.org/2000/svg'><rect x='0' y='0' width='{$this->width}' height='{$this->height}' rx='5' ry='5' fill='{$this->fill}' fill-opacity='{$this->fillAlpha}'/></svg>");
	}

	/**
	 * @return mixed|string
	 */
	private function type($format)
	{
		if (!$this->path) {
			return '';
		}

		switch ($format) {
			case 'webp':
				return 'image/webp';
				break;
			case 'png':
				return 'image/png';
				break;
			default:
				return 'image/jpeg';
		}
	}

	/**
	 * @return string | null
	 */
	protected function getExtension()
	{
		if ($this->extension === null) {
			preg_match('/(?:.*)\.(.+)$/', $this->getPath(), $matches);

			$this->extension = $matches[1] ?? '';
		}

		return $this->extension;
	}

	/**
	 * @param string $extension
	 * @return bool
	 */
	private function isExtensionAllowed(string $extension)
	{
		return in_array($extension, [
			'jpeg',
			'jpg',
			'webp',
			'png'
		]);
	}

	private function setDefaults() {
		$this->setOptions(array_filter([
			'fill' => $this->getFill(),
			'fillAlpha' => $this->getFillAlpha(),
			'tag' => $this->getTag(),
			'lazyLoaded' => $this->isLazyLoaded(),
			'retina' => $this->isRetina(),
			'webp' => $this->isWebp()
		]) + [
			'fill' => '#000000',
			'fillAlpha' => 0.1,
			'tag' => self::TAG_SOURCE,
			'lazyLoaded' => false,
			'retina' => true,
			'webp' => true
		]);

		if ($this->isAjaxRequest()) {
			$this->setLazyLoaded(false);
		}
	}

	/**
	 * @return bool
	 */
	private function isAjaxRequest()
	{
		$request = Request::createFromGlobals();
		$result = false;
		$requestedWith = $request->server->get('HTTP_X_REQUESTED_WITH');

		if (is_string($requestedWith) && strcasecmp($requestedWith, 'XMLHttpRequest') === 0) {
			$result = true;
		}

		return $result;
	}

    public function __toString()
    {
	    return $this->getMarkup();
    }
}
