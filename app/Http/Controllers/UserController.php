<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Http\Resources\UserResource;
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

        $userResource = new UserResource($user);

        return Helper::successResponse("User found successfully!", $userResource, 200);
    }
}
