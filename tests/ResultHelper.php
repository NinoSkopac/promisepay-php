<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 03/01/2018
 * Time: 02:21
 */
declare(strict_types=1);
namespace PromisePay\Test;

trait ResultHelper {
    /**
     * @param array $keys
     * @param array[] $arrays
     */
    protected function discardKeysFromArrays(array $keys, array &...$arrays): void {
        foreach ($arrays as &$array) {
            foreach ($keys as $key) {
                unset($array[$key]);
            }
        }
    }
}