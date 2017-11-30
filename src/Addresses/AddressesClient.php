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
use PromisePay\Result;

class AddressesClient extends PromisePayClient implements AddressesInterface
{
    protected const Root_Index = [
        'get' => 'addresses'
    ];

    /**
     * @param string $id
     * @return null|Result
     */
    public function get(string $id): ?Result {
        $response = $this->guzzle()->get('addresses/' . $id);

        return new Result($response, self::Root_Index['get'], AddressesException::class);
    }
}