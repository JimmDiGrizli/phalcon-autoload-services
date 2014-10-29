<?php
namespace GetSky\Phalcon\AutoloadServices\Creators;

use Phalcon\Config;

/**
 * Class helps register services in the dependency injection using the
 * provider. Service provider can return a string, array, object, or callable.
 *
 * Class ProviderInjection
 * @package GetSky\Phalcon\AutoloadServices\Creators
 */
class ProviderInjection extends AbstractInjection
{

    /**
     * @return object
     */
    public function injection()
    {
        return $this->create()->injection()->getServices();
    }

    protected function create()
    {
        return new ObjectInjection($this->di, $this->service, $this->class);
    }
}
