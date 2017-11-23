<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 23/11/2017
 * Time: 22:48
 */

declare(strict_types=1);
namespace PromisePay\Credentials;

class Configuration implements ConfigurationInterface
{
    /**
     * @var string
     */
    private $environment;
    /**
     * @var string
     */
    private $login;
    /**
     * @var string
     */
    private $password;

    public function __construct(string $environment, string $login, string $password)
    {
        $this->environment = $environment;
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}