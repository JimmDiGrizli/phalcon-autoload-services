<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\AbstractCreator;
use GetSky\Phalcon\AutoloadServices\Creators\Creator;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use Phalcon\DiInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class CreatorTest
 * @package GetSky\Phalcon\AutoloadServices\Tests\Creators
 */
class CreatorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Creator
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
        $this->creator->setService(new Config(['test' => ['string'=>'class']]));
        $this->assertArrayHasKey('test', $this->creator->getService());
        $this->services = $save;
    }

    protected function setUp()
    {
        $this->creator = new Creator(new FactoryDefault());
    }

    protected function tearDown()
    {
        $this->di = null;
    }
} 