<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 24/11/2017
 * Time: 16:02
 */
declare(strict_types=1);
namespace PromisePay\Test\Addresses;

use PromisePay\BankAccounts\BankAccountsClient;
use PromisePay\Test\PromisePayTestCase;

class BankAccountsTest extends PromisePayTestCase
{
    protected const BANK_ACCOUNT_CREATE_DETAILS = [
        'user_id' => '5715d632-edb7-46cb-9615-f2488d81e39a',
        'bank_name' => 'Bank of Australia',
        'account_name' => 'Samuel Seller',
        'routing_number' => '123123',
        'account_number' => '12341234',
        'account_type' => 'checking',
        'holder_type' => 'personal',
        'country' => 'AUS'
    ];

    /**
     * @vcr default
     */
    public function testCreate(): void {
        $bankAccounts = new BankAccountsClient($this->getConfiguration());
        $bankAccountsCreate = $bankAccounts->create(...array_values(self::BANK_ACCOUNT_CREATE_DETAILS));

        // @TODO assertions
    }
}