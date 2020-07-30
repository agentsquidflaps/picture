<?php

namespace Agentsquidflaps\Picture\Adapter\NullImg;

use Agentsquidflaps\Picture\Source;

/**
 * Class NullImg
 * Primarily for testing
 * @package Agentsquidflaps\Picture\Adapter\NullImg
 */
class NullImg extends Source
{
	/**
	 * @return string
	 */
    public function get(): string
    {
        return $this->getPath();
    }
}
