<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use Phalcon\Config;
use Phalcon\DiInterface;

/**
 * Parent classes to help prepare lines, facilities and providers to be
 * registered in dependency injection.
 *
 * Class AbstractCreator
 * @package GetSky\Phalcon\AutoloadServices\Creators
 */
abstract class AbstractInjection
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
     * @var string
     */
    protected $class;

    /**
     * @param DiInterface $di
     * @param Config $service
     * @param $class
     */
    public function __construct(DiInterface $di, Config $service, $class)
    {
        $this->di = $di;
        $this->service = $service;
        $this->class = $class;
    }

    /**
     * Used to pass services in the dependency injection.
     * @return mixed
     */
    abstract public function injection();
}
