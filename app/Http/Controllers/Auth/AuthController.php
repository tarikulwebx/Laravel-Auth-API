<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * New User Registration
     *
     * @register
     * @param Request request
     *
     * @return JSON
     */
    public function register(Request $request)
    {
        // request validations
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "username" => "required|string|max:255|unique:users",
            "email" => "required|string|email|max:255|unique:users",
            "password" => "required|string|min:6|confirmed",
        ]);

        // validation error response
        if ($validator->fails()) {
            return response()->json([
                "message" => "Validation failed!",
                "errors" => $validator->errors()
            ], 422);
        }

        // register as new user
        $user = new User([
            "name" => $request->name,
            "username" => $request->username,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        $user->save();

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


    /**
     * Login user
     *
     * @login
     * @param Request request
     *
     * @return JSON
     */
    public function login(Request $request)
    {
        // request validation
        $validator = Validator::make($request->all(), [
            "email_or_username" => "required|string|max:255",
            "password" => "required"
        ]);

        // validation error response
        if ($validator->fails()) {
            return response()->json([
                "message" => "Validation failed!",
                "errors" => $validator->errors()
            ], 422);
        }

        // validated input credentails
        $credentials = $validator->validated();

        // login type (username/email)
        $loginType = filter_var($credentials['email_or_username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // finding user from the database
        $user = User::where($loginType, $credentials['email_or_username'])->first();

        // invalid response if user not exists
        if (!$user) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // password check
        if (!Hash::check($credentials["password"], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // login token
        $token = $user->createToken("auth_token")->plainTextToken;

        // token expiration
        $expirationTime = 60 * 24 * 30;
        $user->tokens()->orderBy('created_at', 'desc')->first()->update(['expires_at' => now()->addMinutes($expirationTime)]);

        // success login response with token, username with cookie
        return response()->json([
            'token' => $token,
            'user' => $user,
        ])->cookie('token', $token, $expirationTime);
    }
}
