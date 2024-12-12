<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordReqeust;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use ApiResponseTrait;

    private $otpService;

    public function __construct()
    {
        $this->otpService = new Otp();
    }

    public function resetPassword(ResetPasswordReqeust $request)
    {
        $validatedData = $request->validated();

        $otp = $this->otpService->validate($request->email, $request->token);

        if (!$otp->status) {
            return ApiResponseTrait::sendResponse(400, 'Invalid OTP', null);
        }

        // Reset Password
        $user = User::where('email', $validatedData['email'])->first();

        $user->update(['password' => $validatedData['password']]);

        return ApiResponseTrait::sendResponse(200, 'Password reset successfully', null);
    }
}
