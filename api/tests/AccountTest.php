<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AccountTest extends TestCase
{
    public function testAccount()
    {
        $user = \App\Models\User::where(['email' => 'eudotto@gmail.com'])->first();
        $this->actingAs($user, 'api');

        $response = $this->call('GET', '/api/v1/account');
        $this->assertEquals(200, $response->status());

        $account = new \App\Services\AccountService();
        $account = $account->create([
            'customer' => 1,
            'credit' => 10,
            'value' => 10
        ]);

        $this->assertEquals(get_class($account), \App\Models\Account::class);

        \App\Models\Account::destroy($account->id);
    }
}
