<?php

namespace Tests\Feature\Api\V1\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test /api/v1/auth/login
     */
    public function test_login()
    {
        $user = factory(User::class)->create();

        $data = [
            'nickname' => $user->nickname,
            'password' => 123321,
        ];

        $response = $this->postJson('/api/v1/auth/login', $data);

        $response->assertStatus(200);

        $original = $response->original;

        $this->assertEquals($user->api_token, $original['token']);
    }
}
