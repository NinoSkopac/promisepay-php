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
    protected const ADDRESS_ID = 'fe602dcf-4175-4f88-b5be-3beb04092dcd';

    /**
     * @vcr default
     */
    public function testGet(): void {
        $addresses = new AddressesClient($this->getConfiguration());
        $addressDetails = $addresses->get(self::ADDRESS_ID);

        $this->assertEquals(self::ADDRESS_ID, $addressDetails['id']);
    }
}