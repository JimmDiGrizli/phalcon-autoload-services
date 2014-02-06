<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException;

/**
 * Class helps register services in the dependency injection using string.
 *
 * Class StringCreator
 * @package GetSky\Phalcon\AutoloadServices\Creators
 */
class StringCreator extends AbstractCreator
{

    /**
     * @return string|null
     * @throws Exception\ClassNotFoundException
     */
    public function injection()
    {
        $class = $this->getService()->get('string');

        if ($class === '%off%') {
            return null;
        }

        if (!class_exists($class)) {
            throw new ClassNotFoundException("{$class} is not not found.");
        }

        return $class;
    }
}
