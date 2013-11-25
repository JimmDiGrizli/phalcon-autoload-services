<?php
namespace GetSky\Phalcon\AutoloadServices\Tests;

use GetSky\Phalcon\AutoloadServices\Registrant;
use Phalcon\Config;

class RegistrantTest extends \PHPUnit_Framework_TestCase
{

    public function testIsInjectionAwareInterface()
    {
        $config = new Config(array());

        $this->assertInstanceOf(
            'Phalcon\DI\InjectionAwareInterface',
            new Registrant($config)
        );
    }

} 