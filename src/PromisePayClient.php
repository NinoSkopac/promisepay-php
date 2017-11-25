<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 23/11/2017
 * Time: 22:37
 */
declare(strict_types=1);
namespace PromisePay;

use GuzzleHttp\Client as GuzzleClient;
use PromisePay\Configuration\ConfigurationInterface;

abstract class PromisePayClient implements PromisePayInterface
{
    public const VERSION = '3.0-dev';

    /**
     * @var ConfigurationInterface
     */
    private $configuration;
    /**
     * @var GuzzleClient
     */
    private $guzzle;

    private $guzzleOptions = [
        'base_uri' => null,
        'allow_redirects' => false,
        'auth' => null,
        'connect_timeout' => 10,
        'timeout' => 10,
        'headers' => [
            'User-Agent' => null
        ]
    ];

    /**
     * PromisePayClient constructor.
     * @param ConfigurationInterface $configuration
     * @param array $guzzleOptions
     */
    public function __construct(ConfigurationInterface $configuration, array $guzzleOptions = [])
    {
        $this->configuration = $configuration;
        $this->guzzleOptions = array_merge($this->guzzleOptions, $guzzleOptions);
        $this->setUpGuzzleOptions();
        $this->guzzle = new GuzzleClient($this->guzzleOptions);
    }

    /**
     * @return ConfigurationInterface
     */
    protected function configuration(): ConfigurationInterface {
        return $this->configuration;
    }

    /**
     * @return GuzzleClient
     */
    protected function guzzle(): GuzzleClient {
        return $this->guzzle;
    }

    private function setUpGuzzleOptions(): void {
        $this->guzzleOptions['base_uri'] = sprintf('https://%s/', $this->configuration()->getHostname());
        $this->guzzleOptions['auth'] = [
            'username' => $this->configuration()->getLogin(),
            'password' => $this->configuration()->getPassword()
        ];
        $this->guzzleOptions['headers']['User-Agent'] = sprintf(
            'PHP_SDK/%s PHP/%s',
            self::VERSION,
            PHP_VERSION
        );
    }
}