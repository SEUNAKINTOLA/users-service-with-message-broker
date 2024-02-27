<?php

namespace App\Http\Controllers;

use App\Domain\Models\User;
use App\Domain\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'firstName' => 'required|string',
                'lastName' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Create User object
            $user = new User($request->only(['email', 'firstName', 'lastName']));

            // Save User
            $user = $this->userRepository->save($user);

            return response()->json($user, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while saving user data'], 500);
        }
    }
}
