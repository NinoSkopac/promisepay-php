<?php
namespace PromisePay\Tests;

use PromisePay\PromisePay;

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// AUTOLOADERS
// PromisePay autoloader
require __DIR__ . '/../autoload.php';
// Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

// Tests/PHPunit specific files
require_once __DIR__ . '/functions.php';

// PHPUnit 6 introduced a breaking change that
// removes PHPUnit_Framework_TestCase as a base class,
// and replaces it with \PHPUnit\Framework\TestCase
if (!class_exists('\PHPUnit_Framework_TestCase') && class_exists('\PHPUnit\Framework\TestCase'))
    class_alias('\PHPUnit\Framework\TestCase', '\PHPUnit_Framework_TestCase');

// Setup testing environment
PromisePay::Configuration()->environment('prelive');
PromisePay::Configuration()->login('idsidorov@gmail.com');
PromisePay::Configuration()->password('d897f812e8485728e1de7d8ae092b75a');