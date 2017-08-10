<?php
namespace PromisePay\Tests;

/**
 * @param string $testMethod
 * @param array $data
 */
function dumpTestData($testMethod, $data) {
    $output = sprintf("\n\nDumping data for %s: %s\n\n", $testMethod, print_r($data, true));
    fwrite(STDOUT, $output);
}