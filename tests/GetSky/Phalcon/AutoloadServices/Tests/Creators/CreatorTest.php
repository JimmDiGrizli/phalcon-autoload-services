<?php
namespace GetSky\Phalcon\AutoloadServices\Tests\Creators;

use GetSky\Phalcon\AutoloadServices\Creators\Creator;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use PHPUnit_Framework_TestCase;
use ReflectionProperty;

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

    public function testInjectionNullStrategy()
    {
        $this->assertNull($this->creator->injection());
    }

    public function testInjectionStrategy()
    {
        $mock = $this->getMockForAbstractClass(
            'GetSky\Phalcon\AutoloadServices\Creators\StringInjection',
            [
                $this->getMock('Phalcon\DI\FactoryDefault'),
                $this->getMock('Phalcon\Config'),
                'Service'
            ]
        );

        $properties = new ReflectionProperty($this->creator, 'strategy');
        $properties->setAccessible(true);
        $properties->setValue($this->creator, $mock);

        $this->assertEquals('Service',$this->creator->injection());

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
     * @expectedException \GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotFoundException
     */
    public function testClassNotFoundException()
    {
        $this->creator->setService(new Config(['string'=>'Fail']));
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Creators\Exception\MissClassNameException
     */
    public function testMissClassNameException()
    {
        $this->creator->setService(new Config(['string'=> '']));
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Creators\Exception\ClassNotImplementsException
     */
    public function testClassNotImplementsException()
    {
        $this->creator->setService(new Config(['provider'=> 'Service']));
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