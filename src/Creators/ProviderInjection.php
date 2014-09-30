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
 * Class helps register services in the dependency injection using the
 * provider. Service provider can return a string, array, object, or callable.
 *
 * Class ProviderCreator
 * @package GetSky\Phalcon\AutoloadServices\Creators
 */
class ProviderInjection extends AbstractInjection
{
    use CreatorTrait;

    /**
     * @return object
     */
    public function injection()
    {
        return $this->createObject()->getServices();
    }
}
