<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException;
use GetSky\Phalcon\AutoloadServices\Creators\Exception\MissClassNameException;
use Phalcon\Config;
use Phalcon\DiInterface;

/**
 * Class helps register services in the dependency injection using string.
 *
 * Class StringCreator
 * @package GetSky\Phalcon\AutoloadServices\Creators
 */
class StringInjection extends AbstractInjection
{
    /**
     * @return string
     */
    public function injection()
    {
        return $this->class;
    }
}
