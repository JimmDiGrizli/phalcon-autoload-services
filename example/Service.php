<?php
use Phalcon\Mvc\Router;

class Service
{

    protected $value;

    protected $service;

    protected $route;

    protected $di;

    public function __construct(
        $value,
        $service = null,
        $route = null,
        $di = null
    ) {
        $this->service = $service;
        $this->value = $value;
        $this->route = $route;
        $this->di = $di;
    }

    public function run()
    {

    }
}