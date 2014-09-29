<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException;
use GetSky\Phalcon\AutoloadServices\Creators\Exception\MissClassNameException;
use GetSky\Phalcon\AutoloadServices\Exception\BadTypeException;
use Phalcon\Config;
use Phalcon\DiInterface;

class Creator
{

    /**
     * @var array Array with supported types of services
     */
    protected static $types = ['string', 'object','obj', 'instance', 'provider'];

    /**
     * @var DiInterface
     */
    private $di;
    /**
     * @var Config
     */
    private $service;
    /**
     * @var Injection
     */
    private $strategy;

    public function __construct(DiInterface $di, Config $service)
    {
        $this->di = $di;
        $this->service = $service;
        $this->updateStrategy();
    }

    /**
     * Used to pass services in the dependency injection.
     * @return mixed
     */
    public function injection()
    {
        return $this->strategy->injection();
    }

    public function updateStrategy()
    {
        $select = null;
        foreach (Creator::$types as $type) {
                $select = $type;
        }

        if ($this->isCreated($select)) {
            switch ($select){
                case 'object':
                case 'obj':
                case 'instance':
                    $this->strategy = new ObjectCreator($this->di, $this->service);
                    break;
                case 'string':
                    $this->strategy = new StringCreator($this->di, $this->service);
                    break;
                case 'provider':
                    $this->strategy = new ProviderCreator($this->di, $this->service);
                    break;
                default:
                    throw new BadTypeException("Incorrect type of service.");
            }
        }
    }

    protected function isCreated($type)
    {
        $class = $this->service->get($type);

        if ($class === null) {
            throw new MissClassNameException("The class name is not defined.");
        }

        if ($class === '%off%') {
            return false;
        }

        if (!class_exists($class)) {
            throw new ClassNotFoundException("{$class} is not not found.");
        }

        return true;
    }

    /**
     * @return Config
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param Config $service
     */
    public function setService($service)
    {
        $this->service = $service;
        $this->updateStrategy();
    }

    /**
     * @return DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * @param DiInterface $di
     */
    public function setDi($di)
    {
        $this->di = $di;
    }
}
