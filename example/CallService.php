<?php
use Phalcon\Mvc\Router;

class CallService
{

    protected $class = null;
    protected $var = null;

    public function run($var, $object)
    {
        $this->class = $object;
        $this->var = $var;
    }
}