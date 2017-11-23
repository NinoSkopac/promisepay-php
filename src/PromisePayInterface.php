<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 23/11/2017
 * Time: 22:37
 */
declare(strict_type=1);
namespace PromisePay;
use PromisePay\Credentials\ConfigurationInterface;

interface PromisePayInterface
{
    /**
     * PromisePayInterface constructor.
     * @param ConfigurationInterface $credentials
     */
    public function __construct(ConfigurationInterface $credentials);
}