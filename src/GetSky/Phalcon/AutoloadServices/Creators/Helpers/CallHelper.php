<?php
namespace GetSky\Phalcon\AutoloadServices\Creators\Helpers;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\MethodNotFoundArguments;
use GetSky\Phalcon\AutoloadServices\Creators\Exception\ObjectNotFoundArguments;
use Phalcon\Config;

class CallHelper extends AbstractHelpers
{

    public function preparation()
    {
        /** @var $calls Config[] */
        $calls = $this->getConfig();
        $array = null;

        foreach ($calls as $key => $call) {

            $array[$key]['method'] = $call->get('method');

            $argConfig = $call->get('arg', null);

            if ($argConfig !== null) {
                $argHelper = new ArgumentsHelper($this->di, $argConfig);
                $array[$key]['arguments'] = $argHelper->preparation();
            }
        }

        return $array;
    }

    public function ring($object, array $calls)
    {

        if (!is_object($object)) {
            throw new ObjectNotFoundArguments ("{$object} is not an object ");
        }

        foreach ($calls as $call) {
            if (!method_exists($object, $call['method'])) {
                $nameClass = get_class($object);
                throw new MethodNotFoundArguments ("{$call['method']} not
                found in class {$nameClass}");
            }

            if (is_array($call['arguments'])) {
                call_user_func_array(
                    array($object, $call['method']),
                    $call['arguments']
                );
            } else {
                $object->{$call['method']}();
            }
        }

    }
}