<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\PostCollection;
use App\Models\Post;
use App\Notifications\NewCommentNotify;
use App\Traits\ApiResponseTrait;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    use ApiResponseTrait;
    public function getUserPosts(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return ApiResponseTrait::sendResponse(401, 'User not authenticated', null);
        }

        $posts =  $user->posts()->active()->activeCategory()->get();

        if ($posts->isEmpty()) {
            return ApiResponseTrait::sendResponse(200, 'No Posts', null);
        }

        $postCollection = new PostCollection($posts);

        return ApiResponseTrait::sendResponse(200, 'User Posts', $postCollection);
    }
    public function storeUserPost(StorePostRequest $request)
    {
        try {
            DB::beginTransaction();

            $post = auth()->user()->posts()->create($request->except(['images']));
            ImageManager::uploadImages($request, $post);

            DB::commit();

            Cache::forget('read_more_posts');
            Cache::forget('latestPosts');

            return ApiResponseTrait::sendResponse(201, 'Post Created Successfully', null);
        } catch (\Exception $e) {
            Log::error('Error Store User Post : ' . $e->getMessage());
            return ApiResponseTrait::sendResponse(400, 'Bad Request', null);
        }
    }
    public function  destroyUserPost($id)
    {
        $user = auth()->user();
        $post = $user->posts()->where('id', $id)->first();

        if (!$post) {
            return ApiResponseTrait::sendResponse(404, 'Post Not Found', null);
        }

        if ($post->user_id !== $user->id) {
            return ApiResponseTrait::sendResponse(403, 'Unauthorized', null);
        }

        ImageManager::deleteImages($post);
        $post->delete();

        Cache::forget('read_more_posts');
        Cache::forget('latestPosts');

        return ApiResponseTrait::sendResponse(200, 'Post Deleted Successfully!', null);
    }
    public function getPostComments($id)
    {
        $user = auth()->user();

        // Check if the user is authenticated
        if (!$user) {
            return ApiResponseTrait::sendResponse(401, 'User not authenticated', null);
        }

        $post = $user->posts()->where('id', $id)->active()->with('comments')->first();

        if (!$post) {
            return ApiResponseTrait::sendResponse(404, 'Post not found', null);
        }

        $comments = $post->comments;

        if ($comments->isEmpty()) {
            return ApiResponseTrait::sendResponse(404, 'No comments found for this post', null);
        }

        $commentsCollection = new CommentCollection($comments);

        return ApiResponseTrait::sendResponse(200, 'Comments retrieved successfully', $commentsCollection);
    }
    public function updateUserPost(UpdatePostRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();
            $post = $user->posts()->where('id', $id)->first();

            if (!$post) {
                return ApiResponseTrait::sendResponse(404, 'Post Not Found', null);
            }

            $post->update($request->except(['images', '_method']));

            if ($request->hasFile('images')) {
                ImageManager::deleteImages($post);
                ImageManager::uploadImages($request, $post);
            }
            DB::commit();
            return ApiResponseTrait::sendResponse(200, 'Post Updated Successfully');
        } catch (\Exception $e) {
            Log::error('Error Update User Post', [$e->getMessage()]);
            return ApiResponseTrait::sendResponse(400, 'Try again latter!');
        }
    }
    public function StoreComment(CommentRequest $request)
    {
        $post = Post::find($request->post_id);

        if (!$post) {
            return ApiResponseTrait::sendResponse(404, 'Post Not Found', null);
        }

        $comment = $post->comments()->create([
            'user_id' => auth()->user()->id,
            'comment' => $request->comment,
            'ip_address' => $request->ip(),
        ]);

        if (auth()->user()->id != $post->user_id) {
            Notification::send($post->user, new NewCommentNotify($comment, $post));
        }

        if (!$comment) {
            return ApiResponseTrait::sendResponse(400, 'Try Again Latter!', null);
        }
        return ApiResponseTrait::sendResponse(201, 'Comment Created Successfully!', null);
    }
}
