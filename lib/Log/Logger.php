<?php
namespace PromisePay\Log;

/**
 * Class Logger
 * @package PromisePay\Log
 */
class Logger {
    /**
     * Enable or disable PromisePay logger.
     * @var bool
     */
    private static $enable = false;

    /**
     * The Logger method.
     * Change the value of $enable property to true in order
     * to enable logging behaviour. 
     * Logs are stored in report folder, and filenames are in
     * format of PromisePayLog-[year][month][day].
     *
     * @param $errorMessage
     * @return void
     */
    public static function logging($errorMessage) {
        if ($errorMessage && self::$enable === true) {
            $path = dirname(__FILE__) . "/report/";
            $reportFilename = 'PromisePayLog-' . date("Ymd");
            file_put_contents($path . $reportFilename, $errorMessage, FILE_APPEND);
        }
        
        return;
    }
}
