<?php
namespace PromisePay;

use PromisePay\DataObjects\Item;
use PromisePay\DataObjects\User;
use PromisePay\DataObjects\BPayDetails;
use PromisePay\DataObjects\Fee;
use PromisePay\DataObjects\Errors;
use PromisePay\DataObjects\ItemStatus;
use PromisePay\DataObjects\Transaction;
use PromisePay\DataObjects\WireDetails;
use PromisePay\Exception;
use PromisePay\Log;

/**
 * Class ItemRepository
 * @package PromisePay
 */
class ItemRepository extends BaseRepository {
    /**
     *  List all items for a marketplace.
     *
     * @param int $limit
     * @param int $offset
     * return array|null
     */
    public function getListOfItems($limit = 20, $offset = 0) {
        $this->paramsListCorrect($limit,$offset);
        $response = $this->RestClient('get', 'items?limit=' . $limit . '&offset=' . $offset, '', '');
        $jsonRaw = json_decode($response->raw_body, true);
        
        if (array_key_exists("items", $jsonRaw))
        {
            $jsonData = $jsonRaw['items'];
            $allItems = array();
            
            foreach($jsonData as $oneItem )
            {
                $item = new Item($oneItem);
                array_push($allItems, $item);
            }
            
            return $allItems;
        }
        return null;
    }
    
    /**
     * List a single item for a marketplace. 
     * Note: Please use getItemStatus() (/items/:id/status) if 
     * polling of state changes are required.
     * Expects ID parameter in format of "8d65c86c-14f4-4abf-a979-eba0a87b283a".
     *
     * @param string $id
     * @return Item|null
     */
    public function getItemById($id)
    {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('get', 'items/' . $id);
        
        $jsonData = json_decode($response->raw_body, true);
        
        if (array_key_exists('items', $jsonData)) {
            $jsonDataItems = $jsonData['items'];
            $item = new Item($jsonDataItems);
            return $item;
        } else {
            // there was an error
            return null;
        }
    }
    
    /**
     * Create an item for a marketplace.
     *
     * @param Item $item
     * @return Errors|Item
     */
    public function createItem(Item $item)
    {
        $payload = '';
        $preparePayload = array(
            "id"            => $item->getId(),
            "name"          => $item->getName(),
            "amount"        => $item->getAmount(),
            "payment_type"  => $item->getPaymentType(),
            "buyer_id"      => $item->getBuyerId(),
            "seller_id"     => $item->getSellerId(),
            "fee_ids"       => $item->getFeeIds(),
            "description"   => $item->getDescription()
        );
        foreach ($preparePayload as $key => $value)
        {
            $payload .= $key . '=';
            $payload .= urlencode($value);
            $payload .= "&";
        }

        $response = $this->RestClient('post', 'items/', $payload, '');
        $jsonData = json_decode($response->raw_body, true);
        
        if(array_key_exists("errors", $jsonData))
        {
            $errors = new Errors($jsonData);
            return $errors;
        }
        else
        {
            $jsonData = $jsonData['items'];
            $item = new Item($jsonData);
            return $item;
        }
    }
    
    /**
     * Delete an item for a marketplace. 
     * Can only delete an item if it is in the pending state. 
     * Deleting the item puts it into the cancelled state.
     * Expects ID parameter in format of "8d65c86c-14f4-4abf-a979-eba0a87b283a".
     *
     * @param string $id
     * @return bool
     */
    public function deleteItem($id)
    {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('delete', 'items/' . $id);
        if ($response->code){
            return false;
        }
        else
        {
            return true;
        }
    }
    
    /**
     * Update the attributes of an item.
     *
     * @param Item $item
     * @param string $user
     * @param string $account
     * @param string $releaseAmount
     * @return Errors|Item
     */
    public function updateItem(Item $item, $user = null, $account = null, $releaseAmount = null) {
        $payload = '';
        $preparePayload = array(
           'id'=>$item->getId(),
           'user'=>$user,
           'amount'=>$item->getAmount(),
           'name'=>$item->getName(),
           'account'=>$account,
           'release_amount'=>$releaseAmount,
           'description'=>$item->getDescription(),
           'buyer_id'=>$item->getBuyerId(),
           'seller_id'=>$item->getSellerId(),
        );
        array_shift($preparePayload);
        foreach ($preparePayload as $key => $value)
        {
            $payload .= $key . '=';
            $payload .= urlencode($value);
            $payload .= "&";
        }

        $response = $this->RestClient('patch', 'items/'.$item->getId().'?'.$payload);
        $jsonData = json_decode($response->raw_body, true);
        if(array_key_exists("errors", $jsonData))
        {
            $errors = new Errors($jsonData);
            return $errors;
        }
        else
        {
            $jsonData = $jsonData['items'];
            $editedItem = new Item($jsonData);
            return $editedItem;
        }
    }
    
    /**
     * List the transaction ID's of a single item for a marketplace. 
     * Note that the transactions relate specifically to the item.
     * Expects ID parameter in format of "8d65c86c-14f4-4abf-a979-eba0a87b283a".
     * 
     * @param string $id
     * @return array
     */
    public function getListOfTransactionsForItem($id)
    {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('get', 'items/' . $id . '/transactions');
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("transactions", $jsonRaw))
        {
            $jsonData = $jsonRaw["transactions"];
            $allTransactions = array();
            foreach ($jsonData as $oneTransaction) {
                $transaction = new Transaction($oneTransaction);
                array_push($allTransactions, $transaction);
            }
            return $allTransactions;
        }
        return array();
    }
    
    /**
     * Show the status of a single item for a marketplace
     * Expects ID parameter in format of "8d65c86c-14f4-4abf-a979-eba0a87b283a".
     *
     * @param string $id
     * @return ItemStatus|null
     */
    public function getItemStatus($id)
    {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('get', 'items/' . $id . '/status');
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("items", $jsonRaw))
        {
            $jsonData = $jsonRaw["items"];
            $itemStatus = new ItemStatus($jsonData);
            return $itemStatus;
        }
        return null;
    }
    
    /**
     * The fees call allows a marketplace the 
     * ability to view fees assigned to an item.
     * Expects ID parameter in format of "8d65c86c-14f4-4abf-a979-eba0a87b283a".
     *
     * @param string $id
     * @return array
     */
    public function getListFeesForItems($id)
    {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('get', 'items/' . $id . '/fees');
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("fees", $jsonRaw))
        {
            $jsonData = $jsonRaw["fees"];
            $allFees = array();
            foreach ($jsonData as $oneFee) {
                $fee = new Fee($oneFee);
                array_push($allFees, $fee);
            }
            return $allFees;
        }
        return array();
    }
    
    /**
     * Show the buyers' details for a single item for a marketplace.
     * Expects ID parameter in format of "8d65c86c-14f4-4abf-a979-eba0a87b283a".
     *
     * @param string $id
     * @return User|null
     */
    public function getBuyerOfItem($id)
    {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('get', 'items/' . $id . '/buyers');
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("users", $jsonRaw))
        {
            $jsonData = $jsonRaw["users"];
            $user = new User($jsonData);
            return $user;
        }
        return null;
    }
    
    /**
     * Show the sellers' details for a single item for a marketplace.
     * Expects ID parameter in format of "8d65c86c-14f4-4abf-a979-eba0a87b283a".
     *
     * @param string $id
     * @return User|null
     */
    public function getSellerForItem($id)
    {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('get', 'items/' . $id . '/sellers');
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("users", $jsonRaw))
        {
            $jsonData = $jsonRaw["users"];
            $user = new User($jsonData);
            return $user;
        }
        return null;
    }
    
    /**
     * Show the wire details for payment.
     * Expects ID parameter in format of "3cbdc0fd72d157cf2815e819aee23827a9f35001".
     *
     * @param string $id
     * @return WireDetails|null
     */
    public function getWireDetailsForItem($id)
    {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('get', 'items/' . $id . '/wire_details');
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("items", $jsonRaw))
        {
            $jsonData = $jsonRaw["items"];
            $wireDetails = new WireDetails($jsonData);
            return $wireDetails;
        }
        return null;
    }
    
    /**
     * Show the wire details for payment.
     * Expects ID parameter in format of "3cbdc0fd72d157cf2815e819aee23827a9f35001".
     *
     * @param string $id
     * @return BPayDetails|null
     */
    public function getBPayDetailsForItem($id)
    {
        $this->checkIdNotNull($id);
        $response = $this->RestClient('get', 'items/' . $id . '/bpay_details');
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("items", $jsonRaw))
        {
            $jsonData = $jsonRaw["items"];
            $bpayDetails = new BPayDetails($jsonData);
            return $bpayDetails;
        }
        return null;
    }
    
    /**
     * Make payment.
     *
     * @param string $itemId
     * @param string $accountId
     * @return  Item|null
     */
    public function makePayment($itemId, $accountId)
    {
        $this->checkIdNotNull($itemId);
        $this->checkIdNotNull($accountId);

        $payload = '';
        $preparePayload = array(
            "account_id"          => $accountId
         );
        foreach ($preparePayload as $key => $value)
        {
            $payload .= $key . '=';
            $payload .= urlencode($value);
            $payload .= "&";
        }
        $payload = substr($payload,0,-1);

        $response = $this->RestClient('patch', 'items/' . $itemId . '/make_payment', $payload);
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("items", $jsonRaw))
        {
            $jsonData = $jsonRaw["items"];
            $itemStatus = new Item($jsonData);
            return $itemStatus;
        }
        return null;
    }
    
    /**
     * Request payment.
     *
     * @param string itemId
     * @return Item|null
     */
    public function requestPayment($itemId)
    {
        $this->checkIdNotNull($itemId);

        $response = $this->RestClient('patch', 'items/' . $itemId . '/request_payment');
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("items", $jsonRaw))
        {
            $jsonData = $jsonRaw["items"];
            $itemStatus = new Item($jsonData);
            return $itemStatus;
        }
        return null;
    }
    
    /**
     * Release payment.
     *
     * @param string $itemId
     * @param string $releaseAmount
     * @return Item|null
     */
    public function releasePayment($itemId, $releaseAmount)
    {
        $this->checkIdNotNull($itemId);
        $this->checkIdNotNull($releaseAmount);

        $payload = '';
        $preparePayload = array(
            "release_amount" => $releaseAmount
        );

        foreach ($preparePayload as $key => $value)
        {
            $payload .= $key . '=';
            $payload .= urlencode($value);
            $payload .= "&";
        }
        $payload = substr($payload,0,-1);

        $response = $this->RestClient('patch', 'items/' . $itemId . '/release_payment', $payload);
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("items", $jsonRaw))
        {
            $jsonData = $jsonRaw["items"];
            $itemStatus = new Item($jsonData);
            return $itemStatus;
        }
        return null;
    }
    
    /**
     * Request release.
     *
     * @param string $itemId
     * @param string $releaseAmount
     * @return Item|null
     */
    public function requestRelease($itemId, $releaseAmount)
    {
        $this->checkIdNotNull($itemId);
        $this->checkIdNotNull($releaseAmount);

        $payload = '';
        $preparePayload = array(
            "release_amount" => $releaseAmount
        );

        foreach ($preparePayload as $key => $value)
        {
            $payload .= $key . '=';
            $payload .= urlencode($value);
            $payload .= "&";
        }
        $payload = substr($payload,0,-1);

        $response = $this->RestClient('patch', 'items/' . $itemId . '/request_release', $payload);
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("items", $jsonRaw))
        {
            $jsonData = $jsonRaw["items"];
            $itemStatus = new Item($jsonData);
            return $itemStatus;
        }
        return null;
    }
    
    /**
     * Cancel item.
     *
     * @param string $itemId
     * @return Item|null
     */
    public function cancelItem($itemId)
    {
        $this->checkIdNotNull($itemId);
        $response = $this->RestClient('patch', 'items/' . $itemId . '/cancel');
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("items", $jsonRaw))
        {
            $jsonData = $jsonRaw["items"];
            $itemStatus = new Item($jsonData);
            return $itemStatus;
        }
        return null;
    }
    
    /**
     * Acknowledge wire transfer.
     *
     * @param string $itemId
     * @return Item|null
     */
    public function acknowledgeWire($itemId)
    {
        $this->checkIdNotNull($itemId);

        $response = $this->RestClient('patch', 'items/' . $itemId . '/acknowledge_wire');
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("items", $jsonRaw))
        {
            $jsonData = $jsonRaw["items"];
            $itemStatus = new Item($jsonData);
            return $itemStatus;
        }
        return null;
    }
    
    /**
     * Acknowledge PayPal transfer.
     *
     * @param string $itemId
     * @return Item|null
     */
    public function acknowledgePayPal($itemId)
    {
        $this->checkIdNotNull($itemId);

        $response = $this->RestClient('patch', 'items/' . $itemId . '/acknowledge_paypal');
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("items", $jsonRaw))
        {
            $jsonData = $jsonRaw["items"];
            $itemStatus = new Item($jsonData);
            return $itemStatus;
        }
        return null;
    }
    
    /**
     * Revert wire transfer.
     *
     * @param string $itemId
     * @return Item|null
     */
    public function revertWire($itemId)
    {
        $response = $this->RestClient('patch', 'items/' . $itemId . '/revert_wire');
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("items", $jsonRaw))
        {
            $jsonData = $jsonRaw["items"];
            $itemStatus = new Item($jsonData);
            return $itemStatus;
        }
        return null;
    }
    
    /**
     * Request refund.
     *
     * @param string $itemId
     * @param string $refundAmount
     * @param string $refundMesage
     * @return Item|null
     */
    public function requestRefund($itemId, $refundAmount, $refundMessage)
    {
        $this->checkIdNotNull($itemId);
        $this->checkIdNotNull($refundAmount);
        $this->checkIdNotNull($refundMessage);

        $payload = '';
        $preparePayload = array(
            "refund_amount"  => $refundAmount,
            "refund_message" => $refundMessage
        );

        foreach ($preparePayload as $key => $value)
        {
            $payload .= $key . '=';
            $payload .= urlencode($value);
            $payload .= "&";
        }
        $payload = substr($payload,0,-1);

        $response = $this->RestClient('patch', 'items/' . $itemId . '/request_refund', $payload);
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("items", $jsonRaw))
        {
            $jsonData = $jsonRaw["items"];
            $itemStatus = new Item($jsonData);
            return $itemStatus;
        }
        return null;
    }
    
    /**
     * Request refund.
     *
     * @param string $itemId
     * @param string $refundAmount
     * @param string $refundMesage
     * @return Item|null
     */
    public function refund($itemId, $refundAmount, $refundMessage)
    {
        $this->checkIdNotNull($itemId);
        $this->checkIdNotNull($refundAmount);
        $this->checkIdNotNull($refundMessage);

        $payload = '';
        $preparePayload = array(
            "refund_amount"  => $refundAmount,
            "refund_message" => $refundMessage
        );

        foreach ($preparePayload as $key => $value)
        {
            $payload .= $key . '=';
            $payload .= urlencode($value);
            $payload .= "&";
        }
        $payload = substr($payload,0,-1);

        $response = $this->RestClient('patch', 'items/' . $itemId . '/refund', $payload);
        $jsonRaw = json_decode($response->raw_body, true);
        if (array_key_exists("items", $jsonRaw))
        {
            $jsonData = $jsonRaw["items"];
            $itemStatus = new Item($jsonData);
            return $itemStatus;
        }
        return null;
    }
}
