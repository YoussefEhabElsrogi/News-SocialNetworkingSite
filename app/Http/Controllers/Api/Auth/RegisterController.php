<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Notifications\SendOtpVerifyUserEmail;
use App\Traits\ApiResponseTrait;
use App\Utils\ImageManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class RegisterController extends Controller
{
    use ApiResponseTrait;

    public function register(StoreUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->createUser($request);

            if (!$user) {
                return ApiResponseTrait::sendResponse(400, 'Try Again Latter!', null);
            }

            if ($request->hasFile('image')) {
                ImageManager::uploadSingleImage($request, $user);
            }

            $token = $user->createToken('auth_token', [], now()->addMinutes(60))->plainTextToken;

            Notification::send($user, new SendOtpVerifyUserEmail());

            DB::commit();

            return ApiResponseTrait::sendResponse(201, 'User Created Successfully ', ['token' => $token]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error From Registration proccess : ' . $e->getMessage());
            return ApiResponseTrait::sendResponse(500, 'Enternal server error', null);
        }
    }
    private function createUser($request)
    {
        $user = User::create([
            'name' => $request->post('name'),
            'username' => $request->post('username'),
            'email' => $request->post('email'),
            'phone' => $request->post('phone'),
            'country' => $request->post('country'),
            'city' => $request->post('city'),
            'street' => $request->post('street'),
            'password' => $request->post('password'),
        ]);
        return $user;
    }
}
