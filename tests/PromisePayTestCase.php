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
    private const CONFIGURATION = [
        'prelive', 'idsidorov@gmail.com', 'd897f812e8485728e1de7d8ae092b75a'
    ];
    public function getConfiguration(): Configuration {
        return new Configuration(...self::CONFIGURATION);
    }
}