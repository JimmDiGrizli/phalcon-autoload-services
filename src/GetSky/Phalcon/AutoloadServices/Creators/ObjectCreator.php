<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException;
use ReflectionClass;

class ObjectCreator extends AbstractCreator
{

    public function injection()
    {
        $class = $this->getService()->get('object');

        if (!class_exists($class)) {
            throw new ClassNotFoundException("{$class} is not not found.");
        }

        $arguments = $this->getService()->get('arg');

        $array = null;
        foreach ($arguments as $argument) {
            foreach ($argument as $name =>$value) {
                switch ($name) {
                    case 'var':
                    case 'parameter':
                        $array[] = $value;
                        break;
                    case 'object':
                    case 'obj':
                    case 'instance':
                        $creator = new ObjectCreator();
                        $creator->setService($value);
                        $array[] = $creator->injection();
                        break;
                }
            }
        }
        if (is_array($array)) {
            $reflector = new ReflectionClass($class);
            $object = $reflector->newInstanceArgs($array);
        } else {
            $object = new $class;
        }

        return $object;
    }
}