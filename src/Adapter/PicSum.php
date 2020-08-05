<?php

namespace Agentsquidflaps\Picture\Adapter;

use Agentsquidflaps\Picture\Source;

/**
 * Class PicSum
 * @package Agentsquidflaps\Picture\Adapter
 */
class PicSum extends Source
{
    const SOURCE_URL = 'https://picsum.photos/';

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
	    return self::SOURCE_URL."{$this->getWidth()}/{$this->getHeight()}?random";
    }

	/**
	 * @return bool
	 */
    public function isWebp()
    {
    	return false;
    }
}
