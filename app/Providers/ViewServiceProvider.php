<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\RelatedNewsSite;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share related sites
        $related_sites = RelatedNewsSite::select(['name', 'url'])->get();

        // Share categories
        $categories = Category::select('id', 'name', 'slug')->get();

        view()->share(
            [
                'related_sites' => $related_sites,
                'categories' => $categories,
            ]
        );
    }
}
