<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\ProviderCreator;
use Phalcon\Config;

class ProviderCreatorTest extends CreatorTest
{
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