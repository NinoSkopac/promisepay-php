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
        $users = PromisePay::Disbursement()->getUsers($this->getDisbursementId());
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
