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
    protected function getExpectedGetResponse(): array {
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

    protected function getExpectedShowBankUserResponse(): array {
        $response = <<<'JSON'
{
  "users": {
    "created_at": "2016-04-12T08:13:10.665Z",
    "updated_at": "2016-04-12T08:13:10.665Z",
    "full_name": "Samuel Seller",
    "email": "samuel.seller@assemblypayments.com",
    "mobile": "+61491570156",
    "phone": null,
    "logo_url": null,
    "color_1": null,
    "color_2": null,
    "first_name": "Samuel",
    "last_name": "Seller",
    "id": "5830def0-ffe8-11e5-86aa-5e5517507c66",
    "custom_descriptor": "Sam Garden Jobs",
    "location": "AUS",
    "verification_state": "pending",
    "held_state": false,
    "roles": [
      "customer"
    ],
    "dob": "encrypted",
    "government_number": "encrypted",
    "drivers_license": null,
    "flags": {},
    "related": {
      "addresses": "fe602dcf-4175-4f88-b5be-3beb04092dcd",
      "payout_account": "46deb476-c1a6-41eb-8eb7-26a695bbe5bc"
    },
    "links": {
      "self": "/bank_accounts/5830def0-ffe8-11e5-86aa-5e5517507c66/users",
      "items": "/users/5830def0-ffe8-11e5-86aa-5e5517507c66/items",
      "card_accounts": "/users/5830def0-ffe8-11e5-86aa-5e5517507c66/card_accounts",
      "paypal_accounts": "/users/5830def0-ffe8-11e5-86aa-5e5517507c66/paypal_accounts",
      "bank_accounts": "/users/5830def0-ffe8-11e5-86aa-5e5517507c66/bank_accounts",
      "wallet_accounts": "/users/5830def0-ffe8-11e5-86aa-5e5517507c66/wallet_accounts"
    }
  }
}
JSON;

        return json_decode($response, true)['users'];
    }

    protected function getExpectedValidateRoutingNumberResponse(): array {
        $response = <<<'JSON'
{
  "routing_number": {
    "routing_number": "122235821",
    "customer_name": "US BANK NA",
    "address": "EP-MN-WN1A",
    "city": "ST. PAUL",
    "state_code": "MN",
    "zip": "55107",
    "zip_extension": "1419",
    "phone_area_code": "800",
    "phone_prefix": "937",
    "phone_suffix": "6310"
  }
}
JSON;

        return json_decode($response, true)['routing_number'];
    }
}