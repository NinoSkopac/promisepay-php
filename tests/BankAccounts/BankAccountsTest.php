<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 24/11/2017
 * Time: 16:02
 */
declare(strict_types=1);
namespace PromisePay\Test\BankAccounts;

use PromisePay\BankAccounts\BankAccountsClient;
use PromisePay\Test\PromisePayTestCase;

class BankAccountsTest extends PromisePayTestCase
{
    use BankAccountsExpectedResponses;

    protected const BANK_ACCOUNT_CREATE_DETAILS = [
        'user_id' => '5830def0-ffe8-11e5-86aa-5e5517507c66',
        'bank_name' => 'Bank of Australia',
        'account_name' => 'Samuel Seller',
        'routing_number' => '123123',
        'account_number' => '12341234',
        'account_type' => 'checking',
        'holder_type' => 'personal',
        'country' => 'AUS'
    ];
    protected const BANK_ACCOUNT_GET_ID = '46deb476-c1a6-41eb-8eb7-26a695bbe5bc';

    /**
     * @vcr default
     */
    public function testCreate(): void {
        $bankAccounts = new BankAccountsClient($this->getConfiguration());
        $bankAccountsCreate = $bankAccounts->create(...array_values(self::BANK_ACCOUNT_CREATE_DETAILS))->toArray();

        // don't check these keys because:
        // user_id is not present in response.bank
        // routing and account numbers are obfuscated
        $discardKeys = ['user_id', 'routing_number', 'account_number'];
        $details = self::BANK_ACCOUNT_CREATE_DETAILS;
        $this->discardKeysFromArrays($discardKeys, $details, $bankAccountsCreate);

        $this->assertArraySubset(['bank' => $details], $bankAccountsCreate);
    }

    /**
     * @vcr default
     */
    public function testGet(): void {
        $bankAccounts = new BankAccountsClient($this->getConfiguration());
        $bankAccountsGet = $bankAccounts->get(self::BANK_ACCOUNT_GET_ID)->toArray();

        $expectedResponse = $this->getExpectedGetResponse();
        $discardKeys = ['active', 'created_at', 'updated_at'];
        $this->discardKeysFromArrays($discardKeys, $bankAccountsGet, $expectedResponse);

        $this->assertEquals($bankAccountsGet, $expectedResponse);
    }
}