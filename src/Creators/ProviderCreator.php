<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException;
use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotImplementsException;
use GetSky\Phalcon\AutoloadServices\Creators\Exception\MissClassNameException;
use GetSky\Phalcon\AutoloadServices\Creators\Helpers\ArgumentsHelper;
use GetSky\Phalcon\AutoloadServices\Creators\Helpers\CallHelper;
use ReflectionClass;

/**
 * Class helps register services in the dependency injection using the
 * provider. Service provider can return a string, array, object, or callable.
 *
 * Class ProviderCreator
 * @package GetSky\Phalcon\AutoloadServices\Creators
 */
class ProviderCreator extends AbstractCreator implements Injection
{

    /**
     * @throws ClassNotFoundException
     * @throws ClassNotImplementsException
     * @throws Exception\BadArgumentsException
     * @throws Exception\MethodNotFoundException
     * @throws Exception\ObjectNotFoundException
     * @throws MissClassNameException
     * @return mixed
     */
    public function injection()
    {
        $class = $this->getService()->get('provider');

        if ($class === null) {
            throw new MissClassNameException("The class name is not defined.");
        }

        if ($class === '%off%') {
            return null;
        }

        if (!class_exists($class)) {
            throw new ClassNotFoundException("{$class} is not not found.");
        }

        $reflector = new ReflectionClass($class);

        if (!$reflector->implementsInterface(
            'GetSky\Phalcon\AutoloadServices\Provider'
        )
        ) {
            throw new ClassNotImplementsException(
                "{$class} not implements the interface Provider."
            );
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
            $provider = $reflector->newInstanceArgs($arguments);
        } else {
            $provider = new $class;
        }

        if (is_array($calls) && $callHelper !== null) {
            $callHelper->ring($provider, $calls);
        }

        return $provider->getServices();
    }
}
