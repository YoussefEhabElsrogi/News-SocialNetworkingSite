<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ApiResponseTrait;

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:50'],
            'password' => ['required', 'max:50'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiResponseTrait::sendResponse(401, 'Invalid email or password', null);
        }

        $token = $user->createToken('auth_token', [], now()->addMinutes(60))->plainTextToken;

        return ApiResponseTrait::sendResponse(200, 'Login successfully', ['token' => $token]);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        $user->currentAccessToken()->delete();

        return ApiResponseTrait::sendResponse(200, 'Logout successfully', null);
    }
}
