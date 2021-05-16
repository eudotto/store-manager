<?php

use Firebase\JWT\JWT;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthorizationTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = \App\Models\User::where(['email' => 'eudotto@gmail.com'])->first();
    }

    public function testAccess()
    {
        $this->actingAs($this->user, 'api');
        $this->assertEquals($this->user->email, 'eudotto@gmail.com');

        $data = $this->call('POST', '/authorization/token', [
            'email' => 'eudotto@gmail.com',
            'password'=> 'patos'
        ])->decodeResponseJson();

        $authentication = JWT::decode($data['access_token'], env('JWT_KEY'), ['HS256']);
        $this->assertEquals($authentication->email, $this->user->email);
    }
}
