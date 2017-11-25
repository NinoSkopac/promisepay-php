<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 23/11/2017
 * Time: 22:38
 */
declare(strict_type=1);
namespace PromisePay\Addresses;
use PromisePay\Configuration\ConfigurationInterface;
use PromisePay\PromisePayClient;

class AddressesClient extends PromisePayClient
{
    public function __construct(ConfigurationInterface $configuration)
    {
        parent::__construct($configuration);
    }

    public function get(string $id) {
        $response = $this->guzzle()->get('addresses/' . $id);

        // @TODO return PromisePayResult
        var_dump($response);
    }
}