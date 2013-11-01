<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException;
use GetSky\Phalcon\AutoloadServices\Creators\Helpers\ArgumentsHelper;
use GetSky\Phalcon\AutoloadServices\Creators\Helpers\CallHelper;
use ReflectionClass;
use Phalcon\Config;

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
     */
    public function injection()
    {
        $class = $this->getService()->get('object');

        if ($class === '%off%') {
            return null;
        }

        if (!class_exists($class)) {
            throw new ClassNotFoundException("{$class} is not not found.");
        }

        $arguments = null;
        $argConfig = $this->getService()->get('arg', null);
        if ($argConfig !== null) {
            $argHelper = new ArgumentsHelper($this->di, $argConfig);
            $arguments = $argHelper->preparation();
        }

        $calls = null;
        $callHelper = null;
        $callConfig = $this->getService()->get('call', null);
        if ($callConfig !== null) {
            $callHelper = new CallHelper($this->di, $callConfig);
            $calls = $callHelper->preparation();
        }

        if (is_array($arguments)) {
            $reflector = new ReflectionClass($class);
            $object = $reflector->newInstanceArgs($arguments);
        } else {
            $object = new $class;
            if (is_array($calls) && $callHelper !== null) {
                $callHelper->ring($object, $calls);
            }
        }

        return $object;
    }
}