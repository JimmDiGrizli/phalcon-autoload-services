<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\ObjectCreator;
use Phalcon\Config;

class ObjectCreatorTest extends CreatorTest
{

    public function testCreator()
    {
        $this->assertInstanceOf('Service',$this->creator->injection());

        $config = new Config(array('object' => '%off%'));
        $this->creator->setService($config);
        $this->assertNull($this->creator->injection());
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException
     */
    public function testClassNotFoundException()
    {
        $config = new Config(array('object' => 'NotClass'));
        $this->creator->setService($config);
        $this->creator->injection();
    }

    protected function  setUp()
    {
        parent::setUp();
        $this->services = new Config(
            array(
                'object' => 'Service',
                'arg' => array(
                    '0' => array(
                        'var' => '24'
                    ),
                    '1' => array(
                        'object' => array(
                            'object' => 'Service',
                            'arg' => array(
                                '0' => array(
                                    'parameter' => '24'
                                ),
                            )
                        )
                    ),
                    '2' => array(
                        'service' => 'tag'
                    ),
                    '3' => array(
                        'di' => 1
                    )
                )
            )
        );
        $this->creator = new ObjectCreator($this->di, $this->services);
    }
} 