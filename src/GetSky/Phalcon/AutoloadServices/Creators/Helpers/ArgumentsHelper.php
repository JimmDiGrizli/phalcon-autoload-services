<?php
namespace GetSky\Phalcon\AutoloadServices\Creators\Helpers;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\BadArguments;
use GetSky\Phalcon\AutoloadServices\Creators\ObjectCreator;

class ArgumentsHelper extends AbstractHelpers
{

    public function preparation()
    {
        $arguments = $this->getConfig();
        $array = null;

        foreach ($arguments as $argument) {
            foreach ($argument as $name => $value) {
                switch ($name) {
                    case 'var':
                    case 'parameter':
                        $array[] = $value;
                        break;
                    case 'object':
                    case 'obj':
                    case 'instance':
                        $creator = new ObjectCreator($this->di, $value);
                        $array[] = $creator->injection();
                        break;
                    case 'service':
                        $array[] = $this->di->get($value);
                        break;
                    case 'call':

                        break;
                    default:
                        throw new BadArguments(
                            "Argument type '{$name}' is not supported"
                        );
                }
            }
        }

        return $array;
    }
}