<?php

namespace Agentsquidflaps\Picture\Traits;

/**
 * Trait ChecksForSetValues
 * @package Agentsquidflaps\Picture\Traits
 */
trait ChecksForSetValuesTrait
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
