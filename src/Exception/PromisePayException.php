<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 24/11/2017
 * Time: 16:21
 */
declare(strict_types=1);
namespace PromisePay\Exception;

use Psr\Http\Message\ResponseInterface;
use Throwable;

class PromisePayException extends \Exception implements PromisePayExceptionInterface
{
    private $json;
    private $errors = [];

    /**
     * PromisePayException constructor.
     * @param ResponseInterface|string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", int $code = 0, Throwable $previous = null)
    {
        if ($message instanceof ResponseInterface) {
            $this->json = \GuzzleHttp\json_decode($message->getBody()->getContents(), true);
            $this->errors = $this->json['errors'] ?? $this->json;

            $code = $message->getStatusCode();
            $message = sprintf(
                '%d %s: %s',
                $code,
                $message->getReasonPhrase(),
                \GuzzleHttp\json_encode($this->errors)
            );
        }

        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}