<?php
namespace PromisePay;

use PromisePay\DataObjects\Bank;
use PromisePay\DataObjects\BankAccount;
use PromisePay\DataObjects\User;
use PromisePay\Exception;
use PromisePay\Log;

/*+
 * Class BankAccountRepository
 * @package PromisePay
 */
class BankAccountRepository extends BaseRepository {
    /**
     * Lists a bank account for a user on a marketplace.
     * Expects ID parameter in format of "8d65c86c-14f4-4abf-a979-eba0a87b283a".
     *
     * @param string $id
     * @return BankAccount  
     */
    public function getBankAccountById($id) {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('get', 'bank_accounts/'.$id);
        $jsonData = json_decode($response->raw_body, true);
        $jsonData = $jsonData['bank_accounts'];
        $bankAccounts = new BankAccount($jsonData);
        return $bankAccounts;
    }
    
    /**
     * Create a bank account for a user on a marketplace.
     *
     * @param BankAccount
     * @return BankAccount
     */
    public function createBankAccount(BankAccount $bankAccount) {
        $payload = '';
        $preparePayload = array(
            "user_id" =>$bankAccount->getUserId(),
            "bank_name"=>$bankAccount->getBank()->getBankName(),
            "account_name"=>$bankAccount->getBank()->getAccountName(),
            "routing_number"=>$bankAccount->getBank()->getRoutingNumber(),
            "account_number"=>$bankAccount->getBank()->getAccountNumber(),
            "account_type"=>$bankAccount->getBank()->getAccountType(),
            "holder_type"=>$bankAccount->getBank()->getHolderType(),
            "country"=>$bankAccount->getBank()->getCountry(),
        );
        foreach ($preparePayload as $key => $value)
        {
            $payload .= $key . '=';
            $payload .= urlencode($value);
            $payload .= "&";
        }
        $payload = substr($payload, 0, -1);
        $response = $this->RestClient('post', 'bank_accounts/', $payload);
        $jsonData = json_decode($response->raw_body, true);
        return new BankAccount($jsonData['bank_accounts']);
    }
    
    /**
     * Deletes a bank account for a user on a marketplace. 
     * Sets the account to in-active.
     * Expects ID parameter in format of "8d65c86c-14f4-4abf-a979-eba0a87b283a".
     *
     * @param string $id
     * @return bool
     */
    public function deleteBankAccount($id) {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('delete', 'bank_accounts/'.$id);
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("errors", $jsonRaw)){
            return false;
        }
        else
        {
            return true;
        }
    }
    
    /**
     * Shows the user the bank account belongs to.
     * Expects ID parameter in format of "8d65c86c-14f4-4abf-a979-eba0a87b283a".
     *
     * @param string $id
     * @return User|null
     */
    public function getUserForBankAccount($id) {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('get','bank_accounts/'.$id.'/users');
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("users", $jsonRaw))
        {
            $jsonData = $jsonRaw["users"];
            $users = new User($jsonData);
            return $users;
        }
        return null;
    }
}