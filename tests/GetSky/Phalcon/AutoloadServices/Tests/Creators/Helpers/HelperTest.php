<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators\Helpers;

use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use Phalcon\DiInterface;
use PHPUnit_Framework_TestCase;
use GetSky\Phalcon\AutoloadServices\Creators\Helpers\AbstractHelper;

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

    protected function setUp()
    {
        $this->di = new FactoryDefault();
    }

    protected function tearDown()
    {
        $this->di = null;
    }

    abstract public function testPreparation();
}