<?php

namespace Agentsquidflaps\Picture\Traits;

use Agentsquidflaps\Picture\AbstractSource;

/**
 * Trait SourceTrait
 * @package Agentsquidflaps\Picture\Traits
 */
trait SourceTrait{
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
	public function getPath(): ?string
	{
		return $this->path;
	}

	/**
	 * @param string|null $path
	 * @return self
	 */
	public function setPath(?string $path): self
	{
		$this->path = $path;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getWidth(): ?int
	{
		return $this->width;
	}

	/**
	 * @param int|null $width
	 * @return self
	 */
	public function setWidth(?int $width): self
	{
		$this->width = $width;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getHeight(): ?int
	{
		return $this->height;
	}

	/**
	 * @param int|null $height
	 * @return self
	 */
	public function setHeight(?int $height): self
	{
		$this->height = $height;
		return $this;
	}

	/**
	 * @param $width
	 * @param $height
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
	public function getAttributes(): array
	{
		return $this->attributes;
	}

	/**
	 * @param array | null $attributes
	 * @return self
	 */
	public function setAttributes(?array $attributes): self
	{
		$this->attributes = $attributes;
		return $this;
	}

	/**
	 * @return string | null
	 */
	public function getDescription(): ?string
	{
		return $this->description;
	}

	/**
	 * @param string| null $description
	 * @return self
	 */
	public function setDescription(?string $description): self
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @return bool | null
	 */
	public function isLazyLoaded(): ?bool
	{
		return $this->lazyLoaded;
	}

	/**
	 * @param bool | null $lazyLoaded
	 * @return self
	 */
	public function setLazyLoaded(?bool $lazyLoaded): self
	{
		$this->lazyLoaded = $lazyLoaded;
		return $this;
	}

	/**
	 * @return bool | null
	 */
	public function isRetina(): ?bool
	{
		return $this->retina;
	}

	/**
	 * @param bool | null $retina
	 * @return self
	 */
	public function setRetina(?bool $retina): self
	{
		$this->retina = $retina;
		return $this;
	}

	/**
	 * @return bool | null
	 */
	public function isWebp(): ?bool
	{
		return $this->webp;
	}

	/**
	 * @param bool | null $webp
	 * @return self
	 */
	public function setWebp(?bool $webp): self
	{
		$this->webp = $webp;
		return $this;
	}

	/**
	 * @return string | null
	 */
	public function getTag(): ?string
	{
		return $this->tag;
	}

	/**
	 * @param string | null $tag
	 * @return $this
	 * @throws \Exception
	 */
	public function setTag(?string $tag = AbstractSource::TAG_SOURCE): self
	{
		if (!in_array($tag, [AbstractSource::TAG_IMG, AbstractSource::TAG_SOURCE, '']))
			throw new \Exception('Only ' . AbstractSource::TAG_SOURCE . ' and ' . AbstractSource::TAG_IMG . ' tags are allowed');
		$this->tag = $tag;
		return $this;
	}

	/**
	 * @return string | null
	 */
	public function getFill(): ?string
	{
		return $this->fill;
	}

	/**
	 * @param string | null $fill
	 * @return self
	 */
	public function setFill(?string $fill): self
	{
		$this->fill = $fill;
		return $this;
	}

	/**
	 * @return string | null
	 */
	public function getFillAlpha(): ?string
	{
		return $this->fillAlpha;
	}

	/**
	 * @param string | null $fillAlpha
	 * @return self
	 */
	public function setFillAlpha(?string $fillAlpha): self
	{
		$this->fillAlpha = $fillAlpha;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getFit(): ?string
	{
		return $this->fit;
	}

	/**
	 * @param string|null $fit
	 * @return self
	 */
	public function setFit(?string $fit): self
	{
		$this->fit = $fit;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPosition(): ?string
	{
		return $this->position;
	}

	/**
	 * @param string|null $position
	 * @return self
	 */
	public function setPosition(?string $position): self
	{
		$this->position = $position;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getFormat(): ?string
	{
		return $this->format;
	}

	/**
	 * @param string|null $format
	 * @return $this
	 */
	public function setFormat(?string $format): self
	{
		$this->format = $format;
		return $this;
	}

	/**
	 * @return int|string|null
	 */
	public function getQuality(): ?string
	{
		return $this->quality;
	}

	/**
	 * @param int|string|null $quality
	 * @return SourceTrait
	 */
	public function setQuality($quality)
	{
		$this->quality = $quality;
		return $this;
	}

	/**
	 * @param array $options
	 * @return $this
	 */
	public function setOptions(array $options)
	{
		array_map(function ($key, $value) {
			$functionName = 'set' . ucfirst($key);
			call_user_func([$this, $functionName], $value);
		}, array_keys($options), $options);

		return $this;
	}

}
