<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 07/12/2017
 * Time: 03:06
 */
declare(strict_types=1);
namespace PromisePay\Users;

use PromisePay\Result;

interface UsersInterface
{
    /**
     * @param int $limit
     * @param int $offset
     * @param string $search
     * @return null|Result
     */
    public function list(int $limit, int $offset, string $search): ?Result;
    // @TODO other endpoints
}