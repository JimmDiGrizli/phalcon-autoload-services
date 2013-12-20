<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once 'RouteProvider.php';
require_once 'Service.php';
require_once 'CallService.php';

use GetSky\Phalcon\AutoloadServices\Registrant;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DI\FactoryDefault;

(new \Phalcon\Debug())->listen(true, true);

$di = new FactoryDefault();
$services = new Ini('services.ini');
$registrant = new Registrant($services);
$di->setShared('registrant', $registrant);

$di->get('registrant')->registration();

echo '<pre>';
var_dump($di->getService('route'));
echo '<br/>';
var_dump($di->getService('request'));
echo '<br/>';
var_dump($di->getService('requestclered'));
echo '<br/>';
var_dump($di->getService('response'));
echo '<br/>';
var_dump($di->getService('callsample'));
echo '<br/>';
var_dump($di->getService('callsampleclered'));
echo '</pre>';


/*
 * Output:
object(Phalcon\DI\Service)[87]
  protected '_name' => string 'route' (length=5)
  protected '_definition' =>
    object(Closure)[89]
  protected '_shared' => boolean false
  protected '_sharedInstance' => null

object(Phalcon\DI\Service)[90]
  protected '_name' => string 'request' (length=7)
  protected '_definition' =>
    object(Service)[91]
      protected 'value' => string '22' (length=2)
      protected 'service' =>
        object(Service)[93]
          protected 'value' => string '24' (length=2)
          protected 'service' => null
          protected 'route' => null
          protected 'di' => null
      protected 'route' =>
        object(Phalcon\Acl\Role)[92]
          protected '_name' => string '24' (length=2)
          protected '_description' => null
      protected 'di' =>
        object(Phalcon\DI\FactoryDefault)[3]
          protected '_services' =>
            array (size=26)
              ...
          protected '_sharedInstances' => null
          protected '_freshInstance' => boolean false
  protected '_shared' => boolean false
  protected '_sharedInstance' => null

object(Phalcon\DI\Service)[86]
  protected '_name' => string 'requestclered' (length=13)
  protected '_definition' =>
    object(Service)[94]
      protected 'value' => null
      protected 'service' => null
      protected 'route' => null
      protected 'di' => null
  protected '_shared' => boolean false
  protected '_sharedInstance' => null

object(Phalcon\DI\Service)[96]
  protected '_name' => string 'response' (length=8)
  protected '_definition' => string 'Phalcon\Http\Response' (length=21)
  protected '_shared' => boolean true
  protected '_sharedInstance' => null

object(Phalcon\DI\Service)[85]
  protected '_name' => string 'callsample' (length=10)
  protected '_definition' =>
    object(CallService)[95]
      protected 'class' =>
        object(CallService)[98]
          protected 'class' =>
            object(Phalcon\Acl\Role)[99]
              ...
          protected 'var' => string 'Hello Phalcon' (length=13)
      protected 'var' => string '24' (length=2)
  protected '_shared' => boolean false
  protected '_sharedInstance' => null

object(Phalcon\DI\Service)[11]
  protected '_name' => string 'callsampleclered' (length=16)
  protected '_definition' =>
    object(CallService)[97]
      protected 'class' =>
        object(CallService)[102]
          protected 'class' => null
          protected 'var' => null
      protected 'var' => string '24' (length=2)
  protected '_shared' => boolean false
  protected '_sharedInstance' => null
 */