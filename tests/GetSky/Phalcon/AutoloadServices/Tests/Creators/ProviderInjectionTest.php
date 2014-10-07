<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\ObjectInjection;
use GetSky\Phalcon\AutoloadServices\Creators\ProviderInjection;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use PHPUnit_Framework_TestCase;

class ProviderInjectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectInjection
     */
    private $creator;

    public function testExtendsAbstractInjection()
    {
        $this->assertInstanceOf(
            'GetSky\Phalcon\AutoloadServices\Creators\AbstractInjection',
            $this->creator
        );
    }

    public function testCreator()
    {
        $this->assertInstanceOf('Closure', $this->creator->injection());
    }

    protected function  setUp()
    {
        $this->creator = new ProviderInjection(
            $this->getMock('Phalcon\DI\FactoryDefault'),
            $this->getMock('Phalcon\Config'),
            'RouteProvider'
        );
    }
} 