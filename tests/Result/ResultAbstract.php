<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 24/11/2017
 * Time: 16:02
 */
declare(strict_types=1);
namespace PromisePay\Test\Result;

use GuzzleHttp\Psr7\Response;
use PromisePay\Addresses\AddressesException;
use PromisePay\Result;
use PromisePay\Test\PromisePayTestCase;
use Psr\Http\Message\StreamInterface;

abstract class ResultAbstract extends PromisePayTestCase
{
    // @TODO replace with a VCR stub
    /** @var Response $response */
    private $response;
    /** @var Result $result */
    private $result;

    protected function setUpResult(StreamInterface $stream, int $status): void {
        $this->response = new Response($status, [], $stream->getContents());
        $this->result = new Result($this->response, 'addresses', AddressesException::class);
    }

    protected function getPromisePayResult(): Result {
        return $this->result;
    }
}