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

abstract class PromisePayTestCase extends TestCase
{
    private const CONFIGURATION = [
        'prelive', 'walkthrough@promisepay.com', 'OGQ4Nzg3OTc4MmE2ZTJjZDFmZDViZjU4NGZmMDEzZjc='
    ];
    public function getConfiguration(): Configuration {
        return new Configuration(...self::CONFIGURATION);
    }
    protected function getConfigurationDetails(): array {
        return self::CONFIGURATION;
    }

    /**
     * @param array $keys
     * @param array[] $arrays
     */
    protected function discardKeysFromArrays(array $keys, array &...$arrays): void {
        foreach ($arrays as &$array) {
            foreach ($keys as $key) {
                unset($array[$key]);
            }
        }
    }
}