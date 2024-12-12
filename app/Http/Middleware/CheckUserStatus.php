<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    use ApiResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->status == 0) {
            return redirect()->route('front.wait');
        }
        if (Auth::guard('sanctum')->check() && Auth::guard('sanctum')->user()->status == 0) {
            Auth::guard('sanctum')->user()->currentAccessToken()->delete();
            return ApiResponseTrait::sendResponse(401, 'Your account has been blocked', null);
        }
        return $next($request);
    }
}
