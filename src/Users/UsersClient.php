<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 07/12/2017
 * Time: 03:07
 */
declare(strict_types=1);
namespace PromisePay\Users;

use PromisePay\PromisePayClient;
use PromisePay\Result;

class UsersClient extends PromisePayClient implements UsersInterface
{
    protected const Exception = UsersException::class;
    protected const Root_Index = [
        'list' => 'users'
    ];

    public function getUserCount(): int {
        $response = $this->guzzle()->get('users', [
            'query' => [
                'limit' => 0,
                'offset' => 0
            ]
        ]);

        return (new Result($response, null, self::Exception))->toArray()['meta']['total'];
    }

    public function list(int $limit = 20, int $offset = 0, ?string $search = null): ?Result
    {
        $response = $this->guzzle()->get('users', [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
                'search' => $search
            ]
        ]);

        return new Result($response, self::Root_Index[__FUNCTION__], self::Exception);
    }
}