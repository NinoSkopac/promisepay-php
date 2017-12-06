<?php
/**
 * Created by PhpStorm.
 * User: ninoskopac
 * Date: 24/11/2017
 * Time: 16:02
 */
declare(strict_types=1);
namespace PromisePay\Test\Addresses;

use PromisePay\Test\PromisePayTestCase;
use PromisePay\Users\UsersClient;

class UsersTest extends PromisePayTestCase
{
    /**
     * @vcr debug
     */
    public function testList(): void {
        $users = new UsersClient($this->getConfiguration());
        $usersList = $users->list();

        var_dump($usersList->toArray());
    }
}