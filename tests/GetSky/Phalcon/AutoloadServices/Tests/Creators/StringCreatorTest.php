<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\StringCreator;
use Phalcon\Config;

class StringCreatorTest extends CreatorTest
{

    public function providerTypes()
    {
        return array(
            array(
                array('string' => 'Phalcon\Http\Response',
                'shared' => 1),
            ),
            array(
                array('string' => '%off%')
            )
        );
    }

    /**
     * @dataProvider providerTypes
     */
    public function testCreator($config)
    {
        $this->creator = new StringCreator($this->di,new Config($config));
    }

} 