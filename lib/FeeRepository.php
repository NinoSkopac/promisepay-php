<?php
namespace PromisePay;

use PromisePay\DataObjects\Fee;
use PromisePay\DataObjects\Errors;
use PromisePay\Exception;
use PromisePay\Log;

/**
 * Class FeeRepository
 *
 * @package PromisePay
 */
class FeeRepository extends BaseRepository {
    /**
     * This call allows a marketplace to view 
     * all fees that can be applied to an item.
     * Up to two parameters can be supplied to this function.
     * Limit declares the amount of up to how many results can be returned.
     * Offset declares from which point the results should be retrieved.
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getListOfFees($limit = 20, $offset = 0) {
        $this->paramsListCorrect($limit,$offset);
        $response = $this->RestClient('get', 'fees?limit=' . $limit . '&offset=' . $offset, '', '');
        $allFees = array();
        $jsonData = json_decode($response->raw_body, true)['fees'];
        foreach($jsonData as $onefee )
        {
            $fee = new Fee($onefee);
            array_push($allFees, $fee);
        }
        return $allFees;
    }
    
    /**
     * This call allows a marketplace view all fees that can be applied to an item.
     * Expects ID parameter (in form "ec9bf096-c505-4bef-87f6-18822b9dbf2c").
     * This method is similar to getListOfFees(), except that it returns 
     * only one Fee object.
     *
     * @param string $id
     * @return Fee
     */
    public function getFeeById($id) {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('get', 'fees/' . $id);
        $jsonData = json_decode($response->raw_body, true)['fees'];
        $fee = new Fee($jsonData);
        return $fee;
    }
    
    /**
     * Create a new fee that can be applied to an item.
     * Expects Fee object.
     *
     * @param Fee $fee
     * @return Fee|Errors
     */
    public function createFee(Fee $fee) {
        $this->ValidateFee($fee);
        $payload = '';
        $preparePayload = array(
            "name"        => $fee->getName(),
            "fee_type_id" => $fee->getId(),//or getFeeType()
            "amount"      => $fee->getAmount(),
            "cap"         => $fee->getCap(),
            "min"         => $fee->getMin(),
            "max"         => $fee->getMax(),
            "to"          => $fee->getTo(),
        );
        foreach ($preparePayload as $key => $value)
        {
            $payload .= $key . '=';
            $payload .= urlencode($value);
            $payload .= "&";
        }
        $response = $this->RestClient('post', 'fees/', $payload, '');
        $jsonData = json_decode($response->raw_body, true);
        if(array_key_exists("errors", $jsonData))
        {
            $errors = new Errors($jsonData);
            return $errors;
        }
        else
        {
            $jsonData = $jsonData['fees'];
            $fee = new Fee($jsonData);
            return $fee;
        }
    }
    
    /**
     * Validates Fee.
     * This is an internal method - it doesn't make requests towards API.
     *
     * @param Fee $fee
     * @throws \PromisePay\Exception\Argument
     * @throws \PromisePay\Exception\Validation
     */
    public function ValidateFee(Fee $fee) {
        if ($fee == null)
        {
            throw new Exception\Argument ('fee is empty');
        }
        if (!in_array($fee->getTo(), array("buyer", "seller", "cc", "int_wire", "paypal_payout")))
        {
            throw new Exception\Validation ("To should have value of \"buyer\", \"seller\", \"cc\", \"int_wire\", \"paypal_payout\"");
        }
    }
}