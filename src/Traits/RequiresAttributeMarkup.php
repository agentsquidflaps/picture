<?php

namespace Agentsquidflaps\Picture\Traits;

/**
 * Trait RequiresAttributeMarkup
 * @package Agentsquidflaps\Picture\Traits
 */
trait RequiresAttributeMarkup
{
    /**
     * @param array $attributes
     * @return string
     */
    public function attributes(array $attributes)
    {
        return implode(' ', array_map(function ($k, $v) {
            return $k . '=\'' . $v . '\'';
        }, array_keys($attributes), $attributes));
    }
}
