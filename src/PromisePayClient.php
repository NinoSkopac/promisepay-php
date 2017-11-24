<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 23/11/2017
 * Time: 22:37
 */
declare(strict_type=1);
namespace PromisePay;
use GuzzleHttp\Client as GuzzleClient;
use PromisePay\Configuration\ConfigurationInterface;

abstract class PromisePayClient implements PromisePayInterface
{
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
        'timeout' => 10
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
        $this->guzzle = new GuzzleClient($this->getGuzzleOptions());
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

    private function getGuzzleOptions(): array {
        if (empty($this->guzzleOptions['base_uri'])) {
            $this->guzzleOptions['base_uri'] = sprintf('https://%s/', $this->configuration()->getHostname());
        }

        if (empty($this->guzzleOptions['auth'])) {
            $this->guzzleOptions['auth'] = [
                'username' => $this->configuration()->getLogin(),
                'password' => $this->configuration()->getPassword()
            ];
        }

        return $this->guzzleOptions;
    }

}