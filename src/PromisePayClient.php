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
use PromisePay\Credentials\ConfigurationInterface;

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

    /**
     * PromisePayClient constructor.
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
        $this->guzzle = new GuzzleClient();
    }

    /**
     * @return ConfigurationInterface
     */
    protected function credentials(): ConfigurationInterface {
        return $this->configuration;
    }

    /**
     * @return GuzzleClient
     */
    protected function guzzle(): GuzzleClient {
        return $this->guzzle;
    }
}