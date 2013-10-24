<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException;

class StringCreator extends AbstractCreator
{

    public function injection()
    {
        $class = $this->getService()->get('string');

        if (!class_exists($class)) {
            throw new ClassNotFoundException("{$class} is not not found.");
        }

        return $class;
    }
} 