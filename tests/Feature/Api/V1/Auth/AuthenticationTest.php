<?php

namespace Tests\Feature\Api\V1\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test /api/v1/authentication
     */
    public function test_authentication()
    {
        $data = [
            'nickname' => 'php',
            'password' => 123321,
        ];

        $response = $this->postJson('/api/v1/authentication', $data);
        $response->assertStatus(200);

        $original = $response->original;

        $user = User::where('nickname', $data['nickname'])->first();

        $this->assertNotNull($user);
        $this->assertEquals($original['nickname'], $user->nickname);

        $response = $this->postJson('/api/v1/authentication', $data);

        $response->assertStatus(200);
    }
}
