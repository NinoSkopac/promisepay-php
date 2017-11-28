<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 23/11/2017
 * Time: 22:38
 */
declare(strict_types=1);
namespace PromisePay\Addresses;

interface AddressesInterface
{
    public function get(string $id);
}