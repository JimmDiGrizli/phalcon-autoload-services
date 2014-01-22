<?php
namespace GetSky\Phalcon\AutoloadServices;

use GetSky\Phalcon\AutoloadServices\Creators\AbstractCreator;
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
     * Sets the dependency injector
     *
     * @param DiInterface $dependencyInjector
     */
    public function setDI($dependencyInjector)
    {
        $this->di = $dependencyInjector;
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

            $type = 'GetSky\\Phalcon\\AutoloadServices\\Creators\\' .
                ucfirst(
                    $this->findType($service, $name) . 'Creator'
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
     * Returns the internal dependency injector
     *
     * @return DiInterface
     */
    public function getDI()
    {
        return $this->di;
    }

    /**
     * @param Config $service
     * @param $name
     * @return mixed
     * @throws Exception\BadTypeException
     */
    protected function findType(Config $service, $name)
    {

        foreach ($this->types as $type) {
            if ($service->get($type, null) !== null) {

                return $type;

            }
        }

        throw new BadTypeException("Incorrect type of service '{$name}'.");
    }

}