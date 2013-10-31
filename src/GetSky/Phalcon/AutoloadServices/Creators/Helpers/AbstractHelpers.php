<?php
namespace GetSky\Phalcon\AutoloadServices\Creators\Helpers;

use Phalcon\Config;
use Phalcon\DiInterface;

/**
 * Parent class of helpers.
 *
 * Class AbstractHelpers
 * @package GetSky\Phalcon\AutoloadServices\Creators\Helpers
 */
abstract class AbstractHelpers
{

    /**
     * @var DiInterface Dependency Injectors
     */
    protected $di;

    /**
     * @var Config Configuration of the unit
     */
    protected $config;

    /**
     * @param DiInterface $di
     * @param Config $config
     */
    public function __construct(DiInterface $di, Config $config)
    {
        $this->di = $di;
        $this->config = $config;
    }

    /**
     * @param Config $config
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return array
     */
    abstract public function preparation();

} 