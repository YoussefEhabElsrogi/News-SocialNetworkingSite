<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\UpdateSettingRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Utils\ImageManager;

class SettingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('layouts.frontend.dashboard.setting', compact('user'));
    }
    public function update(UpdateSettingRequest $request)
    {
        $request->validated();

        $user = User::findOrFail(auth()->user()->id);
        $user->update($request->except(['_token', 'image']));

        ImageManager::uploadSingleImage($request, $user);

        setFlashMessage('success', 'User Updated Successfully');
        return redirect()->back();
    }
    public function changePassword(Request $request)
    {
        $this->validate($request, $this->filterPasswordRequest());

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            setFlashMessage('error', 'Current Password Doesn\'t Match');
            return redirect()->back();
        }

        $user = User::findOrFail(auth()->user()->id);
        $user->update(['password' => $request->password]);

        setFlashMessage('success', 'Password Updated Successfully');
        return redirect()->back();
    }
    private function filterPasswordRequest(): array
    {
        return
            [
                'current_password' => 'required',
                'password' => 'required|confirmed|min:8',
            ];
    }
}
