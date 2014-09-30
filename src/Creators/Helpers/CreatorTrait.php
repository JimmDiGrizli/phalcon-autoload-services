<?php
namespace GetSky\Phalcon\AutoloadServices\Creators\Helpers;

use Phalcon\Config;
use ReflectionClass;

trait CreatorTrait
{

    public function createObject()
    {
        $argumentsHelper = new ArgumentsHelper($this->di, $this->service->get('arg'));
        $callHelper =  new CallHelper($this->di, $this->service->get('call'));

        if ($arguments = $argumentsHelper->preparation()) {
            $reflector = new ReflectionClass($this->class);
            $object = $reflector->newInstanceArgs($arguments);
        } else {
            $object = new $this->class;
        }

        if ($calls = $callHelper->preparation()) {
            $callHelper->ring($object, $calls);
        }
        return $object;
    }
}
