<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_creation_endpoint()
    {
        $userData = [
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', $userData);
    }
}
