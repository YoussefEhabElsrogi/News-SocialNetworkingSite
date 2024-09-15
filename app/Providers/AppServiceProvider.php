<?php

namespace App\Providers;

use App\Models\RelatedNewsSite;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        // Share related sites

        $related_sites = RelatedNewsSite::select(['name', 'url'])->get();

        view()->share('related_sites', $related_sites);
    }
}
