<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    use ApiResponseTrait;

    public function getPosts()
    {
        $postQuery = Post::query()
            ->with(['user', 'category', 'admin', 'images'])
            ->ActiveUser()
            ->ActiveCategory()
            ->active();

        $posts = clone $postQuery->latest()->paginate(4);

        $latestPosts = $this->latestPosts(clone $postQuery);

        $mostReadPosts = $this->MostReadPosts(clone $postQuery);

        $oldestPosts = $this->oldestPosts(clone $postQuery);

        $popularPosts = $this->popularPosts(clone $postQuery);

        $categoryWithPosts = $this->categoryWithPosts();

        $data = [
            'allPosts' => (new PostCollection($posts))->response()->getData(true),
            'latestPosts' => new PostCollection($latestPosts),
            'mostReadPosts' => new PostCollection($mostReadPosts),
            'oldestPosts' => new PostCollection($oldestPosts),
            'popularPosts' => new PostCollection($popularPosts),
            'categoryWithPosts' => new CategoryCollection($categoryWithPosts)
        ];

        return ApiResponseTrait::sendResponse(200, 'success', $data);
    }
    public function latestPosts($postQuery)
    {
        $latestPosts = $postQuery->latest()->take(5)->get();

        if (!$latestPosts) {
            return ApiResponseTrait::sendResponse(404, 'Posts Not Found', null);
        }

        return $latestPosts;
    }
    public function oldestPosts($postQuery)
    {
        $oldestPosts = $postQuery->oldest()->take(5)->get();

        if (!$oldestPosts) {
            return ApiResponseTrait::sendResponse(404, 'Posts Not Found', null);
        }

        return $oldestPosts;
    }
    public function popularPosts($postQuery)
    {
        $popularPosts = $postQuery->withCount('comments')->orderBy('comments_count', 'desc')->take(5)->get();

        if (!$popularPosts) {
            return ApiResponseTrait::sendResponse(404, 'Posts Not Found', null);
        }

        return $popularPosts;
    }
    public function categoryWithPosts()
    {
        $categories = Category::query()->has('posts', '>=', 4)->active()->get();

        $categoryWithPosts = $categories->map(function (Category $category) {
            $category->posts = $category->posts()->active()->take(4)->get();
            return $category;
        });

        return $categoryWithPosts;
    }
    public function MostReadPosts($postQuery)
    {
        $mostReadPosts = $postQuery->orderBy('number_of_views', 'desc')->take(3)->get();

        if (!$mostReadPosts) {
            return ApiResponseTrait::sendResponse(404, 'Posts Not Found', null);
        }

        return $mostReadPosts;
    }
    public function showPost($slug)
    {
        $post = Post::with(['user', 'admin', 'category', 'images'])->active()->ActiveUser()->ActiveCategory()->where('slug', $slug)->first();

        if (!$post) {
            return ApiResponseTrait::sendResponse(404, 'Post Not Found', null);
        }

        $data = PostResource::make($post);

        return ApiResponseTrait::sendResponse(200, 'success', $data);
    }
    public function getPostComments($slug)
    {
        // Check if the post exists, the user and category are active, and the post is active
        $post = Post::active()->ActiveUser()->ActiveCategory()
            ->with(['comments.user'])
            ->whereSlug($slug)
            ->first();

        if (!$post) {
            return ApiResponseTrait::sendResponse(404, 'Post Not Found', null);
        }

        $comments = $post->comments;

        if ($comments->isEmpty()) {
            return ApiResponseTrait::sendResponse(404, 'Comments Not Found', null);
        }

        $commentsCollection = new CommentCollection($comments);

        return ApiResponseTrait::sendResponse(200, 'This Post Comments', $commentsCollection);
    }
    public function searchPosts($keyword)
    {
        $searchPosts = Post::whereAny(['title', 'desc'], 'LIKE', "%{$keyword}%")->active()->get();

        if ($searchPosts->isEmpty()) {
            return ApiResponseTrait::sendResponse(200, 'No Posts, customize your add input', null);
        }

        $postsResource = PostCollection::make($searchPosts);

        return ApiResponseTrait::sendResponse(200, 'Posts', $postsResource);
    }
}
