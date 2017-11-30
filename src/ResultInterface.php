<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 25/11/2017
 * Time: 16:24
 */
declare(strict_types=1);
namespace PromisePay;

use Psr\Http\Message\ResponseInterface;

interface ResultInterface extends \ArrayAccess, \IteratorAggregate, \Countable
{
    public function __construct(ResponseInterface $response, string $rootIndex, string $exceptionName);

    /**
     * Provides debug information about the result object
     *
     * @return string
     */
    public function __toString();

    /**
     * Convert the result to an array.
     *
     * @return array
     */
    public function toArray();

    /**
     * Check if the model contains a key by name
     *
     * @param string $name Name of the key to retrieve
     *
     * @return bool
     */
    public function hasKey($name);

    /**
     * Get a specific key value from the result model.
     *
     * @param string $key Key to retrieve.
     *
     * @return mixed|null Value of the key or NULL if not found.
     */
    public function get($key);
}