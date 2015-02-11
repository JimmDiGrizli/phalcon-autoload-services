<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException;
use GetSky\Phalcon\AutoloadServices\Creators\Exception\MissClassNameException;
use Phalcon\Config;
use Phalcon\DiInterface;

/**
 * Class helps register services in the dependency injection using array.
 *
 * Class StringInjection
 * @package GetSky\Phalcon\AutoloadServices\Creators
 */
class ArrayInjection extends AbstractInjection
{
    /**
     * @return string
     */
    public function injection()
    {
        return $this->class;
    }
}
