<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 23/11/2017
 * Time: 22:38
 */
declare(strict_types=1);
namespace PromisePay\Addresses;

use PromisePay\Result;

interface AddressesInterface
{
    /**
     * @param string $id
     * @return null|Result
     */
    public function get(string $id): ?Result;
}