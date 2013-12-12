<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\ObjectCreator;
use Phalcon\Config;

class ObjectCreatorTest extends CreatorTest
{

    public function testCreator()
    {
        $this->assertInstanceOf('Service', $this->creator->injection());

        $config = new Config(['object' => '%off%']);
        $this->creator->setService($config);
        $this->assertNull($this->creator->injection());
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException
     */
    public function testClassNotFoundException()
    {
        $config = new Config(['object' => 'NotClass']);
        $this->creator->setService($config);
        $this->creator->injection();
    }

    protected function  setUp()
    {
        parent::setUp();
        $this->services = new Config(
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
        $this->creator = new ObjectCreator($this->di, $this->services);
    }
} 