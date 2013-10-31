<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException;
use
    GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotImplementsException;
use GetSky\Phalcon\AutoloadServices\Provider;

/**
 * Class helps register services in the dependency injection using the
 * provider. Service provider can return a string, array, object, or callable.
 *
 * Class ProviderCreator
 * @package GetSky\Phalcon\AutoloadServices\Creators
 */
class ProviderCreator extends AbstractCreator
{

    /**
     * @return mixed
     * @throws Exception\ClassNotImplementsException
     * @throws Exception\ClassNotFoundException
     */
    public function injection()
    {
        $class = $this->getService()->get('provider');

        if ($class === '%off%') {
            return null;
        }

        if (!class_exists($class)) {
            throw new ClassNotFoundException("{$class} is not not found.");
        }

        $provider = new $class();

        if (!$provider instanceof Provider) {
            throw new ClassNotImplementsException("{$class} not implements
            the interface Provider.");
        }

        return $provider->getServices();
    }
}