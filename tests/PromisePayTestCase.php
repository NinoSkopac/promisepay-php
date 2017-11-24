<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 24/11/2017
 * Time: 16:46
 */
declare(strict_types=1);
namespace PromisePay\Test;
use PHPUnit\Framework\TestCase;
use PromisePay\Configuration\Configuration;

class PromisePayTestCase extends TestCase
{
    public function getConfiguration(
        string $env = 'prelive',
        string $login = 'idsidorov@gmail.com',
        string $pass = 'd897f812e8485728e1de7d8ae092b75a'
    ): Configuration {
        return new Configuration($env, $login, $pass);
    }
}