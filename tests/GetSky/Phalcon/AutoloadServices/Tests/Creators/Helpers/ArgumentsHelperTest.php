<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators\Helpers;

use CallService;
use GetSky\Phalcon\AutoloadServices\Creators\Helpers\ArgumentsHelper;
use Phalcon\Config;

/**
 * Class ArgumentsHelperTest
 * @package GetSky\Phalcon\AutoloadServices\Tests\Creators\Helpers
 */
class ArgumentsHelperTest extends HelperTest
{

    public function testPreparation()
    {
        $params = [
            '0' => 24,
            '1' => 21,
            '2' => $this->di,
            '3' => new CallService(),
            '4' => new CallService(),
            '5' => new CallService(),
            '6' => $this->di->get('tag'),
            '7' => $this->di->getShared('tag'),
            '8' => $this->di->getShared('tag')
        ];
        $this->assertEquals($params, $this->helper->preparation());

        $config = new Config(['0' => new Config(['var' => '%off%'])]);
        $this->helper->setConfig($config);
        $this->assertNull($this->helper->preparation());
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Creators\Exception\BadArgumentsException
     */
    public function testBadArgumentsException()
    {
        $config = new Config(
            ['test' => new Config(['test' => 'test'])]
        );
        $this->helper->setConfig($config);
        $this->helper->preparation();
        $this->helper->setConfig($this->config);
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Creators\Exception\MissClassNameException

    public function testMissClassNameExceptionException()
    {
        $config = new Config(
            [
                '0' => new Config(
                        ['object' => new Config(['fail' => 'CallService'])]
                    )
            ]
        );
        $this->helper->setConfig($config);
        $this->helper->preparation();
        $this->helper->setConfig($this->config);
    }
     */

    protected function setUp()
    {
        parent::setUp();
        $this->config = new Config(
            [
                '0' => new Config(['var' => '24']),
                '1' => new Config(['parameter' => '21']),
                '2' => new Config(['di' => 1]),
                '3' => new Config(
                        ['object' => new Config(['obj' => 'CallService'])]
                    ),
                '4' => new Config(
                        ['obj' => new Config(['instance' => 'CallService'])]
                    ),
                '5' => new Config(
                        ['instance' => new Config(['object' => 'CallService'])]
                    ),
                '6' => new Config(['service' => 'tag']),
                '7' => new Config(['shared-service' => 'tag']),
                '8' => new Config(['s-service' => 'tag']),
            ]
        );
        $this->helper = new ArgumentsHelper($this->di, $this->config);
    }
}