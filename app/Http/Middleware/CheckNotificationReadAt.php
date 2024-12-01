<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNotificationReadAt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if there's a 'notify' or 'notify_admin' query parameter and process accordingly
        if ($request->query('notify')) {
            $this->markNotificationAsRead($request->query('notify'), auth()->user());
        } elseif ($request->query('notify_admin')) {
            $this->markNotificationAsRead($request->query('notify_admin'), auth()->guard('admin')->user());
        }

        return $next($request);
    }

    /**
     * Mark the notification as read if it exists.
     *
     * @param  string  $notificationId
     * @param  \Illuminate\Notifications\Notifiable  $user
     * @return void
     */
    private function markNotificationAsRead(string $notificationId, $user): void
    {
        $notification = $user->unreadNotifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
        }
    }
}
