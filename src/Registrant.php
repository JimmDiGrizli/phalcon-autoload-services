<?php
namespace GetSky\Phalcon\AutoloadServices;

use GetSky\Phalcon\AutoloadServices\Creators\AbstractCreator;
use GetSky\Phalcon\AutoloadServices\Creators\AbstractInjection;
use GetSky\Phalcon\AutoloadServices\Creators\Creator;
use GetSky\Phalcon\AutoloadServices\Exception\BadTypeException;
use GetSky\Phalcon\AutoloadServices\Exception\DiNotFoundException;
use Phalcon\Config;
use Phalcon\DI\InjectionAwareInterface;
use Phalcon\DiInterface;

/**
 * Class Registrant
 * @package GetSky\Phalcon\AutoloadServices
 */
class Registrant implements InjectionAwareInterface
{

    /**
     * @var array Array with supported types of services
     */
    protected static $types = ['string', 'object', 'provider'];
    /**
     * @var DiInterface
     */
    protected $di;
    /**
     * @var Config|null
     */
    protected $services;

    /**
     * @param Config $services
     */
    public function __construct(Config $services)
    {
        $this->setServices($services);
    }

    /**
     * Registration services in the dependency injector
     */
    public function registration()
    {
        /**
         * @var Config $settings
         */
        if ($this->getDI() === null) {
            throw new DiNotFoundException("DI can't be found.");
        }

        $creator = new Creator($this->di);

        foreach ($this->services as $name => $settings) {
            $creator->setService($settings);
            $service = $creator->injection();

            if ($service !== null) {
                $call = $settings->get('shared') ? 'setShared' : 'set';
                $this->getDI()->$call($name, $service);
            }
        }
        $this->services = null;
    }

    /**
     * @return Config
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param Config $services
     */
    public function setServices(Config $services)
    {
        $this->services = $services;
    }

    /**
     * Returns the internal dependency injector
     *
     * @return DiInterface
     */
    public function getDI()
    {
        return $this->di;
    }

    /**
     * Sets the dependency injector
     *
     * @param DiInterface $dependencyInjector
     */
    public function setDI($dependencyInjector)
    {
        $this->di = $dependencyInjector;
    }
}
