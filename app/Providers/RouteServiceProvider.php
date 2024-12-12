<?php

namespace App\Providers;

use App\Traits\ApiResponseTrait;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    use ApiResponseTrait;

    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';
    public const ADMIN_HOME = 'dashboard/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->group(base_path('routes/dashboard.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        $this->createRateLimiter('api', 3, 'perMinute');
        $this->createRateLimiter('contacts', 1, 'perHour');
        $this->createRateLimiter('login', 2, 'perMinute');
        $this->createRateLimiter('register', 2, 'perMinute');
        $this->createRateLimiter('comments', 1, 'perMinute');
        $this->createRateLimiter('user', 2, 'perMinute');
    }

    /**
     * Create a rate limiter.
     *
     * @param string $name
     * @param int $limit
     * @param string $method
     */
    protected function createRateLimiter(string $name, int $limit, string $method): void
    {
        RateLimiter::for($name, function (Request $request) use ($limit, $method) {
            return Limit::$method($limit)
                ->by($request->ip())
                ->response(function () {
                    return ApiResponseTrait::sendResponse(429, 'Try Again Later', null);
                });
        });
    }
}
