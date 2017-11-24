<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 23/11/2017
 * Time: 22:48
 */

declare(strict_types=1);
namespace PromisePay\Configuration;

class Configuration implements ConfigurationInterface
{
    protected const ENVIRONMENTS = ['prelive', 'live'];

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

    /**
     * Configuration constructor.
     * @param string $environment
     * @param string $login
     * @param string $password
     * @throws ConfigurationException
     */
    public function __construct(string $environment, string $login, string $password)
    {
        if (!in_array($environment, self::ENVIRONMENTS)) {
            throw new ConfigurationException(
                sprintf(
                    'Environment %s is invalid (valid environments: %s)',
                    $environment,
                    implode(', ', self::ENVIRONMENTS)
                )
            );
        }

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

    public function getHostname(): string
    {
        [$preliveEnv,] = self::ENVIRONMENTS;

        if ($this->environment == $preliveEnv)
            return 'test.api.promisepay.com';

        return 'api.promisepay.com';
    }
}