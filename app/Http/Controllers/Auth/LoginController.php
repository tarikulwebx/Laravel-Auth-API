<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * User login
     *
     * @method login
     * @param LoginRequest request
     *
     * @return Json
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('login_token')->plainTextToken;

            // assign token expiration date
            $expirationTime = 60 * 24 * 30; // 30 days expiration time
            $user->tokens()->orderBy('created_at', 'desc')->first()->update(['expires_at' => now()->addMinutes($expirationTime)]);
            $user = $user->fresh();

            // return token, details with cookie
            return response()->json([
                'token' => $token,
                'user' => $user,
            ])->cookie('token', $token, $expirationTime);
        }

        return Helper::errorResponse('Invalid credentials');
    }
}
