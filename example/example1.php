<?php
require_once __DIR__ . '\..\vendor\autoload.php';
require_once 'RouteProvider.php';
use GetSky\Phalcon\AutoloadServices\Registrant;
use Phalcon\Config\Adapter\Ini;
use \Phalcon\DI\FactoryDefault;

(new \Phalcon\Debug())->listen(true, true);

$di = new FactoryDefault();
$services = new Ini('services.ini');
$registrant = new Registrant($services);
$registrant->setDI($di);

$registrant->registration();

echo'<pre>';
var_dump($di->getService('route'));
echo '<br/>';
var_dump($di->getService('request'));
echo '<br/>';
var_dump($di->getService('response'));
echo'</pre>';

/*
  object(Phalcon\DI\Service)#33 (4) {
  ["_name":protected]=>
  string(5) "route"
  ["_definition":protected]=>
  object(Closure)#32 (1) {
    ["this"]=>
    object(RouteProvider)#31 (0) {
    }
  }
  ["_shared":protected]=>
  bool(false)
  ["_sharedInstance":protected]=>
  NULL
}



object(Phalcon\DI\Service)#30 (4) {
  ["_name":protected]=>
  string(7) "request"
  ["_definition":protected]=>
  string(20) "Phalcon\Http\Request"
  ["_shared":protected]=>
  bool(false)
  ["_sharedInstance":protected]=>
  NULL
}



object(Phalcon\DI\Service)#34 (4) {
  ["_name":protected]=>
  string(8) "response"
  ["_definition":protected]=>
  string(21) "Phalcon\Http\Response"
  ["_shared":protected]=>
  bool(true)
  ["_sharedInstance":protected]=>
  NULL
}
 */