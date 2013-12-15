<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators\Helpers;

use CallService;
use GetSky\Phalcon\AutoloadServices\Creators\Helpers\CallHelper;
use Phalcon\Config;

/**
 * Class CallHelperTest
 * @package GetSky\Phalcon\AutoloadServices\Tests\Creators\Helpers
 */
class CallHelperTest extends HelperTest
{

    /**
     * @var CallHelper
     */
    protected $helper;

    public function testPreparation()
    {
        $arguments = [
            '0' => [
                'method' => 'run',
                'arguments' => [
                    '0' => 240,
                    '1' => new CallService()
                ]
            ]

        ];

        $this->assertEquals($arguments, $this->helper->preparation());

        $config = new Config(['0' => new Config(['method' => '%off%'])]);
        $this->helper->setConfig($config);
        $this->assertNull($this->helper->preparation());
    }

    public function testRing()
    {
        $object = new CallService();
        $this->helper->ring(
            $object,
            [0 => ['method' => 'run', 'arguments' => ['25', 'object']]]
        );
        $test = new CallService();
        $test->run('25','object');
        $this->assertEquals($test, $object);
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Creators\Exception\ObjectNotFoundException
     */
    public function testObjectNotFoundException()
    {
        $this->helper->ring('object', array());
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Creators\Exception\MethodNotFoundException
     */
    public function testMethodNotFoundException()
    {
        $object = new CallService();
        $this->helper->ring($object, [0 => ['method' => 'fail']]);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->config = new Config(
            [
                '0' => new Config(
                        [
                            'method' => 'run',
                            'arg' => new Config(
                                    [
                                        '0' => new Config(['var' => '240']),
                                        '1' => new Config(
                                                ['object' => new Config(['obj' => 'CallService'])]
                                            )
                                    ]
                                )
                        ]
                    )
            ]
        );
        $this->helper = new CallHelper($this->di, $this->config);
    }
}