# PHP Testing Starter
> Step by step tutorial for developers that want to start testing their web applications.

This is a step by step tutorial that should help you start testing your PHP application. 
The goal of this document is meant to:

  - Provide you with a **reliable resource** to start testing your PHP code.
  - Provide you with **quick copy-paste** code references.
  - Let you **focus on the important aspects** like writing unit tests.

## Contributing

If you want to contribute to this book, here are a couple of rules to which we adhere:
 * KISS (Keep it simple, stupid) when providing examples and case-studies.
 * When providing code examples use the conventions that already exists in this book.
 * Try to provide real world testing scenarios.
 * Include references when citing other external resources.

## Summary

**Chapter 1** - _Setting up your project_ (Serban)
 * [Initial set-up](#initial-set-up)
 * [Files and folders explained](#files-and-folders-explained)
 * [Downloading needed tools](#downloading-needed-tools)
 * [Running the first test](#running-the-first-test)

**Chapter 2** - _Start testing/Show me the code!_ (Bogdan)
 * Testing by stubbing methods
 * Methods of mocking
    * With PHPUnit (Serban/Bogdan)
    * With `extends` via fixtures
    * With Mockery
 * Testing by mocking objects

**Chapter 3** - _Testing special cases_ (Serban/Bogdan)
 * Testing `protected` and `private` methods (Bogdan)
 * Reading and writing `protected` and `private` attributes (Bogdan)
 * [Testing with data providers](#testing-with-data-providers)
 * [Testing `abstract` classes](#testing-abstract-classes) (Serban)
 * [Testing `static` variables, methods and `__callStatic`](#testing-static-in-classes) (Serban)
    * Running tests in isolation (Bogdan)
 * Testing system specific functions (Serban/Bogdan)
    * Aliasing and namespacing (Serban)
    * Runkit, override_function (Bogdan)
 * [Testing `Exceptions` and errors](#testing-exceptions-and-errors) (Serban)
 * Testing a `Fluent` class (Serban)

**Chapter 4** - _Code optimizations_
 * Naming conventions for tests (Bogdan)
    * File and class naming (Bogdan/Serban)
    * when BLA then BLA, subject action WILL react (Bogdan)
    * Test name generator (Eclipse, SublimeText, PHPStorm). (Bogdan)
 * Making your code testable (Serban)
    * GLOBALS, DI, separation of concerns
 * Group tests by test suites (Serban)

**Chapter 5** - _Show me the money!_
  * Test results
    * CI, clover
  * Code line coverage (Serban)
  * CI
  * Motivation
  * Reporting to others
  * Tools
  * Funny



## Chapter 1
> Setting up your project

### Initial set-up

Create your project folder structure. If this is a **new project**, you can use dummy files and classes first and
replace them later.
This is a personal preference, we've seen the following patterns used in the wild.

When a project has many sub-namespaces:

```
|-[+] lib
|  |-[+] FirstSubNamespace
|  |  |- FirstClass.php
|  |  |- FirstClassAbstract.php
|  |  \- FirstClassInterface.php
|  |
|  |-[+] SecondSubNamespace
|     |- FirstClass.php
|     \- SecondClass.php
|
|-[+] tests
|  |-[+] FirstSubNamespace
|  |  |-[+] FirstClass
|  |     |- InputTest.php
|  |     \- RecursionTest.php
|  |
|  |-[+] SecondSubNamespace
|     |-[+] FirstClass
|     |  |- ConstructorTest.php
|     |  |- SomeMethodTest.php
|     |-[+] SecondClass
|        |- ConstructorTest.php
|        \- SomeMethodTest.php
```

When the project is a collection of classes in the root namespace:

```
 |-[+] lib
 |  |- FirstClass.php
 |  \- SecondClass.php
 |
 |-[+] tests
 |  |- [+] fixtures
 |  |- [+] providers
 |  |- [+] lib
 |  |   \- [+] FirstClass
 |  |       |- firstMethodTest.php
 |  |       |- secondMethodTest.php
 |  |       \- constructorTest.php
 |  |
 |  |- phpunit.xml
 |  \- bootstrap.php
 |
 |- .gitignore
 \- composer.json
```

When the project has both unit tests and integration tests:

```
|-[+] tests
|  |-[+] unit
|  |  |- ...
|  |-[+] integration
|  |  |- ...
|  |
|  |- phpunit-unit.xml
|  |- phpunit-integration.xml
```

### Files and folders explained

Our pet PHP project is called `MyProject`. Remember this, because it's the only fixed notion about this tutorial.
We assume that all our files are under a single folder called `MyProject` and `MyProject/lib/` is mapped to `\MyProject`
unique namespace.

`lib/` is the folder that contains **all your classes** and main logic. You will find this folder in other projects also
named: `src`, `source` or similar. The main reason why you should keep everything in one folder (subfolders)
is namespacing your project.

`FirstClass.php` is one of your classes.

```php
namespace MyProject;

class FirstClass
{
}
```

`tests/` is the folder containing all your tests and other useful files needed during the testing. In other projects you
can find this folder named as `test/`.

`tests/fixtures/` and `tests/providers/` can contain static data needed for some specific tests. You can ignore these
for now.

`tests/lib/FirstClass/` is a the folder containing all the test files for `FirstClass` class. In other project this is
just a file (e.g. `FirstClassTest.php`), but you will see later why is better to be a folder. This is entirely up to
you and your project.

`tests/lib/FirstClass/*Test.php` are files specific to each method inside the `FirstClass` class.

`tests/phpunit.xml` is the file with the main PHPUnit configurations. By convention this is stored in an xml file so you
don't have to repeat the same commands when running your PHPUnit tests.

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit
        colors="true"
        verbose="false"
        bootstrap="bootstrap.php"
        convertErrorsToExceptions="true"
        convertNoticesToExceptions="true"
        convertWarningsToExceptions="true"
        strict="true">

    <testsuite name="All tests">
        <directory suffix="Test.php">lib</directory>
    </testsuite>
</phpunit>
```

`tests/bootstrap.php` is a file used by the PHPUnit to start your tests. You can put here various global settings.
This is the place where to initiate the **autoloader** for your test files.

```php
<?php
$composer = dirname(__FILE__) . '/../vendor/autoload.php';
if (!file_exists($composer)) {
    throw new \RuntimeException("Please run 'composer install' first to set up autoloading. $composer");
}

/**
 * @var \Composer\Autoload\ClassLoader $autoloader
 */
$autoloader = include_once $composer;
```

`MyProjectTest` is the namespace where we will keep our tests. The final line of code is optional if you already
configured in in `composer.json`. If you're using your own **autoloader** then you must include it.

`.gitignore` is a file that contains all the directories and files that will be excluded from Git commits.

```
composer.lock
vendor/
composer.phar
phpunit.phar
```

Finally, `composer.json` is the configuration file for composer. The `require-dev` and `autoload` keys are very
important for our project to work.

```json
{
  "name": "yourname/myproject",
  "type": "library",
  "description": "A demo project.",
  "keywords": ["project", "demo", "php project"],
  "homepage": "https://github.com/yourname/MyProject",
  "license": "MIT",
  "require": {
    "php": ">=5.3.0"
  },
  "require-dev": {
    "phpunit/phpunit": "*"
  },
  "autoload": {
    "psr-4": {
      "MyProject\\": "lib/"
    }
  }
}
```

### Downloading needed tools

1. Download latest snapshot of [composer.phar]. Put it in your project's root or make it available global.
2. Download latest [phpunit.phar]. Same as above.

### Running the first test

```sh
cd MyProject/
php composer.phar diag
```

You should be *OK* at this point. If you see any problems here, consult the [possible composer issues] subsection.

```sh
php composer.phar install
php phpunit.phar -c tests/phpunit.xml
```

The output should be:

```text
PHPUnit 4.4.0 by Sebastian Bergmann.
Configuration read from /path/to/MyProject/tests/phpunit.xml
.
Time: 244 ms, Memory: 3.75Mb
OK (1 test, 1 assertion)
```

Congratulations! If you made it this far then you might as well think about starring this project and support us.

[composer.phar]:https://getcomposer.org/composer.phar
[phpunit.phar]:https://phar.phpunit.de/phpunit.phar
[possible composer issues]:#aaa

## Chapter 3
> Testing special cases

### Testing with data providers

When testing with large or specific sets of data via `@dataProvider` you might consider using distinct keys for your data sets. This can help you with the debugging. Even if you don't do this, you can still take advantage of testing one specific data set from a provider.

Here is an example where `testAgents()` method is using a provider that has 100 items. Item with the index `10` fails and we want to debug the code against that specific data set: 

```
$ php phpunit.phar -c phpunit.xml.dist --testsuite IntegrationTests --filter "/::testAgents .*#10/"
```

### Testing abstract classes

Usually you have classes like this in your code `class Socks extends AbstractTransport implements TransportInterface`.
While in `Socks` class you're confronted with concrete `public`, `protected` and `private` methods in an abstract class
declaration like `AbstractTransport` you can also have `abstract` methods.

Abstract methods have no implementation hence they will be tested in the class that implements that `abstract` class
(e.g. `Socks`). So why are we talking about abstract classes and methods? Because `abstract` classes can have concrete
methods implementations and that should be tested!

Let's take an example of `abstract` class declaration and try to test `setPort` and `getPort` signature methods.

```php
abstract class AbstractTransport
{
  protected $port;

  public function setPort($port)
  {
    $this->port = (int)$port;
  }

  public function getPort()
  {
    return $this->port;
  }
}
```

Here is how you can test both concrete methods from the `abstract` class `AbstractTransport`:

```php
    /**
     * set port sets the desired port
     */
    public function testSetPortSetsTheDesiredPort()
    {
        $inputPort = 8080;
        $mock = $this->getMockForAbstractClass('\MyProject\Transport\AbstractTransport');
        $mock->setPort($inputPort);

        $this->assertEquals($inputPort, $mock->getPort());
    }
```

### Testing static in classes

Normally you have to reduce the amount of `static` variables and `static` methods inside your classes. 
A class that has a lot of static methods inside itself is no more than a collection of functions and is 
a sign of warning.
Anyway you may be facing the issue of covering multiple static methods with tests or even some _magic_ 
methods generated by `__callStatic`. This can prove challenging if the static methods reuse the same static 
variables and maintain their state across the execution of the script.


### Testing `Exceptions` and errors

#### `@expectedException`

Unit testing usually starts by testing the exceptions and errors. If you have a method that throws three 
different exceptions, and you are able to reach them one-by-one by mocking and testing you are almost done.

Here is an example of the class [`Username`] under unit tests. It's a class extracted from a possible [Domain-Driven design]
PHP application. Here exceptions are not four possible exceptions thrown by `setUsername($username)` method:
 * If the username is empty
 * If the username is too short
 * If the username is too long
 * If the username has an invalid format
 
We've unit tested the class in [`UsernameTest`]. If you look at the last test `testSettingAUsernameInAnInvalidFormatUsingAProviderOfUsernamesWillThrowAnException`
you can see that we've used a provider `invalidFormatUsernames` with invalid values for the username. If you forget 
this test (go ahead and delete it, and rerun tests with coverage), the line coverage is still 100%.

This means that we've tested the exceptions but not all execution paths. We can assume that the regex format 
from `Username::FORMAT` is ok and these unit tests suffice. This is something that you will come across pretty often 
with unit tests.

[`Username`]:tests/ExceptionsTest/Username.php
[`UsernameTest`]:tests/ExceptionsTest/UsernameTest.php
[Domain-Driven design]:https://leanpub.com/ddd-in-php

#### `setExpectedException()`

When you use the annotation, PHPUnit is simply expecting the test to throw an exception, not caring at what point in the test it happened. If you're using `setExpectedException('InvalidArgument', 'Invalid username.')` you can easely debug your test and know exactly which error and where was thrown.

#### `try/catch`

You can also test your code by using `try/catch` blocks inside your unit tests and placing `$this->fail('The test has failed.')` inside `catch` statement or outside - `$this->fail('Failed to throw exception')`.
Normally you should try to reduce the amount of code in your tests and avoid using `try/catch`.

#### Isolating a failing test for debug

One of the fastest ways to isolate a specific failing test is to mark it with `@group failing` and then run `phpunit` again with `--group failing`.

## Chapter 5
> Show me the money!

### Tools

 * Nyan Cat [result printer] for PHPUnit.

[result printer]:https://github.com/whatthejeff/nyancat-phpunit-resultprinter

### Funny

 * The 4-LOC µ [(mu) PHP Microframework]. Since it's really short code the author decided to [test] the mini framework with [`assert`] function from PHP.
 * [Test::More] is the most popular library for writing tests in Perl. This is a PHP port that provides the same functionality and a similar interface.

[(mu) PHP Microframework]:https://github.com/jeremeamia/mu
[test]:https://github.com/jeremeamia/mu/blob/master/test.php
[`assert`]:http://php.net/manual/en/function.assert.php
[Test::More]:https://code.google.com/p/test-more-php/
