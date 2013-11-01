<?php
use Phalcon\Mvc\Router;

class Service
{

    protected $value;

    protected $service;

    protected $route;

    public function __construct(
        $value,
        $service = null,
        $route = null
    ) {
        $this->service = $service;
        $this->value = $value;
        $this->route = $route;
    }
}