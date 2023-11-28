<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function user()
    {
        $user = Auth::user();

        if (!isset($user)) {
            return response()->json([
                "error" => "User not found!"
            ], 404);
        }

        return response()->json([
            "message" => "User found successfully!",
            "user" => $user,
        ], 200);
    }
}
