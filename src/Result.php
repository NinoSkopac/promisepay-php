<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 25/11/2017
 * Time: 15:46
 */
declare(strict_types=1);
namespace PromisePay;

use PromisePay\Exception\PromisePayExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Traversable;

final class Result implements ResultInterface
{
    /** @var ResponseInterface $response */
    protected $response;
    /** @var array $json */
    protected $json;
    /**
     * @var null|string
     */
    private $rootIndex;
    /**
     * @var null|string
     */
    private $exceptionName;

    /**
     * Result constructor.
     * @param ResponseInterface $response
     * @param string $rootIndex
     * @param string $exceptionName
     * @throws PromisePayExceptionInterface
     */
    public function __construct(ResponseInterface $response, string $rootIndex, string $exceptionName)
    {
        $this->response = $response;
        $this->rootIndex = $rootIndex;
        $this->exceptionName = $exceptionName;

        if (!$this->response->getBody()->isReadable() || empty($this->response->getBody()->getSize())) {
            $message = sprintf("Received empty response with %d status code", $this->response->getStatusCode());
            throw new $this->exceptionName($message, $this->response->getStatusCode());
        }

        if ($this->response->getStatusCode() >= 400) {
            throw new $this->exceptionName($this->response);
        }

        $this->json = json_decode($this->response->getBody()->getContents(), true);

        if ($rootIndex !== null) {
            $this->json = $this->json[$rootIndex];
        }
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->json);
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->json[$offset]);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return isset($this->json[$offset]) ? $this->json[$offset] : null;
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->json[$offset] = $value;
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->json[$offset]);
    }

    /**
     * Provides debug information about the result object
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->json, JSON_PRETTY_PRINT);
    }

    /**
     * Convert the result to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->json;
    }

    /**
     * Check if the model contains a key by name
     *
     * @param string $name Name of the key to retrieve
     *
     * @return bool
     */
    public function hasKey($name)
    {
        return isset($this->json[$name]);
    }

    /**
     * Get a specific key value from the result model.
     *
     * @param string $key Key to retrieve.
     *
     * @return mixed|null Value of the key or NULL if not found.
     */
    public function get($key)
    {
        return $this->json[$key] ?? null;
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->json);
    }
}