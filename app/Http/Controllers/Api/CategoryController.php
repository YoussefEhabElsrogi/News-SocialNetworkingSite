<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\PostCollection;
use App\Models\Category;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    public function getCategories()
    {
        $categories = Category::active()->get();

        if (!$categories) {
            return ApiResponseTrait::sendResponse(404, 'Categories Not Found', null);
        }

        $categoryResourse = new CategoryCollection($categories);

        return ApiResponseTrait::sendResponse(200, 'Categories', $categoryResourse);
    }
    public function getCategoryPosts($slug)
    {
        $category = Category::with('posts')->active()->whereSlug($slug)->first();

        if (!$category) {
            return ApiResponseTrait::sendResponse(404, 'Category Not Found', null);
        }

        $postResourse = new PostCollection($category->posts);

        return ApiResponseTrait::sendResponse(200, 'Posts', $postResourse);
    }
}
