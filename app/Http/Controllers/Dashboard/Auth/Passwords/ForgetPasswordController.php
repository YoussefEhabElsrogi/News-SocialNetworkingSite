<?php

namespace App\Http\Controllers\Dashboard\Auth\Passwords;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\SendOtpNotify;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;

class ForgetPasswordController extends Controller
{
    public $otp2;
    public function __construct()
    {
        $this->otp2 = new Otp();
    }
    public function showEmailForm()
    {
        return view('dashboard.auth.passwords.email');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return redirect()->back()->withErrors(['email' => 'If the email exists, you will receive an OTP.']);
        }

        // Send Otp Code
        $admin->notify(new SendOtpNotify());

        return redirect()->route('dashboard.password.showOtpForm', ['email' => $admin->email])
            ->with('success', 'An OTP has been sent to your email.');
    }

    public function showOtpForm($email)
    {
        return view('dashboard.auth.passwords.confirm', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'token' => ['required', 'min:6']
        ]);

        $otp = $this->otp2->validate($request->email, $request->token);

        if ($otp->status === false) {
            return redirect()->back()->withErrors(['token' => 'Code Is Invaild']);
        }

        return redirect()->route('dashboard.password.resetForm', ['email' => $request->email]);
    }
}
