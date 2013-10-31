<?php
namespace GetSky\Phalcon\AutoloadServices;

/**
 * Interface provider, which should be inherited to create a new service.
 *
 * Interface Provider
 * @package GetSky\Phalcon\Bootstrap
 */
interface Provider
{

    /**
     * @return mixed
     */
    public function getServices();
} 