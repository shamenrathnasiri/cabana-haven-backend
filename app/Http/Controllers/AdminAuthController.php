<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(AdminLoginRequest $request): JsonResponse
    {
        $identifier = $request->input('email') ?: $request->input('username');
        $password = (string) $request->input('password');

        $query = User::query()->where('is_admin', true);

        if ($request->filled('email')) {
            $query->where('email', $request->input('email'));
        } else {
            $query->where('username', $request->input('username'));
        }

        /** @var User|null $user */
        $user = $query->first();

        if (! $user || ! Hash::check($password, (string) $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials.',
            ], 401);
        }

        $token = $user->createToken('admin')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_admin' => (bool) $user->is_admin,
            ],
        ]);
    }
}
