<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use ApiResponseTrait;
    public function getNotifications()
    {
        $user = Auth::guard('sanctum')->user();

        $ntofications = $user->notifications;
        $unreadNotifications = $user->unreadNotifications;

        return  ApiResponseTrait::sendResponse(200, 'User Notifications', [
            'notifications' => NotificationResource::collection($ntofications),
            'unreadNotifications' => NotificationResource::collection($unreadNotifications),
        ]);
    }
    public function readNotifications($id)
    {
        $notification = Auth::guard('sanctum')->user()->unreadNotifications()->where('id',  $id)->first();

        if (!$notification) {
            return ApiResponseTrait::sendResponse(404, 'Notification not found', null);
        }
        $notification->markAsRead();
        return ApiResponseTrait::sendResponse(200, 'Notification read', null);
    }
}
