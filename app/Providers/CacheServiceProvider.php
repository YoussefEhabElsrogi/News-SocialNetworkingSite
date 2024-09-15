<?php

namespace App\Providers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
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
        $read_more_posts = Cache::remember('read_more_posts', 3600, function () {
            return Post::select('id', 'title')->latest()->take(10)->get();
        });

        $read_more_posts = Cache::get('read_more_posts');

        view()->share('read_more_posts',  $read_more_posts);
    }
}
