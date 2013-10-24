<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use Phalcon\Config;

/**
 * Class AbstractCreator
 * @package GetSky\Phalcon\Bootstrap\Creators
 */
abstract class AbstractCreator
{

    /**
     * @var Config Service configuration
     */
    protected $service;

    /**
     * @param Config $service
     */
    public function setService(Config $service)
    {
        $this->service = $service;
    }

    /**
     * @return Config
     */
    public function getService()
    {
        return $this->service;
    }

    abstract public function injection();
}
