<?php
use GetSky\Phalcon\AutoloadServices\Provider;
use Phalcon\Mvc\Router;

class Service
{
    protected $value;

    protected $service;

    public function __construct($value, $service = null)
    {
        $this->service = $service;
        $this->value = $value;
    }
}