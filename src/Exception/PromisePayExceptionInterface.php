<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 01/12/2017
 * Time: 00:02
 */
declare(strict_types=1);
namespace PromisePay\Exception;


interface PromisePayExceptionInterface extends \Throwable
{
    public function getErrors(): array;
}