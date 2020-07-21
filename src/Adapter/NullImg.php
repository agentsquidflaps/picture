<?php

namespace Concrete\Package\Picture\Adapter\NullImg;

use Agentsquidflaps\Picture\AbstractSource;

/**
 * Class NullImg
 * Primarily for testing
 * @package Concrete\Package\Picture\Adapter\NullImg
 */
class NullImg extends AbstractSource
{
	/**
	 * @return string
	 */
    public function get(): string
    {
        return $this->getPath();
    }

}
