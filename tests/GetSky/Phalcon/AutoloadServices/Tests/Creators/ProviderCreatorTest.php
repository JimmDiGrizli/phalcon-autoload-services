<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\ProviderCreator;
use Phalcon\Config;

class ProviderCreatorTest extends CreatorTest
{
    public function testCreator()
    {
        $this->di->set('testProviderCreator', $this->creator->injection());
        $this->assertInstanceOf(
            'Phalcon\Mvc\Router',
            $this->di->get('testProviderCreator')
        );

        $config = new Config(['provider' => '%off%']);
        $this->creator->setService($config);
        $this->assertNull($this->creator->injection());
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException
     */
    public function testClassNotFoundException()
    {
        $config = new Config(['provider' => 'NotClass']);
        $this->creator->setService($config);
        $this->creator->injection();
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotImplementsException
     */
    public function testClassNotImplementsException()
    {
        $config = new Config(['provider' => 'Phalcon\Config']);
        $this->creator->setService($config);
        $this->creator->injection();
    }

    protected function  setUp()
    {
        parent::setUp();
        $this->services = new Config(
            array(
                'provider' => 'RouteProvider'
            )
        );
        $this->creator = new ProviderCreator($this->di, $this->services);
    }
} 