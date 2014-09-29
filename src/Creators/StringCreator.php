<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException;
use GetSky\Phalcon\AutoloadServices\Creators\Exception\MissClassNameException;

/**
 * Class helps register services in the dependency injection using string.
 *
 * Class StringCreator
 * @package GetSky\Phalcon\AutoloadServices\Creators
 */
class StringCreator extends AbstractCreator implements Injection
{

    /**
     * @throws ClassNotFoundException
     * @throws MissClassNameException
     * @return string|null
     */
    public function injection()
    {
        $class = $this->getService()->get('string');

        if ($class === null) {
            throw new MissClassNameException("The class name is not defined.");
        }


        if ($class === '%off%') {
            return null;
        }

        if (!class_exists($class)) {
            throw new ClassNotFoundException("{$class} is not not found.");
        }

        return $class;
    }
}
