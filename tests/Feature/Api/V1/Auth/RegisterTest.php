<?php

namespace Tests\Feature\Api\V1\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test /api/v1/auth/register
     */
    public function test_register()
    {
        $data = [
            'nickname' => 'php',
            'password' => bcrypt(123321),
        ];

        $response = $this->postJson('/api/v1/auth/register', $data);

        $response->assertStatus(200);

        $original = $response->original;

        $user = User::where('nickname', $original['nickname'])->first();

        $this->assertNotNull($user);
        $this->assertEquals($original['token'], $user->api_token);
    }
}
