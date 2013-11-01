<?php
use GetSky\Phalcon\AutoloadServices\Provider;
use Phalcon\Mvc\Router;

class RouteProvider implements Provider
{
    protected $value = null;

    /**
     * @return callable
     */
    public function getServices()
    {
        return function () {
            if ($this->value === null) {
                $router = new Router();
            } else {
                $router = new \Phalcon\Acl\Role($this->value);
            }
            return $router;
        };
    }

    public function setValue($value = null)
    {
        $this->value = $value;
    }
}