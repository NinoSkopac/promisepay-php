<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 11/08/2017
 * Time: 01:20
 */

namespace PromisePay\Tests\Helpers;


class DebugFailing extends Debug
{
    /**
     * DebugFailing constructor.
     * @param string $logId
     */
    public function __construct($logId = __CLASS__)
    {
        parent::__construct($logId);
    }

    /**
     * @param string $method
     * @param mixed $data
     */
    public static function createForFailing($method, $data) {
        parent::create(__CLASS__, [
            'method' => $method,
            'debug data' => $data
        ]);
    }

    /**
     * @return array
     */
    public static function getForFailing() {
        return parent::get(__CLASS__);
    }
}