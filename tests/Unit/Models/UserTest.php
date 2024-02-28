<?php

namespace Tests\Unit\Models;

use App\Domain\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user()
    {
        $userData = [
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];

        $user = User::create($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userData['email'], $user->email);
        $this->assertEquals($userData['firstName'], $user->firstName);
        $this->assertEquals($userData['lastName'], $user->lastName);
    }
}
