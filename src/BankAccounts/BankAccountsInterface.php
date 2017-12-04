<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 23/11/2017
 * Time: 22:38
 */
declare(strict_types=1);
namespace PromisePay\BankAccounts;

use PromisePay\Result;

interface BankAccountsInterface
{
    /**
     * @param string $userId
     * @param string $bankName
     * @param string $accountName
     * @param string $routingNumber
     * @param string $accountNumber
     * @param string $accountType
     * @param string $holderType
     * @param string $country
     * @param null|string $currency
     * @param null|string $payoutCurrency
     * @return null|Result
     */
    public function create(
        string $userId, string $bankName, string $accountName,
        string $routingNumber, string $accountNumber, string $accountType,
        string $holderType, string $country, ?string $currency = null, ?string $payoutCurrency = null
    ): ?Result;

    /**
     * @param string $bankAccountId
     * @return null|Result
     */
    public function get(string $bankAccountId): ?Result;

    /**
     * @param string $bankAccountId
     * @return null|Result
     */
    public function redact(string $bankAccountId): ?Result;

    /**
     * @param string $bankAccountId
     * @return null|Result
     */
    public function getUser(string $bankAccountId): ?Result;

    /**
     * @param string $bankAccountRoutingNumber
     * @return null|Result
     */
    public function validateRoutingNumber(string $bankAccountRoutingNumber): ?Result;
}