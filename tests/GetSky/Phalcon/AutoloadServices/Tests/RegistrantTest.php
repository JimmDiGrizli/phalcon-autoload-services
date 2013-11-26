<?php
namespace GetSky\Phalcon\AutoloadServices\Tests;

use GetSky\Phalcon\AutoloadServices\Registrant;
use Phalcon\Config;
use Phalcon\Config\Adapter\Ini;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

class RegistrantTest extends PHPUnit_Framework_TestCase
{

    protected $services;

    protected $servicesTwo;

    /**
     * @var Registrant
     */
    protected $registrant;

    protected function setUp()
    {
        $this->services = new Ini('service.ini');
        $this->servicesTwo = new Ini('serviceTwo.ini');
        $this->registrant = new Registrant($this->services);
    }

    public function testIsInjectionAwareInterface()
    {
        $this->assertInstanceOf(
            'Phalcon\DI\InjectionAwareInterface',
            $this->registrant
        );
    }

    public function testGetService()
    {
        $service = $this->registrant->getServices();
        $this->assertObjectHasAttribute('route', $service);
    }

    public function testSetService()
    {
        $this->registrant->setServices($this->servicesTwo);
        $service = $this->registrant->getServices();
        $this->assertObjectHasAttribute('routeTwo', $service);
    }

    public function testSupportTypes()
    {
        $ref = new ReflectionClass(
            'GetSky\Phalcon\AutoloadServices\Registrant'
        );

        $object = $ref->newInstance($this->services);
        $types = $ref->getProperty('types');
        $types->setAccessible(true);

        $this->assertSame(
            ['string', 'object', 'provider'],
            $types->getValue($object)
        );
    }

    protected function tearDown()
    {
        $this->services = null;
        $this->servicesTwo = null;
        $this->registrant = null;
    }

} 