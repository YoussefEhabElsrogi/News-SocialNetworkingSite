<?php

namespace App\Http\Controllers\Dashboard\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:notifications');
    }
    public function index()
    {
        Auth::guard('admin')->user()->unreadNotifications->markAsRead();
        $notifications = Auth::guard('admin')->user()->notifications()->get();
        return view('dashboard.notifications.index', compact('notifications'));
    }
    public function destroy($id)
    {
        $notification = Auth::guard('admin')->user()->notifications()->find($id);

        if (!$notification) {
            setFlashMessage('error', 'Notification Not Found');
            return redirect()->back();
        }

        $notification->delete();

        setFlashMessage('success', 'Notification deleted successfully');
        return redirect()->back();
    }
    public function deleteAll()
    {
        Auth::guard('admin')->user()->notifications()->delete();
        setFlashMessage('success', 'All Notifications deleted successfully');
        return redirect()->back();
    }
}
