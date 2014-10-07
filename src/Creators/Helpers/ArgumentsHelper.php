<?php
namespace GetSky\Phalcon\AutoloadServices\Creators\Helpers;

use GetSky\Phalcon\AutoloadServices\Creators\Creator;
use GetSky\Phalcon\AutoloadServices\Creators\Exception\BadArgumentsException;
use GetSky\Phalcon\AutoloadServices\Creators\ObjectCreator;
use GetSky\Phalcon\AutoloadServices\Creators\ObjectInjection;

/**
 * Class prepares arguments for transfer to methods or constructor
 *
 * Class ArgumentsHelper
 * @package GetSky\Phalcon\AutoloadServices\Creators\Helpers
 */
class ArgumentsHelper extends AbstractHelper
{

    /**
     * @return array|null
     * @throws \GetSky\Phalcon\AutoloadServices\Creators\Exception\BadArgumentsException
     */
    public function preparation()
    {
        $array = null;
        $arguments = $this->getConfig();

        if ($arguments === null) {
            return $array;
        }

        foreach ($arguments as $argument) {
            foreach ($argument as $name => $value) {
                if ($value === '%off%') {
                    continue;
                }
                switch ($name) {
                    case 'var':
                    case 'parameter':
                        $array[] = $value;
                        break;
                    case 'object':
                    case 'obj':
                    case 'instance':
                        $creator = new Creator($this->di);
                        $creator->setService($value);
                        $array[] = $creator->injection();
                        break;
                    case 'service':
                        $array[] = $this->di->get($value);
                        break;
                    case 'shared-service':
                    case 's-service':
                        $array[] = $this->di->getShared($value);
                        break;
                    case 'di':
                        $array[] = $this->di;
                        break;
                    default:
                        throw new BadArgumentsException(
                            "Argument type '{$name}' is not supported"
                        );
                }
            }
        }

        return $array;
    }
}
