<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 10/08/2017
 * Time: 23:23
 */

namespace PromisePay\Tests\Helpers\Interfaces;


interface Debug
{
    /**
     * Debug constructor.
     *
     * @param string $logId
     */
    public function __construct($logId);

    /**
     * Create or append log contents to log ID.
     *
     * @param string $logId
     * @param $logContents
     * @return void
     */
    public static function create($logId, $logContents);

    /**
     * Get log contents for log ID as an array.
     *
     * @param string $logId
     * @return array
     */
    public static function get($logId);

    /**
     * Get log content for log ID as a string.
     *
     * @return string
     */
    public function __toString();
}