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
    private const LIST_COUNT = 10;
    private const EXPECTED_USER_PROPERTIES = ['id', 'full_name', 'first_name', 'last_name', 'email', 'mobile'];

    /**
     * @vcr default
     */
    public function testList(): void {
        $users = new UsersClient($this->getConfiguration());
        $usersList = $users->list(self::LIST_COUNT)->toArray();

        $this->assertCount(self::LIST_COUNT, $usersList);

        foreach($usersList as $user) {
            foreach (self::EXPECTED_USER_PROPERTIES as $property) {
                $this->assertArrayHasKey($property, $user);
            }
        }
    }

    /**
     * @vcr default
     */
    public function testListWithSearch(): void {
        $users = new UsersClient($this->getConfiguration());
        $samuelUsers = $users->list(self::LIST_COUNT, 0, 'Samuel')->toArray();

        $this->assertNotEmpty($samuelUsers);

        foreach ($samuelUsers as $user)
            $this->assertContains('Samuel', $user['full_name']);
    }
}