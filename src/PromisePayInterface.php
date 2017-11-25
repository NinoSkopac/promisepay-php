<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 23/11/2017
 * Time: 22:37
 */
declare(strict_types=1);
namespace PromisePay;

use PromisePay\Configuration\ConfigurationInterface;

interface PromisePayInterface
{
    /**
     * PromisePayInterface constructor.
     * @param ConfigurationInterface $credentials
     */
    public function __construct(ConfigurationInterface $credentials);
}