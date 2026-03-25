<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'username' => ['Kredensial yang diberikan salah.'],
            ]);
        }

        $user = auth()->guard('api')->user();

        return (new UserResource($user))->additional([
            'meta' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => auth()->guard('api')->factory()->getTTL() * 60 
            ]
        ]);
    }

    public function profile()
    {
        return new UserResource(auth()->guard('api')->user());
    }

    public function updateProfile(UserUpdateRequest $request)
    {
        $user = auth()->guard('api')->user();

        $data = $request->only(['username']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return new UserResource($user);
    }

    public function logout()
    {
        auth()->guard('api')->logout();
        
        return response()->json(['message' => 'Berhasil logout']);
    }
}