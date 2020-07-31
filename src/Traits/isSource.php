<?php

namespace Agentsquidflaps\Picture\Traits;

use Agentsquidflaps\Picture\Source;

/**
 * Trait SourceTrait
 * @package Agentsquidflaps\Picture\Traits
 */
trait isSource {
	/**
	 * @var int
	 *
	 * If your environment caters for file versions, you may need to set the version for cache busting purposes
	 */
	protected $version = 1;

	/** @var string | null */
	protected $fill;

	/** @var string | float | null */
	protected $fillAlpha;

	/** @var string | null */
	protected $path;

	/** @var int | null */
	protected $width;

	/** @var int | null */
	protected $height;

	/** @var array | null */
	protected $options;

	/** @var string | null */
	protected $format;

	/** @var array */
	protected $attributes = [];

	/** @var string */
	protected $tag;

	/** @var string */
	protected $description = '';

	/** @var bool | null */
	protected $lazyLoaded;

	/** @var bool | null */
	protected $retina;

	/** @var bool | null */
	protected $webp;

	/** @var string | null */
	protected $fit;

	/** @var string | null */
	protected $position;

	/** @var string | int */
	protected $quality = 80;

	/**
	 * @return int
	 */
	public function getVersion(): int
	{
		return $this->version;
	}

	/**
	 * @param int $version
	 * @return self
	 */
	public function setVersion(int $version): self
	{
		$this->version = $version;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * @param string|null $path
	 * @return self
	 */
	public function setPath($path = ''): self
	{
		$this->path = $path;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getWidth()
	{
		return $this->width;
	}

	/**
	 * @param int $width
	 * @return self
	 */
	public function setWidth($width): self
	{
		$this->width = $width;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getHeight()
	{
		return $this->height;
	}

	/**
	 * @param int|null $height
	 * @return self
	 */
	public function setHeight($height): self
	{
		$this->height = $height;
		return $this;
	}

	/**
	 * @param int $width
	 * @param int $height
	 * @return $this
	 */
	public function setSize($width, $height): self
	{
		$this->width = $width;
		$this->height = $height;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}

	/**
	 * @param array $attributes
	 * @return self
	 */
	public function setAttributes($attributes = []): self
	{
		$this->attributes = $attributes;
		return $this;
	}

	/**
	 * @return string | null
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 * @return self
	 */
	public function setDescription($description = ''): self
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @return bool | null
	 */
	public function isLazyLoaded()
	{
		return $this->lazyLoaded;
	}

	/**
	 * @param bool $lazyLoaded
	 * @return self
	 */
	public function setLazyLoaded($lazyLoaded = true): self
	{
		$this->lazyLoaded = $lazyLoaded;
		return $this;
	}

	/**
	 * @return bool | null
	 */
	public function isRetina()
	{
		return $this->retina;
	}

	/**
	 * @param bool $retina
	 * @return self
	 */
	public function setRetina($retina = true): self
	{
		$this->retina = $retina;
		return $this;
	}

	/**
	 * @return bool | null
	 */
	public function isWebp()
	{
		return $this->webp;
	}

	/**
	 * @param bool $webp
	 * @return self
	 */
	public function setWebp($webp = true): self
	{
		$this->webp = $webp;
		return $this;
	}

	/**
	 * @return string | null
	 */
	public function getTag()
	{
		return $this->tag;
	}

	/**
	 * @param string $tag
	 * @return $this
	 * @throws \Exception
	 */
	public function setTag($tag = Source::TAG_SOURCE): self
	{
		if (!in_array($tag, [Source::TAG_IMG, Source::TAG_SOURCE, '']))
			throw new \Exception('Only ' . Source::TAG_SOURCE . ' and ' . Source::TAG_IMG . ' tags are allowed');
		$this->tag = $tag;
		return $this;
	}

	/**
	 * @return string | null
	 */
	public function getFill()
	{
		return $this->fill;
	}

	/**
	 * @param string $fill
	 * @return self
	 *
	 * The hex colour of the pre-image when lazyloading
	 */
	public function setFill($fill = ''): self
	{
		$this->fill = $fill;
		return $this;
	}

	/**
	 * @return string | null
	 *
	 * The pre-image alpha when lazyloading
	 */
	public function getFillAlpha()
	{
		return $this->fillAlpha;
	}

	/**
	 * @param string $fillAlpha
	 * @return self
	 */
	public function setFillAlpha($fillAlpha = ''): self
	{
		$this->fillAlpha = $fillAlpha;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getFit()
	{
		return $this->fit;
	}

	/**
	 * @param string $fit
	 * @return self
	 */
	public function setFit($fit = ''): self
	{
		$this->fit = $fit;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPosition()
	{
		return $this->position;
	}

	/**
	 * @param string $position
	 * @return self
	 */
	public function setPosition($position = ''): self
	{
		$this->position = $position;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getFormat()
	{
		return $this->format;
	}

	/**
	 * @param string $format
	 * @return $this
	 */
	public function setFormat($format = Source::IMAGE_FORMAT_JPG): self
	{
		$this->format = $format;
		return $this;
	}

	/**
	 * @return int|string|null
	 */
	public function getQuality()
	{
		return $this->quality;
	}

	/**
	 * @param int|string $quality
	 * @return $this
	 */
	public function setQuality($quality = 80)
	{
		$this->quality = $quality;
		return $this;
	}

	/**
	 * @param array $options
	 * @return $this
	 *
	 * Set options as an array. Key values are the snake case version of the relevant method, sans the set prefix
	 */
	public function setOptions($options = []): self
	{
		array_map(function ($key, $value) {
			$functionName = 'set' . ucfirst($key);
			call_user_func([$this, $functionName], $value);
		}, array_keys($options), $options);

		return $this;
	}

}
