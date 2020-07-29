<?php

namespace Agentsquidflaps\Picture\Traits;

/**
 * Trait LocalSource
 * @package Agentsquidflaps\Picture\Traits
 */
trait isLocal
{
	/** @var string | null */
	private $cacheName;

	/**
	 * @return string
	 */
	protected function getFullCachePath()
	{
		return getenv('PICTURE_CACHE_FULL_PATH') . $this->getCacheName();
	}

	/**
	 * @return string
	 */
	protected function getRelativeCachePath()
	{
		return getenv('PICTURE_CACHE_RELATIVE_PATH') . $this->getCacheName();
	}

	/**
	 * @return string|null
	 */
	protected function getCacheName()
	{
		if (!$this->cacheName) {
			$attributes = [
				$this->getVersion(),
				$this->getPath(),
				$this->getWidth(),
				$this->getHeight(),
				$this->getQuality(),
				$this->getFormat(),
				$this->getFit(),
				$this->getPosition(),
				self::class
			];

			$this->cacheName = md5(serialize($attributes)) . '.' . $this->getExtension();
		}

		return $this->cacheName;
	}
}
