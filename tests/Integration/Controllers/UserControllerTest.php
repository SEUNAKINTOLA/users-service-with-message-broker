<?php

namespace Tests\Integration\Controllers;

use App\Domain\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user()
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
