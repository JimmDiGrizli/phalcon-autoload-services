<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\AbstractCreator;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use Phalcon\DiInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class CreatorTest
 * @package GetSky\Phalcon\AutoloadServices\Tests\Creators
 */
abstract class CreatorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractCreator
     */
    protected $creator = null;
    /**
     * @var Config
     */
    protected $services = null;
    /**
     * @var DiInterface
     */
    protected $di = null;

    public function testSetAndGetServices()
    {
        $save = $this->services;
        $this->creator->setService(new Config(['test' => 'test']));
        $this->assertArrayHasKey('test', $this->creator->getService());
        $this->services = $save;
    }

    protected function setUp()
    {
        $this->di = new FactoryDefault();
    }

    protected function tearDown()
    {
        $this->di = null;
    }
} 