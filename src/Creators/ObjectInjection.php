<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

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
 * Class ObjectInjection
 * @package GetSky\Phalcon\AutoloadServices\Creators
 */
class ObjectInjection extends AbstractInjection
{

    /**
     * @return object
     */
    public function injection()
    {
        return $this->createObject();
    }

    public function createObject()
    {
        $argumentsHelper = new ArgumentsHelper($this->di, $this->service->get('arg'));
        $callHelper = new CallHelper($this->di, $this->service->get('call'));

        if ($arguments = $argumentsHelper->preparation()) {
            $reflector = new ReflectionClass($this->class);
            $object = $reflector->newInstanceArgs($arguments);
        } else {
            $object = new $this->class;
        }

        if ($calls = $callHelper->preparation()) {
            $callHelper->ring($object, $calls);
        }

        return $object;
    }
}
