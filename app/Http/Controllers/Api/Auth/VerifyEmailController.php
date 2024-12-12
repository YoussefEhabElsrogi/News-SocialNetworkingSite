<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\SendOtpVerifyUserEmail;
use App\Traits\ApiResponseTrait;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class VerifyEmailController extends Controller
{
    use ApiResponseTrait;
    protected Otp $otpService;

    /**
     * Constructor to initialize the OTP service.
     */
    public function __construct()
    {
        $this->otpService = new Otp();
    }

    /**
     * Verify the email using the OTP token.
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'token' => 'required|string|size:6', // Ensures the token is valid
        ]);

        $user = auth()->user(); // Fetch authenticated user
        $token = $request->token;

        // Validate the OTP
        $verify = $this->otpService->validate($user->email, $token);

        // Respond with error if OTP is invalid or expired
        if (!$verify->status) {
            return ApiResponseTrait::sendResponse(422, 'Invalid or expired OTP. Please try again.', null);
        }

        // Update email verification timestamp
        $user->update(['email_verified_at' => now()]);

        // Respond with success
        return ApiResponseTrait::sendResponse(200, 'Email verified successfully!', null);
    }

    /**
     * Resend the OTP to the user's email.
     */
    public function sendOtpAgain()
    {
        $user = auth()->user();

        Notification::send($user, new SendOtpVerifyUserEmail());

        return ApiResponseTrait::sendResponse(200, 'OTP has been resent to your email.', null);
    }
}
