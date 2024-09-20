<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

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
            setFlashMessage('error', 'Post Not Found');
            return redirect()->back();
        }

        $category = $singlePost->category;
        $postId  = $singlePost->id;
        $postsRelated = $category->posts()->where('id', '!=', $postId)->select('id', 'title', 'slug')->latest()->take(5)->get();

        return view('frontend.show-posts', compact('singlePost', 'postsRelated'));
    }
    public function getAllComments($slug)
    {
        $post = Post::with('comments')->whereSlug($slug)->first();

        // Check if the post was found
        if (!$post) {
            // Set a flash message if the post is not found
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

        $data['ip_address'] = $request->ip();

        $comment = Comment::create($data);

        $comment->load('user');
        $comment->makeHidden(['created_at', 'updated_at']);
        $comment->user->makeHidden(['country', 'city', 'street', 'phone', 'email_verified_at', 'created_at', 'updated_at']);

        if (!$comment) {
            return response()->json(['data' => 'Operation Failed', 'status' => 403]);
        }

        return response()->json([
            'message' => 'Comment created successfully',
            'comment' => $comment,
            'status' => 201
        ]);
    }
}
