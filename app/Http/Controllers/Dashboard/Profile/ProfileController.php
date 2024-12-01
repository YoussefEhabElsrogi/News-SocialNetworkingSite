<?php

namespace App\Http\Controllers\Dashboard\Profile;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:profile');
    }
    public function index()
    {
        return view('dashboard.profile.index');
    }
    public function update(Request $request)
    {
        $request->validate($this->filterData());

        $admin = Admin::findOrFail(auth('admin')->user()->id);

        if (!Hash::check($request->password, $admin->password)) {
            setFlashMessage('error', 'Sorry, the current password is incorrect.');
            return redirect()->back();
        }

        $validatedData = $request->only(['name', 'email', 'username']);

        $admin->update($validatedData);

        setFlashMessage('success', 'Profile updated successfully.');
        return redirect()->route('dashboard.profile.index');
    }

    private function filterData(): array
    {
        return [
            'name' => ['required', 'min:2', 'max:60'],
            'email' => ['required', 'email', 'unique:admins,email,' . Auth::guard('admin')->user()->id],
            'password' => ['required'],
        ];
    }
}
