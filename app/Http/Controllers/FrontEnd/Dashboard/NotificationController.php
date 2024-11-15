<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $user = Auth::user();
        return view('layouts.frontend.dashboard.notification', compact('user'));
    }
    public function delete(Request $request)
    {
        $notification = auth()->user()->notifications()->where('id', $request->notification_id)->first();

        if (!$notification) {
            setFlashMessage('error', 'Notification Not Found');
        }

        $notification->delete();

        setFlashMessage('success', 'Notification deleted successfully');

        return redirect()->back();
    }
    public function deleteAll(Request $request)
    {
        auth()->user()->notifications()->delete();

        setFlashMessage('success', 'All Notifications deleted successfully');

        return redirect()->back();
    }
    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();

        setFlashMessage('success', 'All Notifications marked as read successfully');

        return redirect()->back();
    }
}
