<?php

namespace Agentsquidflaps\Picture\Adapter;

use Agentsquidflaps\Picture\Source;

class PlaceImg extends Source
{

    private const SOURCE_URL = 'http://placeimg.com/';

	/**
	 * @return string
	 */
    public function get(): string
    {
        return self::SOURCE_URL."{$this->getWidth()}/{$this->getHeight()}";
    }

}
