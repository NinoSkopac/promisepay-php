<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 10/08/2017
 * Time: 23:22
 */

namespace PromisePay\Tests\Helpers;

class Debug implements Interfaces\Debug
{
    protected static $logs = [];
    protected $logId;

    public function __construct($logId)
    {
        $this->logId = $logId;
    }

    public static function create($logId, $logContents) {
        self::appendLog($logId, $logContents);
    }

    public static function get($logId) {
        try {
            return self::getById($logId);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function __toString() {
        $log = self::get($this->logId);

        return print_r($log, true);
    }

    /**
     * @param string $logId
     * @param $logContents
     */
    protected static function appendLog($logId, $logContents) {
        static::$logs[$logId][] = $logContents;
    }

    /**
     * @param string $logId
     * @return mixed
     * @throws \Exception
     */
    protected static function getById($logId) {
        if (!isset(static::$logs[$logId]))
            throw new \Exception("Logs don't contain $logId in " . __METHOD__);

        return static::$logs[$logId];
    }
}