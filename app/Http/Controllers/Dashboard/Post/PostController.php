<?php

namespace App\Http\Controllers\Dashboard\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StorePostRequest, UpdatePostRequest};
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:posts');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $order_by = $request->order_by ?? 'desc';
        $sort_by = $request->sort_by ?? 'id';
        $limit_by = $request->limit_by ?? 5;

        $posts = Post::with([
            'category' => function ($query) {
                $query->withDefault(['name' => 'Uncategorized']);
            },
            'user',
            'admin'
        ])
            ->when($request->keyword, function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->keyword . '%');
            })
            ->when(!is_null($request->status), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy($sort_by, $order_by)
            ->paginate($limit_by);

        return view('dashboard.posts.index', compact('posts'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            // Add the authenticated user's ID to the data
            $validatedData['admin_id'] = auth()->guard('admin')->user()->id;

            // Create Post, excluding the '_token' and 'images' fields
            $post = Post::create(collect($validatedData)->except(['_token', 'images'])->toArray());

            // Handle image uploads
            ImageManager::uploadImages($request, $post);

            DB::commit();
            Cache::forget('read_more_posts');
            Cache::forget('latestPosts');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('errors', 'Post Created Faild');
        }

        setFlashMessage('success', 'Post created successfully');
        return redirect()->route('dashboard.posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with(['comments.user'])->findOrFail($id);
        return view('dashboard.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $adminAuthId = auth()->guard('admin')->user()->id;

        if (!$this->isOwnedByAdmin($adminAuthId, $post->admin_id)) {
            abort(403, 'You are not authorized to edit this post.');
        }

        return view('dashboard.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $adminAuthId = auth()->guard('admin')->user()->id;

        try {

            $post = Post::findOrFail($id);

            if (!$this->isOwnedByAdmin($adminAuthId, $post->admin_id)) {
                abort(403, 'You are not authorized to edit this post.');
            }

            $post->update(collect($validatedData)->except(['_token', 'images'])->toArray());

            if ($request->hasFile('images')) {
                // Delete old image from local
                ImageManager::deleteImages($post);
                // Store new image from loacal
                ImageManager::uploadImages($request, $post);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            setFlashMessage('error', $exception->getMessage());

            return redirect()->back()->withInput();
        }

        setFlashMessage('success', 'Post Updated Successfully');
        return redirect()->route('dashboard.posts.index');
    }

    public function deletePostImage(Request $request)
    {
        $image = Image::find($request->key);

        if (!$image) {
            return response()->json([
                'message' => 'Image Not Found',
                'status' => 404
            ]);
        }

        // Delete image from local
        ImageManager::deleteImageInLocal($image->path);

        $image->delete();

        return response()->json([
            'message' => 'Image Deleted Successfully',
            'status' => 200
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        ImageManager::deleteImages($post);
        $post->delete();

        setFlashMessage('success', 'Post Deleted Suuccessfully!');
        return redirect()->route('dashboard.posts.index');
    }

    public function changeStatus($id)
    {
        $post = Post::findOrFail($id);
        if ($post->status == 1) {
            $post->update([
                'status' => 0,
            ]);
            setFlashMessage('success', 'Post Blocked Suuccessfully!');
        } else {
            $post->update([
                'status' => 1,
            ]);
            setFlashMessage('success', 'Post Active Suuccessfully!');
        }
        return redirect()->back();
    }

    public function deleteComment($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([
                'status' => false,
                'message' => 'Comment not found.',
            ], 404);
        }

        $comment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Comment deleted successfully.',
        ], 200);
    }

    public function getAllComments($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found.',
            ], 404);
        }

        $comments = $post->comments()->with('user')->get();

        return response()->json([
            'status' => true,
            'comments' => $comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'created_at' => $comment->created_at,
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                        'image' => $comment->user->image,
                    ],
                ];
            }),
        ], 200);
    }
    // In Post.php Model
    private function isOwnedByAdmin($authAdminId, $adminId)
    {
        return $authAdminId === $adminId;
    }
}
