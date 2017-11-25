<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 23/11/2017
 * Time: 22:38
 */
declare(strict_types=1);
namespace PromisePay\Addresses;

use PromisePay\PromisePayClient;

class AddressesClient extends PromisePayClient
{
    public function get(string $id) {
        $response = $this->guzzle()->get('addresses/' . $id);


        // @TODO return PromisePayResult
        var_dump(get_class($response));
    }
}