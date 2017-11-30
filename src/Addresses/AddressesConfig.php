<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 30/11/2017
 * Time: 23:26
 */
declare(strict_types=1);
namespace PromisePay\Addresses;

use PromisePay\_ClientConfigurations\ClientConfigAbstract;

class AddressesConfig extends ClientConfigAbstract
{
    protected const CONFIG = [
        'addresses',
        AddressesException::class
    ];
}