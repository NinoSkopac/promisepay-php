<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 24/12/2017
 * Time: 00:27
 */
declare(strict_types=1);
namespace PromisePay\Test\BankAccounts;

trait BankAccountsExpectedResponses
{
    protected function getExpectedShowResponse(): array {
        $response = <<<'JSON'
{
  "bank_accounts": {
    "id": "46deb476-c1a6-41eb-8eb7-26a695bbe5bc",
    "active": true,
    "created_at": "2016-04-12T09:20:38.540Z",
    "updated_at": "2016-04-13T14:22:40.674Z",
    "verification_status": "not_verified",
    "currency": "AUD",
    "bank": {
      "bank_name": "Bank of Australia",
      "country": "AUS",
      "account_name": "Samuel Seller",
      "routing_number": "XXXXX3",
      "account_number": "XXX234",
      "holder_type": "personal",
      "account_type": "checking",
      "direct_debit_authority_status": "approved"
    },
    "links": {
      "self": "/bank_accounts/46deb476-c1a6-41eb-8eb7-26a695bbe5bc",
      "users": "/bank_accounts/46deb476-c1a6-41eb-8eb7-26a695bbe5bc/users",
      "direct_debit_authorities": "/bank_accounts/46deb476-c1a6-41eb-8eb7-26a695bbe5bc/direct_debit_authorities"
    }
  }
}
JSON;

        return json_decode($response, true)['bank_accounts'];
    }
}