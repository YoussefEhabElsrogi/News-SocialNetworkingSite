<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch the latest 9 posts with their images
        $posts = Post::active()->with('images')->latest()->paginate(9);

        // Fetch the top 3 posts with the highest number of views
        $greatestPostsViews = Post::active()->orderBy('number_of_views', 'desc')->take(3)->get();

        // Fetch the 3 oldest posts
        $oldestPosts = Post::active()->oldest()->take(3)->get();

        // Fetch the top 3 popular posts based on comments count
        $popularPosts = Post::active()->withCount('comments')->orderBy('comments_count', 'desc')->take(3)->get();

        // Fetch all categories and map over them to get first 2 posts for each category
        $categories = Category::all(); // Get all categories
        $categories_with_posts = $categories->map(function (Category $category) {
            // For each category, get its first 2 posts
            $category->posts = $category->posts()->take(2)->get();
            return $category; // Return the category with modified posts
        });

        // Return the view with the data variables
        return view('frontend.index', get_defined_vars());
    }
}
