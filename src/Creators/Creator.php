<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException;
use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotImplementsException;
use GetSky\Phalcon\AutoloadServices\Creators\Exception\MissClassNameException;
use Phalcon\Config;
use Phalcon\DiInterface;
use ReflectionClass;

class Creator
{

    /**
     * @var array Array with supported types of services
     */
    protected static $types = ['string', 'object','obj', 'instance', 'provider'];

    /**
     * @var DiInterface
     */
    protected $di;
    /**
     * @var Config
     */
    protected $service;
    /**
     * @var AbstractInjection
     */
    protected $strategy;

    /**
     * @param DiInterface $di
     */
    public function __construct(DiInterface $di)
    {
        $this->di = $di;
    }

    /**
     * Used to pass services in the dependency injection.
     * @return mixed
     */
    public function injection()
    {
        if ($this->strategy === null) {
            return null;
        }
        return $this->strategy->injection();
    }

    protected function updateStrategy()
    {
        $select = null;
        $class = null;
        $isArray = null;
        $isCreated = true;

        foreach (Creator::$types as $type) {
            if ($this->service->get($type) !== null) {
                $select = $type;
                $class = $this->service->get($type);
            }
        }

        if ($select !== null) {
            $isCreated = $this->isCreated($select);
        }

        if ($isCreated) {
            switch ($select){
                case 'object':
                case 'obj':
                case 'instance':
                    $this->strategy = new ObjectInjection($this->di, $this->service, $class);
                    break;
                case 'string':
                    $this->strategy = new StringInjection($this->di, $this->service, $class);
                    break;
                case 'provider':
                    $this->strategy = new ProviderInjection($this->di, $this->service, $class);
                    break;
                default:
                    $this->strategy = new ArrayInjection($this->di, $this->service, $class);
                    break;
            }
        }
    }

    protected function isCreated($type)
    {
        $class = $this->service->get($type);

        if ($class == null) {
            throw new MissClassNameException("The class name is not defined.");
        }

        if ($class === '%off%') {
            return false;
        }

        if (!class_exists($class)) {
            throw new ClassNotFoundException("{$class} is not not found.");
        }

        if ($type == 'provider') {
            $reflector = new ReflectionClass($class);
            if (!$reflector->implementsInterface('GetSky\Phalcon\AutoloadServices\Provider')) {
                throw new ClassNotImplementsException("{$class} not implements the interface Provider.");
            }
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
}
