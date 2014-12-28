# PHP Testing Starter
> Step by step tutorial for developers that want to start testing their web applications.

This is a step by step tutorial that should help you start testing your PHP application. The goal of this document is ment to:

  - Provide you with a **reliable resource** to start testing your PHP code.
  - Provide you with **quick copy-paste** code references.
  - Let you **focus on the important aspects** like writing unit tests.

## Summary

**Chapter 1** - _Setting up your project_
 * [Initial set-up](#initial-set-up)
 * [Files and folders explained](#files-and-folders-explained)
 * [Downloading needed tools](#downloading-needed-tools)
 * [Running the first test](#running-the-first-test)

**Chapter 2** - _Start testing_
 * Testing by stubbing methods
 * Testing by mocking objects
 
**Chapter 3** - _Testing special cases_
 * Testing `protected` and `private` methods
 * Reading and writing `protected` and `private` attributes
 * Testing methods using data providers
 * [Testing `abstract` classes](#testing-abstract-classes)
 * Testing system specific functions

**Chapter 4** - _Code optimizations_
 * Making your code testable
 * Group tests by test suites

**Chapter 5** - _Show me the money!_
* Test results 
* Code coverage
 

## Chapter 1
> Setting up your project

### Initial set-up

Create your project folder structure. If this is a **new project**, you can use dummy files and classes first and replace them later.
It should look similar to:

```
 |-[+] lib
 |   |- FirstClass.php
 |   \- SecondClass.php
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

### Files and folders explained

Our pet PHP project is called `MyProject`. Remember this, because it's the only fixed notion about this tutorial. We assume that all our files are under a single folder called `MyProject` and `MyProject/lib/` is mapped to `\MyProject` unique namespace.

`lib/` is the folder that contains **all your classes** and main logic. You will find this folder in other projects also named: `src`, `source` or similar. The main reason why you should keep everything in one folder (subfoldes) is namespacing your project.

`FirstClass.php` is one of your classes.

```php
namespace MyProject;

class FirstClass
{
}
```

`tests/` is the folder containing all your tests and other useful files needed during the testing. In other projects you can find this folder named as `test/`.

`tests/fixtures/` and `tests/providers/` can contain static data needed for some specific tests. You can ignore these for now.

`tests/lib/FirstClass/` is a the folder containing all the test files for `FirstClass` class. In other project this is just a file (e.g. `FirstClassTest.php`), but you will see later why is better to be a folder. This is entirely up to you and your project.

`tests/lib/FirstClass/*Test.php` are files specific to each method inside the `FirstClass` class.

`tests/phpunit.xml` is the file with the main PHPUnit configurations. By convention this is stored in an xml file so you don't have to repeat the same commands when running your PHPUnit tests.

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

`tests/bootstrap.php` is a file used by the PHPUnit to start your tests. You can put here various global settings. This is the place where to initiate the **autoloader** for your test files.

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
$autoloader->add('MyProjectTest\\', dirname(__FILE__) . '/tests/lib/');
```

`MyProjectTest` is the namespace where we will keep our tests. The final line of code is optional if you already configured in in `composer.json`. If you're using your own **autoloader** then you must include it.

`.gitignore` is a file that contains all the directories and files that will be excluded from Git commits.

```
composer.lock
vendor/
composer.phar
phpunit.phar
```

Finally, `composer.json` is the configuration file for composer. The `require-dev` and `autoload` keys are very important for our project to work.

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
      "MyProject\\": "lib/",
      "MyProjectTest\\": "tests/lib/"
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

### Testing abstract classes

Usually you have classes like this in your code `class Socks extends AbstractTransport implements TransportInterface`. While in `Socks` class you're confronted with concrete `public`, `protected` and `private` methods in an abstract class declaration like `AbstractTransport` you can also have `abstract` methods.

Abstract methods have no implmenentation hence they will be tested in the class that implements that `abstract` class (e.g. `Socks`). So why are we talking about abstract classes and methods? Because `abstract` classes can have concrete methods implementations and that should be tested!

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
