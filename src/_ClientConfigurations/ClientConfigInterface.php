<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 30/11/2017
 * Time: 23:21
 */
declare(strict_types=1);
namespace PromisePay\_ClientConfigurations;


interface ClientConfigInterface
{
    /**
     *
     *
     * @return string
     */
    public function getRootIndex(): string;

    /**
     * @return string
     */
    public function getExceptionName(): string;
}