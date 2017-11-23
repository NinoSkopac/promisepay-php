<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 23/11/2017
 * Time: 22:48
 */
declare(strict_types=1);
namespace PromisePay\Credentials;

interface ConfigurationInterface
{
    public function __construct(string $environment, string $login, string $password);
    public function getEnvironment(): string;
    public function getLogin(): string;
    public function getPassword(): string;
}