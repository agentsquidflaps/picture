<?php

namespace Agentsquidflaps\Picture\Traits;

/**
 * Trait ChecksForSetValues
 * @package Agentsquidflaps\Picture\Traits
 */
trait ChecksForSetValues
{
	/**
	 * @param $value
	 * @return bool
	 */
	protected function valueIsSet($value)
	{
		return !($value === null || $value === '');
	}
}
