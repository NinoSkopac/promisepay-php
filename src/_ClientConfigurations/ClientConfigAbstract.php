<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 30/11/2017
 * Time: 23:18
 */
declare(strict_types=1);
namespace PromisePay\_ClientConfigurations;


abstract class ClientConfigAbstract implements ClientConfigInterface
{
    /**
     * @var string
     */
    private $rootIndex;
    /**
     * @var string
     */
    private $exceptionClassName;

    public function __construct()
    {
        if (!isset(static::CONFIG) || count(static::CONFIG) !== 2) {
            throw new \RuntimeException('Internal error, CONFIG const does not exist or is in invalid format.');
        }

        [$rootIndex, $exceptionClassName] = static::CONFIG;
        $this->rootIndex = $rootIndex;
        $this->exceptionClassName = $exceptionClassName;
    }

    public function getRootIndex(): string
    {
        return $this->rootIndex;
    }

    public function getExceptionName(): string
    {
        return $this->exceptionClassName;
    }
}