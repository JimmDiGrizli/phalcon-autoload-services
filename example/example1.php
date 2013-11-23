<?php
require_once __DIR__ . '\..\vendor\autoload.php';
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
$registrant->setDI($di);

$registrant->registration();

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
object(Phalcon\DI\Service)[82]
  protected '_name' => string 'route' (length=5)
  protected '_definition' =>
    object(Closure)[81]
  protected '_shared' => boolean false
  protected '_sharedInstance' => null

object(Phalcon\DI\Service)[84]
  protected '_name' => string 'request' (length=7)
  protected '_definition' =>
    object(Service)[89]
      protected 'value' => string '22' (length=2)
      protected 'service' =>
        object(Service)[87]
          protected 'value' => string '24' (length=2)
          protected 'service' => null
          protected 'route' => null
      protected 'route' =>
        object(Phalcon\Mvc\Router)[86]
          protected '_dependencyInjector' =>
            object(Phalcon\DI\FactoryDefault)[3]
              ...
          protected '_uriSource' => null
          protected '_namespace' => null
          protected '_module' => null
          protected '_controller' => null
          protected '_action' => null
          protected '_params' =>
            array (size=0)
              ...
          protected '_routes' =>
            array (size=2)
              ...
          protected '_matchedRoute' => null
          protected '_matches' => null
          protected '_wasMatched' => boolean false
          protected '_defaultNamespace' => null
          protected '_defaultModule' => null
          protected '_defaultController' => null
          protected '_defaultAction' => null
          protected '_defaultParams' =>
            array (size=0)
              ...
          protected '_removeExtraSlashes' => null
          protected '_notFoundPaths' => null
          protected '_isExactControllerName' => boolean false
  protected '_shared' => boolean false
  protected '_sharedInstance' => null

object(Phalcon\DI\Service)[83]
  protected '_name' => string 'requestclered' (length=13)
  protected '_definition' =>
    object(Service)[90]
      protected 'value' => null
      protected 'service' => null
      protected 'route' => null
  protected '_shared' => boolean false
  protected '_sharedInstance' => null

object(Phalcon\DI\Service)[92]
  protected '_name' => string 'response' (length=8)
  protected '_definition' => string 'Phalcon\Http\Response' (length=21)
  protected '_shared' => boolean true
  protected '_sharedInstance' => null

object(Phalcon\DI\Service)[79]
  protected '_name' => string 'callsample' (length=10)
  protected '_definition' =>
    object(CallService)[91]
      protected 'class' =>
        object(CallService)[94]
          protected 'class' =>
            object(Phalcon\Mvc\Router)[95]
              ...
          protected 'var' => string 'Hello Phalcon' (length=13)
      protected 'var' => string '24' (length=2)
  protected '_shared' => boolean false
  protected '_sharedInstance' => null

object(Phalcon\DI\Service)[11]
  protected '_name' => string 'callsampleclered' (length=16)
  protected '_definition' =>
    object(CallService)[93]
      protected 'class' =>
        object(CallService)[100]
          protected 'class' => null
          protected 'var' => null
      protected 'var' => string '24' (length=2)
  protected '_shared' => boolean false
  protected '_sharedInstance' => null
 */