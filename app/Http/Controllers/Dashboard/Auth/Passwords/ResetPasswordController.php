<?php

namespace App\Http\Controllers\Dashboard\Auth\Passwords;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function showResetForm($email)
    {
        return view('dashboard.auth.passwords.reset', compact('email'));
    }
    public function resetPassword(Request $request)
    {
        $request->validate($this->filterData());

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return redirect()->back()->with(['error' => 'Try Again Later!']);
        }

        $admin->update([
            'password' => $request->password
        ]);

        return redirect()->route('dashboard.login.show')->with('success', 'Your Password Updated Successfully!');
    }
    private function filterData(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed']
        ];
    }
}
