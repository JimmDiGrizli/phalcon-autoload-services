<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException;
use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotImplementsException;
use GetSky\Phalcon\AutoloadServices\Provider;

class ProviderCreator extends AbstractCreator
{

    public function injection()
    {
        $class = $this->getService()->get('provider');

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