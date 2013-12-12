<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\StringCreator;
use Phalcon\Config;

class StringCreatorTest extends CreatorTest
{

    public function testCreator()
    {
        $this->assertSame('Phalcon\Http\Response', $this->creator->injection());

        $config = new Config(['string' => '%off%']);
        $this->creator->setService($config);
        $this->assertNull($this->creator->injection());
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException
     */
    public function testClassNotFoundException()
    {
        $config = new Config(['string' => 'NotClass']);
        $this->creator->setService($config);
        $this->creator->injection();
    }

    protected function  setUp()
    {
        parent::setUp();
        $this->services = new Config(
            [
                'string' => 'Phalcon\Http\Response',
                'shared' => 1
            ]
        );
        $this->creator = new StringCreator($this->di, $this->services);
    }
} 