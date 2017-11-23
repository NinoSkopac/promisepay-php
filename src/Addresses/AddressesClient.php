<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 23/11/2017
 * Time: 22:38
 */
declare(strict_type=1);
namespace PromisePay\Addresses;
use PromisePay\Credentials\ConfigurationInterface;
use PromisePay\PromisePayClient;

class AddressesClient extends PromisePayClient
{
    public function __construct(ConfigurationInterface $configuration)
    {
        parent::__construct($configuration);
    }

    public function get($id) {
        // @TODO
        // figure out how to supply endpoints
        // figure out what kind of response to return (probably an object with \ArrayAccess


//        PromisePay::RestClient('get', 'addresses/' . $id);
//
//        return PromisePay::getDecodedResponse('addresses');
    }
}