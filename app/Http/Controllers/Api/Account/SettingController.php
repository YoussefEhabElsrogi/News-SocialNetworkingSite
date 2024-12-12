<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\UpdateSettingRequest;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    use ApiResponseTrait;
    public function updateSetting(UpdateSettingRequest $request)
    {
        $request->validated();
        $user = User::find(auth()->user()->id);

        if (!$user) {
            return ApiResponseTrait::sendResponse(404, 'User Not Found', null);
        }

        $user->update($request->except(['_method', 'image']));

        ImageManager::uploadSingleImage($request, $user);

        return ApiResponseTrait::sendResponse(200, 'User Updated Successfully', null);
    }
    public function updatePassword(Request $request)
    {
        $request->validate($this->filterPasswordRequest());

        $user = User::find(auth()->user()->id);

        if (!Hash::check($request->current_password, $user->password)) {
            return ApiResponseTrait::sendResponse(401, 'Current Password Doesn\'t Match', null);
        }

        $user->update(['password' => $request->password]);

        $user->tokens()->delete();

        return ApiResponseTrait::sendResponse(200, 'Password Updated Successfully', null);
    }
    private function  filterPasswordRequest(): array
    {
        return  [
            'current_password' => ['required', 'max:20'],
            'password' => ['required', 'confirmed', 'min:8', 'max:20'],
        ];
    }
}
