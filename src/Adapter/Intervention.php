<?php

namespace Agentsquidflaps\Picture\Adapter;

use Agentsquidflaps\Picture\Source;
use Agentsquidflaps\Picture\Traits\isLocalTrait;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManagerStatic;

/**
 * Class Intervention
 * @package Agentsquidflaps\Picture\Adapter
 */
class Intervention extends Source
{
    use isLocalTrait;

    /**
     * @return string
     */
    public function get(): string
    {
        $extension = $this->getFormat() ?: $this->getExtension();

        if (file_exists($this->getFullCachePath())) {
            return $this->getRelativeCachePath();
        }

        $imageManager = ImageManagerStatic::configure(['driver' => 'gd']);
        $image = $imageManager->make($this->getFullPath());

        if ($this->getFit() === Source::FIT_COVER) {
            $image->fit($this->getWidth(), $this->getHeight(), null, $this->getPosition() ? Source::POSITIONS[$this->getPosition()] : 'center');
        } else {
            $image->resize($this->getWidth(), $this->getHeight(), function (Constraint $constraint) {
                if ($this->getFit() === Source::FIT_FILL) {
                    $constraint->upsize();
                } else {
                    $constraint->aspectRatio();
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
