<?php

namespace Agentsquidflaps\Picture\Adapter;

use Agentsquidflaps\Picture\AbstractSource;
use Agentsquidflaps\Picture\Traits\LocalSource;
use Intervention\Image\ImageManagerStatic;

/**
 * Class Intervention
 * @package Agentsquidflaps\Picture\Adapter
 */
class Intervention extends AbstractSource
{
	use LocalSource;

	/**
	 * @return string
	 */
    public function get(): string
    {
        $extension = $this->isWebp() ? 'webp' : $this->getFormat();

        if (file_exists($this->getFullCachePath())) {
            return $this->getRelativeCachePath();
        }

        if ($this->isWebp()) {
            $imageManager = ImageManagerStatic::configure(['driver' => 'gd']);
        } else {
            $imageManager = ImageManagerStatic::configure(['driver' => 'imagick']);
        }

        $callbackFunction = null;

        if (!$this->getWidth() || !$this->getHeight()) {
        	$callbackFunction = function ($constrait) {
        		return $constrait->aspectRatio();
	        };
        }

        $imageManager
	        ->make($this->getPath())
            ->fit($this->getWidth(), $this->getHeight(), $callbackFunction, $this->getFit() ? AbstractSource::POSITIONS[$this->getFit()] : 'center')
            ->save($this->getFullCachePath(), $this->getQuality(), $extension);

        return $this->getRelativeCachePath();
    }
}
