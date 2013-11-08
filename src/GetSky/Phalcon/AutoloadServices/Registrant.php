<?php
namespace GetSky\Phalcon\AutoloadServices;

use GetSky\Phalcon\AutoloadServices\Exception\BadTypeException;
use GetSky\Phalcon\AutoloadServices\Exception\DiNotFoundException;
use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\DI\InjectionAwareInterface;
use GetSky\Phalcon\AutoloadServices\Creators\AbstractCreator;

/**
 * Class Registrant
 * @package GetSky\Phalcon\AutoloadServices
 */
class Registrant implements InjectionAwareInterface
{

    /**
     * @var DiInterface
     */
    protected $di;

    /**
     * @var Config|null
     */
    protected $services;

    /**
     * @var array Array with supported types of services
     */
    protected $types = ['string', 'object', 'provider'];

    /**
     * @param Config $services
     */
    public function __construct(Config $services)
    {
        $this->setServices($services);
    }

    /**
     * @param Config $services
     */
    public function setServices(Config $services)
    {
        $this->services = $services;
    }

    /**
     * @return Config
     */
    public function getServices()
    {
        return $this->services;
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
     * Registration services in the dependency injector
     */
    public function registration()
    {
        /**
         * @var Config $service
         * @var AbstractCreator $creator
         */

        if ($this->getDI() === null) {
            throw new DiNotFoundException("DI can't be found.");

        }

        foreach ($this->services as $name => $service) {

            $link = null;
            $type = 'GetSky\\Phalcon\\AutoloadServices\\Creators\\' .
                ucfirst(
                    $this->findType($service, $link, $name) . 'Creator'
                );

            $creator = new $type($this->getDI(), $service);

            $call = 'set';
            if ($service->get('shared') !== null) {
                $call .= 'Shared';
            }

            $service = $creator->injection();
            if ($service !== null) {
                $this->getDI()->$call($name, $service);
            }
        }
        $this->services = null;
    }

    /**
     * @param Config $service
     * @param $link
     * @param $name
     * @return mixed
     * @throws BadTypeException
     */
    protected function findType(Config $service, &$link, $name)
    {
        $link = null;
        foreach ($this->types as $type) {
            $link = $service->get($type, null);
            if ($link !== null) {
                return $type;
            }
        }
        throw new BadTypeException("Incorrect type of service '{$name}'.");
    }

}