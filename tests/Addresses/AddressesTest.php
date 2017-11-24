<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 24/11/2017
 * Time: 16:02
 */
declare(strict_types=1);
namespace PromisePay\Test\Addresses;
use PromisePay\Addresses\AddressesClient;
use PromisePay\Test\PromisePayTestCase;

class AddressesTest extends PromisePayTestCase
{
    public function testGet(): void {
        $addresses = new AddressesClient($this->getConfiguration());
    }
}