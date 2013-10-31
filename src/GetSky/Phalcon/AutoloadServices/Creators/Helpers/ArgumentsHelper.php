<?php
namespace GetSky\Phalcon\AutoloadServices\Creators\Helpers;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\BadArguments;
use GetSky\Phalcon\AutoloadServices\Creators\ObjectCreator;

/**
 * Class prepares arguments for transfer to methods or constructor
 *
 * Class ArgumentsHelper
 * @package GetSky\Phalcon\AutoloadServices\Creators\Helpers
 */
class ArgumentsHelper extends AbstractHelpers
{

    /**
     * @return array|null
     * @throws \GetSky\Phalcon\AutoloadServices\Creators\Exception\BadArguments
     */
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