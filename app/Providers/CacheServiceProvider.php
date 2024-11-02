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
        // Cache "read more" posts
        $read_more_posts = Cache::remember('read_more_posts', 3600, function () {
            return Post::select('id', 'title', 'slug')->latest()->take(10)->get();
        });

        // Cache "latest" posts
        $latestPosts = Cache::remember('latestPosts', 3600, function () {
            return Post::select('id', 'title', 'slug')->latest()->take(5)->get();
        });

        // Cache "popular" posts
        $popularPosts = Cache::remember('popularPosts', 3600, function () {
            return Post::withCount('comments')->orderBy('comments_count', 'desc')->take(5)->get();
        });

        // Share the cached data to all views 
        view()->share([
            'read_more_posts' => $read_more_posts,
            'latestPosts' => $latestPosts,
            'popularPosts' => $popularPosts,
        ]);
    }
}
