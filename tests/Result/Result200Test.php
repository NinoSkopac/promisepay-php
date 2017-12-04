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

class Result200Test extends ResultAbstract
{
    public function setUp(): void {
        $json = <<<'RESPONSE'
{
  "addresses": {
    "addressline1": "100 Main Street",
    "addressline2": "",
    "postcode": "2000",
    "city": "Sydney",
    "state": "NSW",
    "id": "fe602dcf-4175-4f88-b5be-3beb04092dcd",
    "country": "Australia",
    "links": {
      "self": "/addresses/fe602dcf-4175-4f88-b5be-3beb04092dcd"
    }
  }
}
RESPONSE;
        $this->setUpResult(stream_for($json), 200);
    }

    public function testIterator(): void {
        /** @var \ArrayAccess $iterator */
        $iterator = $this->getPromisePayResult()->getIterator();

        $this->assertInstanceOf(\Traversable::class, $iterator);
        $this->assertInstanceOf(\ArrayAccess::class, $iterator);
        $this->assertArrayHasKey('city', $iterator);
        $this->assertArrayHasKey('id', $iterator);
    }

    public function testToArray(): void {
        $array = $this->getPromisePayResult()->toArray();

        $this->assertArrayHasKey('city', $array);
        $this->assertArrayHasKey('id', $array);
    }

    public function testArrayAccess(): void {
        $this->assertEquals($this->getPromisePayResult()->toArray()['id'], $this->getPromisePayResult()['id']);
    }

    public function testHasKey(): void {
        $result = $this->getPromisePayResult();

        $this->assertTrue($result->hasKey('id'));
        $this->assertFalse($result->hasKey('foo'));
    }

    public function testCount(): void {
        $this->assertEquals(8, count($this->getPromisePayResult()));
    }
}