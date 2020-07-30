<?php

namespace Agentsquidflaps\Picture\Adapter;

use Agentsquidflaps\Picture\Source;
use Agentsquidflaps\Picture\Traits\isLocal;
use Intervention\Image\ImageManagerStatic;

/**
 * Class Intervention
 * @package Agentsquidflaps\Picture\Adapter
 */
class Intervention extends Source
{
	use isLocal;

	/**
	 * @return string
	 */
    public function get(): string
    {
        $extension = $this->getFormat() ?: $this->getExtension();

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
	        ->make($this->getFullPath())
            ->fit(
            	$this->getWidth(),
	            $this->getHeight(),
	            $callbackFunction,
	            $this->getFit() ? Source::POSITIONS[$this->getFit()] : 'center'
            )
            ->save($this->getFullCachePath(), $this->getQuality(), $extension);

        return $this->getRelativeCachePath();
    }

	/**
	 * @return string
	 */
	private function getFullPath()
	{
		return getenv('PICTURE_WEB_ROOT') . '/' . trim($this->getPath(), '/');
    }
}
