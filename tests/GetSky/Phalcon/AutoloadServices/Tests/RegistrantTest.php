<?php
namespace GetSky\Phalcon\AutoloadServices\Tests;

use GetSky\Phalcon\AutoloadServices\Registrant;
use Phalcon\Config;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DI\FactoryDefault;
use PHPUnit_Framework_TestCase;
use ReflectionClass;
use ReflectionMethod;

class RegistrantTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Config
     */
    protected $services;
    /**
     * @var Config
     */
    protected $servicesTwo;
    /**
     * @var Config
     */
    protected $servicesFail;
    /**
     * @var FactoryDefault
     */
    protected $di;
    /**
     * @var Registrant
     */
    protected $registrant;

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

    public function testSetGetDI()
    {
        $this->registrant->setDI($this->di);
        $di = $this->registrant->getDI();
        $this->assertSame($di, $this->di);
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

    /**
     * @dataProvider providerTypes
     */
    public function testFindType($name)
    {

        $method = new ReflectionMethod(
            'GetSky\Phalcon\AutoloadServices\Registrant',
            'findType'
        );

        $method->setAccessible(true);

        $this->assertInternalType(
            'string',
            $method->invoke(
                $this->registrant,
                $this->services->get($name),
                $name
            )
        );
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Exception\BadTypeException
     */
    public function testExceptionFindType()
    {
        $method = new ReflectionMethod(
            'GetSky\Phalcon\AutoloadServices\Registrant',
            'findType'
        );

        $method->setAccessible(true);

        $this->assertInternalType(
            'string',
            $method->invoke(
                $this->registrant,
                $this->servicesFail->get('fail'),
                'fail'
            )
        );
    }

    /**
     * @expectedException \GetSky\Phalcon\AutoloadServices\Exception\DiNotFoundException
     */
    public function testExceptionRegistration()
    {
        $registrant = new Registrant($this->services);

        $registrant->registration();
    }

    public function testRegistrant()
    {
        $this->registrant->setDI($this->di);
        $this->registrant->registration();

        $this->assertNull($this->registrant->getServices());

        $this->assertSame('route', $this->di->getService('route')->getName());
        $this->assertSame(false, $this->di->getService('route')->isShared());
        $this->assertInternalType(
            'object',
            $this->di->getService('route')->getDefinition()
        );
        $this->assertInstanceOf('\Phalcon\Acl\Role', $this->di->get('route'));

        $this->assertSame(
            'request',
            $this->di->getService('request')->getName()
        );
        $this->assertSame(
            false,
            $this->di->getService('request')->isShared()
        );
        $this->assertInternalType(
            'object',
            $this->di->getService('request')->getDefinition()
        );
        $this->assertInstanceOf('Service', $this->di->get('request'));

        $this->assertSame(
            'requestclered',
            $this->di->getService('requestclered')->getName()
        );
        $this->assertSame(
            false,
            $this->di->getService('requestclered')->isShared()
        );
        $this->assertInternalType(
            'object',
            $this->di->getService('requestclered')->getDefinition()
        );
        $this->assertInstanceOf('Service', $this->di->get('requestclered'));

        $this->assertSame(
            'callsample',
            $this->di->getService('callsample')->getName()
        );
        $this->assertSame(
            false,
            $this->di->getService('callsample')->isShared()
        );
        $this->assertInternalType(
            'object',
            $this->di->getService('callsample')->getDefinition()
        );
        $this->assertInstanceOf('CallService', $this->di->get('callsample'));

        $this->assertSame(
            'callsampleclered',
            $this->di->getService('callsampleclered')->getName()
        );
        $this->assertSame(
            false,
            $this->di->getService('callsampleclered')->isShared()
        );
        $this->assertInternalType(
            'object',
            $this->di->getService('callsampleclered')->getDefinition()
        );
        $this->assertInstanceOf(
            'CallService',
            $this->di->get('callsampleclered')
        );


        $this->assertSame(
            'response',
            $this->di->getService('response')->getName()
        );
        $this->assertSame(
            true,
            $this->di->getService('response')->isShared()
        );
        $this->assertInternalType(
            'string',
            $this->di->getService('response')->getDefinition()
        );
        $this->assertInstanceOf(
            'Phalcon\Http\Response',
            $this->di->get('response')
        );

    }

    public function providerTypes()
    {
        return [
            ['route'],
            ['routeclered'],
            ['request'],
            ['requestclered'],
            ['response'],
            ['responsecleared']
        ];
    }

    protected function setUp()
    {
        $this->services = new Ini('service.ini');
        $this->servicesTwo = new Ini('serviceTwo.ini');
        $this->servicesFail = new Ini('serviceFail.ini');
        $this->registrant = new Registrant($this->services);
        $this->di = new FactoryDefault();
    }

    protected function tearDown()
    {
        $this->services = null;
        $this->servicesTwo = null;
        $this->servicesFail = null;
        $this->registrant = null;
        $this->di = null;
    }
} 