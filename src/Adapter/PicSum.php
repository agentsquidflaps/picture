<?php

namespace Agentsquidflaps\Picture\Adapter;

use Agentsquidflaps\Picture\AbstractSource;

class PicSum extends AbstractSource
{
    private const SOURCE_URL = 'https://picsum.photos/';

	/**
	 * @return string
	 */
    public function get(): string
    {
        return self::SOURCE_URL."{$this->getWidth()}/{$this->getHeight()}?random";
    }

}
