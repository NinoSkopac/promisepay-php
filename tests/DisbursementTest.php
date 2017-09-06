<?php
namespace PromisePay\Tests;
use PromisePay\PromisePay;

class DisbursementTest extends \PHPUnit_Framework_TestCase {

    protected static $disbursements;
    
    public function testGet() {
        self::$disbursements = PromisePay::Disbursement()->get();

        foreach (self::$disbursements as $disbursement) {
            $this->assertArrayHasKey('id', $disbursement);
        }
    }

    /**
     * @depends testGet
     */
    public function testGetUsers() {
        $user = PromisePay::Disbursement()->getUsers($this->getDisbursementId());

        // although the endpoint is 'users' (plural), this endpoint actually returns
        // one user in the root of JSON response
        $this->assertArrayHasKey('full_name', $user);
        $this->assertArrayHasKey('first_name', $user);
        $this->assertArrayHasKey('last_name', $user);
        $this->assertArrayHasKey('email', $user);
    }

    /**
     * @depends testGet
     */
    public function testGetItems() {
        $items = PromisePay::Disbursement()->getItems($this->getDisbursementId());
    }

    protected function getDisbursementId() {
        return self::$disbursements[0]['id'];
    }
    
}
