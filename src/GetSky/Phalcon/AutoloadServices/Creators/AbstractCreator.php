<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use Phalcon\Config;
use Phalcon\DiInterface;

/**
 * Class AbstractCreator
 * @package GetSky\Phalcon\Bootstrap\Creators
 */
abstract class AbstractCreator
{

    protected $di;

    /**
     * @var Config Service configuration
     */
    protected $service;

    public function __construct(DiInterface $di, Config $service)
    {
        $this->di = $di;
        $this->service = $service;
    }

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
