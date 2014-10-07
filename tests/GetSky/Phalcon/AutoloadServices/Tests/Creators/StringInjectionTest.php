<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\StringInjection;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use PHPUnit_Framework_TestCase;

class StringInjectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var StringInjection
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
        $this->assertSame('Service', $this->creator->injection());
    }

    protected function  setUp()
    {
        $this->creator = new StringInjection(
            $this->getMock('Phalcon\DI\FactoryDefault'),
            $this->getMock('Phalcon\Config'),
            'Service'
        );
    }
} 