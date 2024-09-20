<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     * @param  string  $slug
     */
    public function __invoke($slug)
    {
        // Retrieve the category based on the slug
        $category = Category::active()->where('slug', $slug)->first();

        // Check if the category was found
        if (!$category) {
            // Set a flash message if the category is not found
            setFlashMessage('error', 'Category Not Found');

            return redirect()->back();
        }

        // Retrieve the posts related to the category
        $posts = $category->posts()->paginate(9);

        return view('frontend.category-posts', get_defined_vars());
    }
}
