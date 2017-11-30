<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 30/11/2017
 * Time: 22:52
 */
declare(strict_types=1);
namespace PromisePay\Test\Result;

use function GuzzleHttp\Psr7\stream_for;
use PromisePay\Addresses\AddressesException;

class Result400Test extends ResultAbstract
{
    private $json;

    public function setUp(): void {
        $this->json = <<<'JSON'
{"errors":{"id":["invalid format"]}}
JSON;
    }

    public function testExceptionThrown(): void {
        $this->expectException(AddressesException::class);
        $this->setUpResult(stream_for($this->json), 400);
    }

    public function testException(): void {
        try {
            $this->setUpResult(stream_for($this->json), 400);
            $this->fail('An Exception has not been thrown in ' . __METHOD__);
        } catch (AddressesException $addressesException) {
            $this->assertArrayHasKey('id', $addressesException->getErrors());
            $this->assertEquals(400, $addressesException->getCode());
            $this->assertContains((string) $addressesException->getCode(), $addressesException->getMessage());
        }
    }
}