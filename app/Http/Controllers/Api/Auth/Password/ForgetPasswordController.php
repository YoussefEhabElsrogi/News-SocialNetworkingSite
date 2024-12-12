<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendOtpResetPassword;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ForgetPasswordController extends Controller
{
    use ApiResponseTrait;

    public function sendOtp(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'email' => ['required', 'email', 'exists:users,email', 'max:70'],
        ]);

        // Retrieve the user by email
        $user = User::where('email', $validatedData['email'])->first();

        // If the user is not found (redundant since 'exists' rule handles it)
        if (!$user) {
            return ApiResponseTrait::sendResponse(404, 'User not found.', null);
        }

        // Send OTP notification
        Notification::send($user, new SendOtpResetPassword());

        // Return success response
        return ApiResponseTrait::sendResponse(200, 'OTP has been sent to your email. Please check your inbox.', null);
    }
}
