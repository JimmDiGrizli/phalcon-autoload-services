<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators\Helpers;

use GetSky\Phalcon\AutoloadServices\Creators\Helpers\ArgumentsHelper;
use Phalcon\Config;

/**
 * Class ArgumentsHelperTest
 * @package GetSky\Phalcon\AutoloadServices\Tests\Creators\Helpers
 */
class ArgumentsHelperTest extends HelperTest
{

    public function  testPreparation()
    {

    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Creators\Exception\BadArguments
     */
    public function testBadArgumentsException()
    {
        $config = new Config(
            array('test' => new Config(array('test' => 'test')))
        );
        $this->helper->setConfig($config);
        $this->helper->preparation();
        $this->helper->setConfig($this->config);
    }

    protected function  setUp()
    {
        parent::setUp();
        $this->config = new Config(
            array('0' => new Config(array('var' => '24')))
        );
        $this->helper = new ArgumentsHelper($this->di, $this->config);
    }
}