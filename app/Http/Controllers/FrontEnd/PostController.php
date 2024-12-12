<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\NewCommentNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    public function show($slug)
    {
        $singlePost = Post::active()->with([
            'comments' => function ($query) {
                $query->latest()->take(3);
            },
            'category.posts',

        ])->whereSlug($slug)->first();

        if (!$singlePost) {
            abort(404);
        }

        $singlePost->increment('number_of_views');

        $category = $singlePost->category;
        $postId  = $singlePost->id;
        $postsRelated = $category->posts()->where('id', '!=', $postId)->select('id', 'title', 'slug')->latest()->take(5)->get();

        return view('frontend.show-posts', compact('singlePost', 'postsRelated'));
    }
    public function getAllComments($slug)
    {
        $post = Post::with('comments')->whereSlug($slug)->first();


        if (!$post) {

            setFlashMessage('error', 'Post Not Found');
            return redirect()->back();
        }

        $comments = $post->comments()->with('user')->get();
        return response()->json($comments);
    }
    public function storeComment(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'comment' => 'required|string|max:200',
            'post_id' => 'required|exists:posts,id'
        ]);

        try {
            $data['ip_address'] = $request->ip();
            $comment = Comment::create($data);

            $post = Post::findOrFail($data['post_id']);

            $userMakePost = $post->user;

            if ($post->user_id !== auth()->id() && $post->user_id !== null) {
                Notification::send($userMakePost, new NewCommentNotify($comment, $post));
            }

            $comment->load('user');

            return response()->json([
                'message' => 'Comment created successfully',
                'comment' => $comment
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create comment',
                'error' => 'Try again latter',
            ], 500);
        }
    }
}
