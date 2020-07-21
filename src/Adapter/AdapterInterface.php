<?php

namespace Agentsquidflaps\Picture\Adapter;

/**
 * Interface AdapterInterface
 * @package Agentsquidflaps\Picture\Adapter
 */
interface AdapterInterface {
    /**
     * @return string
     */
    public function get(): string;
}
