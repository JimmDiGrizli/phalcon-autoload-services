<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\ObjectInjection;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use PHPUnit_Framework_TestCase;

class ObjectInjectionTest extends PHPUnit_Framework_TestCase
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
        $this->assertInstanceOf('Service', $this->creator->injection());
    }

    protected function  setUp()
    {
        $services = new Config(
            [
                'object' => 'Service',
                'arg' => [
                    '0' => ['var' => '24'],
                    '1' => [
                        'object' => [
                            'object' => 'Service',
                            'arg' => [
                                '0' => [
                                    'parameter' => '24'
                                ],
                            ]
                        ]
                    ],
                    '2' => ['service' => 'tag'],
                    '3' => ['di' => 1]
                ]
            ]
        );
        $this->creator = new ObjectInjection(new FactoryDefault(), $services, 'Service');
    }
} 