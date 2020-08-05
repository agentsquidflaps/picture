<?php

namespace Agentsquidflaps\Picture\Adapter;

use Agentsquidflaps\Picture\Source;

/**
 * Class PlaceImg
 * @package Agentsquidflaps\Picture\Adapter
 */
class PlaceImg extends Source
{

    const SOURCE_URL = 'https://placeimg.com/';

	/**
	 * @return string
	 */
    public function get()
    {
    	return $this->getPath();
    }

	/**
	 * @return string
	 */
    public function getPath()
    {
        return self::SOURCE_URL."{$this->getWidth()}/{$this->getHeight()}";
    }

	/**
	 * @return bool
	 */
    public function isWebp()
    {
    	return false;
    }

}
