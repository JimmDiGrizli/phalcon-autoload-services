<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Creator;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
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

    public function testSetAndGetServices()
    {
        $this->creator->setService(new Config(['string'=>'Service']));
        $this->assertArrayHasKey('string', $this->creator->getService());
    }

    /**
     * @dataProvider provider
     * @param $strategy
     * @param $data
     */
    public function testUpdateStrategy($strategy, $data)
    {
        $this->creator->setService(new Config($data));
        $this->assertAttributeInstanceOf(
            $strategy,
            'strategy',
            $this->creator
        );
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Exception\BadTypeException
     */
    public function testBadTypeException()
    {
        $this->creator->setService(new Config(['fail'=>'fail']));
    }

    public function provider()
    {
        return [
            ['GetSky\Phalcon\AutoloadServices\Creators\ObjectInjection', ['object'=>'Service']],
            ['GetSky\Phalcon\AutoloadServices\Creators\ObjectInjection', ['obj'=>'Service']],
            ['GetSky\Phalcon\AutoloadServices\Creators\ObjectInjection', ['instance'=>'Service']],
        ];
    }

    protected function setUp()
    {
        $this->creator = new Creator(new FactoryDefault());
    }

    protected function tearDown()
    {
        $this->creator = null;
    }
} 