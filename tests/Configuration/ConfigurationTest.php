<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 24/11/2017
 * Time: 16:02
 */
declare(strict_types=1);
namespace PromisePay\Test\Addresses;

use PromisePay\Configuration\Configuration;
use PromisePay\Configuration\ConfigurationException;
use PromisePay\Test\PromisePayTestCase;

class ConfigurationTest extends PromisePayTestCase
{
    public function testGetters(): void {
        [$environment, $login, $password] = $this->getConfigurationDetails();
        $configuration = $this->getConfiguration();

        $this->assertEquals($environment, $configuration->getEnvironment());
        $this->assertEquals($login, $configuration->getLogin());
        $this->assertEquals($password, $configuration->getPassword());
    }

    public function testInvalidEnvironment(): void {
        $this->expectException(ConfigurationException::class);

        [$env, $login, $password] = $this->getConfigurationDetails();
        $configuration = new Configuration('bogus', $login, $password);
    }
}