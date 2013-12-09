<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\ProviderCreator;
use Phalcon\Config;

class ProviderCreatorTest extends CreatorTest
{
    public function testCreator()
    {
        $config = new Config(
            array(
                'provider' => 'RouteProvider'
            )
        );
        $this->creator = new ProviderCreator($this->di, $config);
        $this->di->set('testProviderCreator', $this->creator->injection());
        $this->assertInstanceOf(
            'Phalcon\Mvc\Router',
            $this->di->get('testProviderCreator')
        );

        $config = new Config(array('provider' => '%off%'));
        $this->creator = new ProviderCreator($this->di, $config);
        $this->assertNull($this->creator->injection());
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException
     */
    public function testClassNotFoundException()
    {
        $config = new Config(array('provider' => 'NotClass'));
        $this->creator = new ProviderCreator($this->di, $config);
        $this->creator->injection();
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotImplementsException
     */
    public function testClassNotImplementsException()
    {
        $config = new Config(array('provider' => 'Phalcon\Config'));
        $this->creator = new ProviderCreator($this->di, $config);
        $this->creator->injection();
    }
} 