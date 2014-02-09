<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators\Helpers;

use GetSky\Phalcon\AutoloadServices\Creators\Helpers\AbstractHelper;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use Phalcon\DiInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class HelperTest
 * @package GetSky\Phalcon\AutoloadServices\Tests\Creators\Helpers
 */
abstract class HelperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractHelper
     */
    protected $helper = null;
    /**
     * @var Config
     */
    protected $config = null;
    /**
     * @var DiInterface
     */
    protected $di = null;

    public function testSetAndGetConfig()
    {
        $save = $this->config;
        $this->helper->setConfig(new Config(['test' => 'test']));
        $this->assertArrayHasKey('test', $this->helper->getConfig());
        $this->services = $save;
    }

    abstract public function testPreparation();

    protected function setUp()
    {
        $this->di = new FactoryDefault();
    }

    protected function tearDown()
    {
        $this->di = null;
    }
}
