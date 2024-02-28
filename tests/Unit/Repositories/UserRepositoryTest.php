<?php

namespace Tests\Unit\Repositories;

use App\Domain\Models\User;
use App\Domain\Repositories\UserRepository;
use App\Jobs\ProcessUserCreation;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    public function test_save_method_dispatches_process_user_creation_job()
    {
        // Arrange
        Queue::fake();
        $userRepository = new UserRepository();
        $user = new User([
            'email' => 'test1@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ]);

        // Act
        $userRepository->save($user);

        // Assert
        Queue::assertPushed(ProcessUserCreation::class, function ($job) use ($user) {
            return $job->getUser()->email === $user->email;
        });
    }
}
