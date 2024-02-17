<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LogoutController extends Controller
{
    /**
     * User logout method
     *
     * @logout
     * @param Request $request
     *
     * @return Json
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                "error" => "User not found!"
            ], 404);
        }

        // delete the teken
        $request->user()->currentAccessToken()->delete();

        // Delete expired tokens also
        // $user->tokens()->where('expires_at', '<', Carbon::now())->delete();

        return Helper::successResponse("Logged out successfully!");
    }
}
