Component for automatic registration of services in DI [![Build Status](https://travis-ci.org/JimmDiGrizli/phalcon-autoload-services.png?branch=develop)](https://travis-ci.org/JimmDiGrizli/phalcon-autoload-services) [![Dependency Status](https://www.versioneye.com/user/projects/537c890514c1580a8600010a/badge.svg)](https://www.versioneye.com/user/projects/537c890514c1580a8600010a)
======================================================

This component allows to register services in DI with the settings file.

The main features of the component:
- Services can be initialized with a string, object or service provider;
- Services are connected via a configuration file;
- Services can be registered as "shared" services;


Requirements:
* PHP 5.4
* Phalcon Framework

Phalcon framework: http://phalconphp.com/

Using
-----

For registration services necessary to execute the code:

```php
$services = new Ini('services.ini');
$dic = new FactoryDefault();

$registrant = new Registrant($services);
$registrant->setDi($dic);
$registrant->registration();
```

Configuring Services
--------------------

There are three ways to register services:

1. By the class name. This method does not allow to pass arguments to a 
constructor or adjust parameters.
    
    ```ini
    [response]
    string = "Phalcon\Http\Response"
    ```
    
2. Registering an instance directly. When using this method the container is 
placed dependency already finished object.
    ```ini
    [request]
    object = "Phalcon\Http\Response"
    ```

3. Through the service provider. Which must implement the interface 
```GetSky\Phalcon\AutoloadServices\Provider```. According to the plan, providers
are intermediaries for registration of anonymous functions in the container 
dependency, but have the opportunity to realize any other way that supports 
Phalcon.
    ```ini
    [route]
    provider = "RouteProvider"
    ```
    
For the second and third method possible to specify which arguments are passed 
to the constructor and invoke methods since its inception and prior to placement
in the DI. Below is an example of how it can be implemented on the ini:

```ini
[first-service]
provider = "SomeNamespace\FirstClass"
arg.0.service = "config"
arg.1.var = "24"
arg.2.di = 1
arg.3.s-service = "shared-service"
arg.4.object.object = "SoeNamespace\SecondClass"
arg.4.object.arg.0.var = "42"
arg.4.object.call.0.method = "run"
```

In the above example, we register the service ```SomeNamespace\FirstClass``` 
under the name ```first-service ``` and pass 5 arguments: the service 
```config```, variable ```24```, DI (object implements ```DiInterface```),
service ```shared-services``` caused by the method ``` getShared``` and an
instance of ```SomeNamespace\SecondClass```, which was first created with
transfer ```42``` and calling ```run```.
