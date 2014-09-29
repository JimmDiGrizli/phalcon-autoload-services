<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException;
use GetSky\Phalcon\AutoloadServices\Creators\Exception\MissClassNameException;
use GetSky\Phalcon\AutoloadServices\Creators\Helpers\ArgumentsHelper;
use GetSky\Phalcon\AutoloadServices\Creators\Helpers\CallHelper;
use Phalcon\Config;
use ReflectionClass;

/**
 * Class helps to prepare the object for registration in the dependency
 * injection. Allows you to create objects with arguments (objects, variables,
 * services) in the constructor and call methods with arguments (objects,
 * variables, services) after creation.
 *
 * Class ObjectCreator
 * @package GetSky\Phalcon\AutoloadServices\Creators
 */
class ObjectCreator extends AbstractCreator
{

    /**
     * @return object|null
     * @throws ClassNotFoundException
     * @throws MissClassNameException
     */
    public function injection()
    {
        $service = $this->getService();
        $class = $service->get('object', $service->get('obj', $service->get('instance')));

        if ($class === null) {
            throw new MissClassNameException("The class name is not defined.");
        }

        if ($class === '%off%') {
            return null;
        }

        if (!class_exists($class)) {
            throw new ClassNotFoundException("{$class} is not not found.");
        }

        $arguments = null;
        $argConfig = $service->get('arg');
        if ($argConfig !== null) {
            $argHelper = new ArgumentsHelper($this->di, $argConfig);
            $arguments = $argHelper->preparation();
        }

        $calls = null;
        $callHelper = null;
        $callConfig = $service->get('call');
        if ($callConfig !== null) {
            $callHelper = new CallHelper($this->di, $callConfig);
            $calls = $callHelper->preparation();
        }

        if (is_array($arguments)) {
            $reflector = new ReflectionClass($class);
            $object = $reflector->newInstanceArgs($arguments);
        } else {
            $object = new $class;
        }

        if (is_array($calls) && $callHelper !== null) {
            $callHelper->ring($object, $calls);
        }

        return $object;
    }
}
