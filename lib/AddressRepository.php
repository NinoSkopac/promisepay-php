<?php
namespace PromisePay;

use PromisePay\DataObjects\Address;
use PromisePay\Exception;
use PromisePay\Log;

/**
 * Class AddressRepository
 * 
 * @package PromisePay
 */
class AddressRepository extends BaseRepository {
    /**
     * Get address by ID.
     * ID parameter is in form of "ec9bf096-c505-4bef-87f6-18822b9dbf2c".
     */
    public function getAddressById($id) {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('get','addresses/'.$id);
        $jsonData = json_decode($response->raw_body, true)['addresses'];
        $address = new Address($jsonData);
        return $address;
    }
}