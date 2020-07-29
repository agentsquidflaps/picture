<?php

namespace Agentsquidflaps\Picture;

use Agentsquidflaps\Picture\Traits\RequiresAttributeMarkup;
use Agentsquidflaps\Picture\Traits\isSource;

use function \array_pop;
use function \ucfirst;
use function \call_user_func;

class Picture
{
    /** @var Source[]|array */
    private $sources;

    use RequiresAttributeMarkup;
    use isSource;

    /**
     * Picture constructor.
     * @param array $sources
     * @param string $description
     * @param array $attributes
     */
    public function __construct(array $sources, string $description = '', array $attributes = [])
    {
        $this->sources = $sources;
        $this->description = $description;
        $this->attributes = $attributes;
    }

	/**
	 * @return string
	 * @throws \Exception
	 */
    public function getMarkup()
    {
        $sources = $this->sources;
        $imgSource = array_pop($sources);

        $markup = '<picture ' . $this->attributes($this->attributes) . '>';

        foreach ($sources as $source) {
        	$this->setPictureDefaults($source);
            $markup .= $source->getMarkup();
        }

        $this->setPictureDefaults($imgSource);

        $markup .= $imgSource
	        ->setTag(Source::TAG_IMG)
	        ->setDescription($this->description)
	        ->getMarkup();

        $markup .= '</picture>';

        return $markup;
    }

	/**
	 * @param Source $source
	 * @return $this
	 */
	private function setPictureDefaults(Source $source): Picture
	{
		$this->setParameter($source, 'path');
		$this->setParameter($source, 'lazyLoaded', 'is');
		$this->setParameter($source, 'retina', 'is');
		$this->setParameter($source, 'webp', 'is');
		$this->setParameter($source, 'format');
		$this->setParameter($source, 'position');
		$this->setParameter($source, 'fit');
		$this->setParameter($source, 'fill');
		$this->setParameter($source, 'fillAlpha');
		$this->setParameter($source, 'attributes');
		$this->setParameter($source, 'quality');
		$this->setParameter($source, 'version');

		return $this;
    }


	private function setParameter(Source $source, string $parameter, string $getterPrefix = 'get')
	{
		$parsedParameter = ucfirst($parameter);
		if ($this->$parameter && call_user_func([$source, $getterPrefix . $parsedParameter]) === null) {
			call_user_func([$source, 'set' . ucfirst($parameter)], $this->$parameter);
		}
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString()
    {
        return $this->getMarkup();
    }

}
