<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 23/11/2017
 * Time: 22:38
 */
declare(strict_types=1);
namespace PromisePay\BankAccounts;

use GuzzleHttp\RequestOptions;
use PromisePay\PromisePayClient;
use PromisePay\Result;

class BankAccountsClient extends PromisePayClient implements BankAccountsInterface
{
    protected const Exception = BankAccountsException::class;
    protected const Root_Index = [
        'create' => 'bank_accounts',
        'get' => 'bank_accounts',
        'redact' => 'bank_account',
        'getUser' => 'users',
        'validateRoutingNumber' => 'routing_number'
    ];

    public function create(
        string $userId, string $bankName, string $accountName,
        string $routingNumber, string $accountNumber, string $accountType,
        string $holderType, string $country, ?string $currency = null, ?string $payoutCurrency = null
    ): ?Result
    {
        $response = $this->guzzle()->post('bank_accounts', [
            RequestOptions::JSON => [
                'user_id' => $userId,
                'bank_name' => $bankName,
                'account_name' => $accountName,
                'routing_number' => $routingNumber,
                'account_number' => $accountNumber,
                'account_type' => $accountType,
                'holder_type' => $holderType,
                'country' => $country,
                'currency' => $currency,
                'payout_currency' => $payoutCurrency
            ]
        ]);

        return new Result($response, self::Root_Index[__FUNCTION__], self::Exception);
    }

    /**
     * @param string $bankAccountId
     * @return null|Result
     */
    public function get(string $bankAccountId): ?Result
    {
        $response = $this->guzzle()->get('bank_accounts/' . $bankAccountId);

        return new Result($response, self::Root_Index[__FUNCTION__], self::Exception);
    }

    /**
     * @param string $bankAccountId
     * @return null|Result
     */
    public function redact(string $bankAccountId): ?Result
    {
        $response = $this->guzzle()->delete('bank_accounts/' . $bankAccountId);

        return new Result($response, self::Root_Index[__FUNCTION__], self::Exception);
    }

    /**
     * @param string $bankAccountId
     * @return null|Result
     */
    public function getUser(string $bankAccountId): ?Result
    {
        $requestPath = sprintf('bank_accounts/%s/users', $bankAccountId);
        $response = $this->guzzle()->get($requestPath);

        return new Result($response, self::Root_Index[__FUNCTION__], self::Exception);
    }

    /**
     * @param string $bankAccountRoutingNumber
     * @return null|Result
     */
    public function validateRoutingNumber(string $bankAccountRoutingNumber): ?Result
    {
        $response = $this->guzzle()->get('tools/routing_number', [
            RequestOptions::JSON => ['routing_number' => $bankAccountRoutingNumber]
        ]);

        return new Result($response, self::Root_Index[__FUNCTION__], self::Exception);
    }
}