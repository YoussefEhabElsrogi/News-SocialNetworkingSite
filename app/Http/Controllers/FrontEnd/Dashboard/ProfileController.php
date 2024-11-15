<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Image;
use App\Models\Post;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * @desc Return the profile dashboard
     * @method GET
     * @router /user/profile
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $posts = auth()->user()->posts()->active()->latest()->get();

        return view('layouts.frontend.dashboard.profile', compact('posts'));
    }
    /**
     * @desc Store a new post in the database
     * @method POST
     * @router /user/post/store
     * @return \Illuminate\Http\RedirectResponse Redirect response after storing the post,
     */
    public function storePost(StorePostRequest $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validated();
        try {
            DB::beginTransaction();

            // Convert 'on'/'off' checkbox values to boolean
            $validatedData['comment_able'] = $this->commentAble($validatedData);

            // Add the authenticated user's ID to the data
            $validatedData['user_id'] = auth()->user()->id;

            // Create Post, excluding the '_token' and 'images' fields
            $post = Post::create(collect($validatedData)->except(['_token', 'images'])->toArray());

            // Handle image uploads
            ImageManager::uploadImages($request, $post);

            DB::commit();
            Cache::forget('read_more_posts');
            Cache::forget('latestPosts');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('errors', 'Problem creating post');
        }

        setFlashMessage('success', 'Post created successfully');
        return redirect()->back();
    }
    /**
     * @desc Edit post with slug
     * @method GET
     * @router /user/post/edit/{slug}
     * @return
     */
    public function editPost(string $slug)
    {
        return $slug;
    }
    /**
     * @desc Delete post with slug
     * @method DELETE
     * @router /user/post/delete/{slug}
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePost(Request $request)
    {
        $post = Post::whereSlug($request->slug)->first();

        if (!$post) {
            setFlashMessage('error', 'Post Not Found');
            return redirect()->back();
        }

        if (auth()->id() !== $post->user_id) {
            setFlashMessage('error', 'Unauthorized action');
            return redirect()->back();
        }

        ImageManager::deleteImages($post);

        $post->delete();
        setFlashMessage('success', 'Post deleted successfully');
        return redirect()->back();
    }
    /**
     * @desc Get all comments for a post
     * @method GET
     * @router /user/post/get-comments/{slug}
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComments(string $slug)
    {
        $post = Post::whereSlug($slug)->first();

        if (!$post) {
            return response()->json(['error' => 'Post Not Found'], 404);
        }

        $comments = $post->comments()
            ->select(['id', 'comment', 'post_id', 'user_id', 'status'])
            ->with('user:id,name,image')
            ->orderBy('id', 'desc')
            ->get();

        if ($comments->isEmpty()) {
            return response()->json([
                'data' => null,
                'message' => 'No Comments From This Post',
            ]);
        }

        return response()->json([
            'data' => $comments,
            'message' => 'Contents Retrieved Successfully',
        ]);
    }
    public function showEditForm(string $slug)
    {
        $post = Post::with('images')->whereSlug($slug)->first();
        if (!$post) {
            setFlashMessage('error', 'Post Not Found');
            return redirect()->back();
        }

        return view('layouts.frontend.dashboard.edit-post', compact('post'));
    }
    public function updatePost(UpdatePostRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $validatedData['post_id'] = $request->post_id;

            $post = Post::findOrFail($validatedData['post_id']);

            $validatedData['comment_able'] = $this->commentAble($validatedData);

            $post->update(collect($validatedData)->except(['_token', 'post_id', 'images'])->toArray());

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
        return to_route('front.dashboard.profile');
    }
    private function commentAble(array $validatedData)
    {
        // Convert 'on'/'off' checkbox values to boolean
        return  isset($validatedData['comment_able']) && $validatedData['comment_able'] === 'on' ? true : false;
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
        ImageManager::deleteImagesInLocal($image->path);

        $image->delete();

        return response()->json([
            'message' => 'Image Deleted Successfully',
            'status' => 200
        ]);
    }
}
