<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_register_with_valid_credentials(): void
    {
        $randomEmail = fake()->email();
        $response = $this->postJson('/api/v1/auth/register', [
            'username' => 'Cris',
            'email' => $randomEmail,
            'password' => 'root123',
        ]);

        $response->assertStatus(200);
    }

    public function test_login_with_valid_credentials(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'cris3@mail.com',
            'password' => 'root123',
        ]);

        $response->assertStatus(200);
    }

    public function test_login_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'cris34@mail.com',
            'password' => 'root123',
        ]);

        $response->assertStatus(401);
    }
}
