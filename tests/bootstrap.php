<?php
namespace PromisePay\Tests;

use Composer\Autoload\ClassLoader;
use PromisePay\PromisePay;

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$composerAutoloadFile = __DIR__ . '/../../../autoload.php';

if (is_file($composerAutoloadFile)) {
    require_once $composerAutoloadFile;
}

// Tests/PHPunit specific files
require_once __DIR__ . '/functions.php';

// test assets autoloader
$classLoader = new ClassLoader();
$classLoader->addPsr4(__NAMESPACE__ . '\\', __DIR__, true);
$classLoader->register();

// Project files autoloader
require __DIR__ . '/../autoload.php';

// PHPUnit 6 introduced a breaking change that
// removes PHPUnit_Framework_TestCase as a base class,
// and replaces it with \PHPUnit\Framework\TestCase
if (!class_exists('\PHPUnit_Framework_TestCase') && class_exists('\PHPUnit\Framework\TestCase'))
    class_alias('\PHPUnit\Framework\TestCase', '\PHPUnit_Framework_TestCase');

// Setup testing environment
PromisePay::Configuration()->environment('prelive');
PromisePay::Configuration()->login('idsidorov@gmail.com');
PromisePay::Configuration()->password('d897f812e8485728e1de7d8ae092b75a');

