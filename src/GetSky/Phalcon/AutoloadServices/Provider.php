<?php
namespace GetSky\Phalcon\AutoloadServices;

/**
 * Interface Provider
 * @package GetSky\Phalcon\Bootstrap
 */
interface Provider
{
    /**
     * @return callable
     */
    public function getServices();
} 