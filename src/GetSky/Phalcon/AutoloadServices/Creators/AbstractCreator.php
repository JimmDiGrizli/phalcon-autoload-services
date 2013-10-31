<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use Phalcon\Config;
use Phalcon\DiInterface;

/**
 * Parent classes to help prepare lines, facilities and providers to be
 * registered in dependency injection.
 *
 * Class AbstractCreator
 * @package GetSky\Phalcon\Bootstrap\Creators
 */
abstract class AbstractCreator
{

    /**
     * @var DiInterface Dependency Injectors
     */
    protected $di;

    /**
     * @var Config Service configuration
     */
    protected $service;

    /**
     * @param DiInterface $di
     * @param Config $service
     */
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

    /**
     * Used to pass services in the dependency injection.
     * @return mixed
     */
    abstract public function injection();
}