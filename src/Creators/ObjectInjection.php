<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException;
use GetSky\Phalcon\AutoloadServices\Creators\Exception\MissClassNameException;
use GetSky\Phalcon\AutoloadServices\Creators\Helpers\ArgumentsHelper;
use GetSky\Phalcon\AutoloadServices\Creators\Helpers\CallHelper;
use GetSky\Phalcon\AutoloadServices\Creators\Helpers\CreatorTrait;
use Phalcon\Config;
use Phalcon\DiInterface;
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
class ObjectInjection extends  AbstractInjection
{
    use CreatorTrait;

    /**
     * @return object
     */
    public function injection()
    {
        return $this->createObject();
    }
}
