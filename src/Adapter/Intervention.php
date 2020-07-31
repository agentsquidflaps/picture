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

		$image = $imageManager->make($this->getFullPath());
		$callbackFunction = null;

		if ($this->getFit() === Source::FIT_CONTAIN) {
			$image->fit($this->getWidth(), $this->getHeight(), null, $this->getPosition() ? Source::POSITIONS[$this->getPosition()] : 'center');
		} else {
			$image->resize($this->getWidth(), $this->getHeight(), function ($constraint) {
				$constraint->aspectRatio();

				if ($this->getFit() === Source::FIT_FILL) {
					$constraint->upsize();
				}
			});
		}

		$image->save($this->getFullCachePath(), $this->getQuality(), $extension);

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
