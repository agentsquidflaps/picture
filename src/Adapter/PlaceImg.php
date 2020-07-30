<?php

namespace Agentsquidflaps\Picture\Adapter;

use Agentsquidflaps\Picture\Source;

class PlaceImg extends Source
{

    private const SOURCE_URL = 'https://placeimg.com/';

	/**
	 * @return string
	 */
    public function get(): string
    {
    	return $this->getPath();
    }

    public function getPath(): ?string
    {
        return self::SOURCE_URL."{$this->getWidth()}/{$this->getHeight()}";
    }

    public function isWebp(): ?bool
    {
    	return false;
    }

}
