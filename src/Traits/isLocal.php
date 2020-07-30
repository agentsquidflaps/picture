<?php

namespace Agentsquidflaps\Picture\Traits;

/**
 * Trait LocalSource
 * @package Agentsquidflaps\Picture\Traits
 */
trait isLocal
{
	/**
	 * @return string
	 */
	protected function getFullCachePath()
	{
		return getenv('PICTURE_WEB_ROOT') . '/' . $this->getRelativeCachePath();
	}

	/**
	 * @return string
	 */
	protected function getRelativeCachePath()
	{
		return getenv('PICTURE_CACHE_RELATIVE_PATH') . '/' .  $this->getCacheName();
	}

	/**
	 * @return string|null
	 */
	protected function getCacheName()
	{
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

		return md5(serialize($attributes)) . '.' . $this->getExtension();
	}
}
