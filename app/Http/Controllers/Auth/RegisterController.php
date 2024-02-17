<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * User registration
     *
     * @method register
     * @param RegisterRequest $request
     *
     * @return Json
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            "name"     => $request->name,
            "email"    => $request->email,
            "password" => Hash::make($request->password),
        ]);

        // auth tokenization
        $token = $user->createToken("auth_token")->plainTextToken;
        $expirationTime = 60 * 24 * 30; // 30 days expiration time

        // assign token expiration date
        $user->tokens()->orderBy('created_at', 'desc')->first()->update(['expires_at' => now()->addMinutes($expirationTime)]);
        $user = $user->fresh();

        // return token, details with cookie
        return response()->json([
            'token' => $token,
            'user' => $user,
        ])->cookie('token', $token, $expirationTime);
    }
}
