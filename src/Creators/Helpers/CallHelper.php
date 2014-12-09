<?php
namespace GetSky\Phalcon\AutoloadServices\Creators\Helpers;

use GetSky\Phalcon\AutoloadServices\Creators\Exception\MethodNotFoundException;
use GetSky\Phalcon\AutoloadServices\Creators\Exception\ObjectNotFoundException;
use Phalcon\Config;

/**
 * Helper who makes a call methods of the desired object
 *
 * Class CallHelper
 * @package GetSky\Phalcon\AutoloadServices\Creators\Helpers
 */
class CallHelper extends AbstractHelper
{

    /**
     * @return null|array
     */
    public function preparation()
    {
        /** @var $calls Config[] */
        $calls = $this->getConfig();
        $array = null;

        if ($calls === null) {
            return $array;
        }

        foreach ($calls as $key => $call) {
            if ($call->get('method') === '%off%') {
                continue;
            }

            $array[$key]['method'] = $call->get('method');

            $argConfig = $call->get('arg', null);

            if ($argConfig !== null) {
                $argHelper = new ArgumentsHelper($this->di, $argConfig);
                $array[$key]['arguments'] = $argHelper->preparation();
            }
        }

        return $array;
    }

    /**
     * @param object $object
     * @param array $calls
     * @throws \GetSky\Phalcon\AutoloadServices\Creators\Exception\ObjectNotFoundException
     * @throws \GetSky\Phalcon\AutoloadServices\Creators\Exception\MethodNotFoundException
     */
    public function ring($object, array $calls)
    {
        if (!is_object($object)) {
            throw new ObjectNotFoundException("{$object} is not an object ");
        }

        foreach ($calls as $call) {
            if (!method_exists($object, $call['method'])) {
                $nameClass = get_class($object);
                throw new MethodNotFoundException(
                    "{$call['method']} not found in class {$nameClass}"
                );
            }

            if (isset($call['arguments'])) {
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
