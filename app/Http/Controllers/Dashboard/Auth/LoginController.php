<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('dashboard.auth.login');
    }
    public function checkAuth(Request $request)
    {
        // Validate input
        $validatedData = $request->validate($this->filterData());

        // Attempt to authenticate
        $credentials = [
            'email' => $validatedData['email'],
            'password' => $validatedData['password']
        ];
        $remember = $request->has('remember_me') && $request->remember_me === 'on';

        // Attempt to authenticate the user
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            // Authentication successful
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
        }

        // Authentication failed
        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function logout(Request $request)
    {
        // Logout the admin
        Auth::guard('admin')->logout();
        // Invalidate the session
        $request->session()->invalidate();
        // Regenerate the CSRF token
        $request->session()->regenerateToken();
        // Redirect to the login page
        return redirect()->route('dashboard.login.show');
    }
    private function filterData(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
            'remember_me' => ['in:on,off'],
        ];
    }
}
