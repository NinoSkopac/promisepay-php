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
    protected const ADDRESS_ID = '07ed45e5-bb9d-459f-bb7b-a02ecb38f443';

    /**
     * @vcr default
     */
    public function testGet(): void {
        $addresses = new AddressesClient($this->getConfiguration());
        $addressDetails = $addresses->get(self::ADDRESS_ID);

        $this->assertEquals(self::ADDRESS_ID, $addressDetails['id']);
    }
}