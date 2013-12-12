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