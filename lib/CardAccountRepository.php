<?php
namespace PromisePay;

use PromisePay\DataObjects\Card;
use PromisePay\DataObjects\CardAccount;
use PromisePay\DataObjects\User;
use PromisePay\Exception;
use PromisePay\Log;

/**
 * Class CardAccountRepository
 *
 * @package PromisePay
 */
class CardAccountRepository extends BaseRepository {
    /**
     * List a card account for a user on a marketplace.
     * Expects ID parameter (in form "ec9bf096-c505-4bef-87f6-18822b9dbf2c").
     *
     * @param string $id
     * @return CardAccount|null
     */
    public function getCardAccountById($id) {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('get', 'card_accounts/'.$id);
        $jsonData = json_decode($response->raw_body, true);
        
        if (array_key_exists('card_accounts', $jsonData)) {
            $accounts = new CardAccount($jsonData['card_accounts']);
            return $accounts;
        } else {
            return null;
        }
    }
    
    /**
     * Create a card account for a user on a marketplace.
     * Expects CardAccount object.
     * 
     * @param CardAccount $card
     * @return CardAccount
     */
    public function createCardAccount(CardAccount $card) {
        $payload = '';
        $preparePayload = array(
                "user_id" =>$card->getUserId(),
                "full_name"=>$card->getCard()->getFullName(),
                "number"=>$card->getCard()->getNumber(),
                "expiry_month"=>$card->getCard()->getExpMonth(),
                "expiry_year"=>$card->getCard()->getExpYear(),
                "cvv"=>$card->getCard()->getCVV()
        );
        foreach ($preparePayload as $key => $value)
        {
            $payload .= $key . '=';
            $payload .= urlencode($value);
            $payload .= "&";
        }

        $response = $this->RestClient('post', 'card_accounts?', $payload);
        $jsonData = json_decode($response->raw_body, true);
        return new CardAccount($jsonData['card_accounts']);
    }
    
    /**
     * Deletes a card account for a user on a marketplace. 
     * Sets the account to in-active.
     * Expects ID parameter (in form "ec9bf096-c505-4bef-87f6-18822b9dbf2c").
     *
     * @param string $id
     * @return bool
     */
    public function deleteCardAccount($id) {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('delete', 'card_accounts/'.$id);
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("errors", $jsonRaw)) {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    /**
     * Lists bank accounts for a user on a marketplace.
     * Expects ID parameter (in form "ec9bf096-c505-4bef-87f6-18822b9dbf2c").
     *
     * @param string $id
     * @return User|null
     */
    public function getUserForCardAccount($id) {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('get','users/'.$id.'/bank_accounts');
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("users", $jsonRaw))
        {
            $jsonData = $jsonRaw["users"];
            $bankAccount = new User($jsonData);
            return $bankAccount;
        }
        return null;
    }
}