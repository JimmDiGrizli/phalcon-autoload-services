<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators;

use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use Phalcon\DiInterface;
use PHPUnit_Framework_TestCase;
use \GetSky\Phalcon\AutoloadServices\Creators\AbstractCreator;

/**
 * Class CreatorTest
 * @package GetSky\Phalcon\AutoloadServices\Tests\Creators
 */
abstract class CreatorTest extends PHPUnit_Framework_TestCase {

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

    protected function setUp()
    {
        $this->di = new FactoryDefault();
    }

    protected function tearDown()
    {
        $this->di = null;
    }
} 