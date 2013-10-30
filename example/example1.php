<?php
require_once __DIR__ . '\..\vendor\autoload.php';
require_once 'RouteProvider.php';
require_once 'Service.php';
require_once 'CallService.php';

use GetSky\Phalcon\AutoloadServices\Registrant;
use Phalcon\Config\Adapter\Ini;
use \Phalcon\DI\FactoryDefault;

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
var_dump($di->getService('response'));
echo '<br/>';
var_dump($di->getService('callsample'));
echo '</pre>';

/*
 * Output:
  object(Phalcon\DI\Service)[52]
  protected '_name' => string 'route' (length=5)
  protected '_definition' =>
    object(Closure)[51]
  protected '_shared' => boolean false
  protected '_sharedInstance' => null

object(Phalcon\DI\Service)[54]
  protected '_name' => string 'request' (length=7)
  protected '_definition' =>
    object(Service)[59]
      protected 'value' => string '22' (length=2)
      protected 'service' =>
        object(Service)[57]
          protected 'value' => string '24' (length=2)
          protected 'service' => null
          protected 'route' => null
      protected 'route' =>
        object(Phalcon\Mvc\Router)[56]
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

object(Phalcon\DI\Service)[11]
  protected '_name' => string 'response' (length=8)
  protected '_definition' => string 'Phalcon\Http\Response' (length=21)
  protected '_shared' => boolean true
  protected '_sharedInstance' => null

object(Phalcon\DI\Service)[53]
  protected '_name' => string 'callsample' (length=10)
  protected '_definition' =>
    object(CallService)[49]
      protected 'class' =>
        object(CallService)[62]
          protected 'class' =>
            object(Phalcon\Mvc\Router)[63]
              ...
          protected 'var' => string 'Hello Phalcon' (length=13)
      protected 'var' => string '24' (length=2)
  protected '_shared' => boolean false
  protected '_sharedInstance' => null

 */