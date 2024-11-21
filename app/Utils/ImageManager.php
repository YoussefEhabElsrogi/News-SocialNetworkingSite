<?php

namespace App\Utils;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageManager
{
    public static function uploadImages(Request $request, Post $post)
    {
        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $imageName = self::generateImageName($image);
                $path = self::storeImageInLocal($image, $imageName, 'posts');
                $post->images()->create(['path' => $path]);
            }
        }
    }

    public static function uploadSingleImage(Request $request, User $user)
    {
        // Upload single image for user profile
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Delete old image if exists
            self::deleteImageInLocal($user->image);

            // Store new image and update database
            $imageName = self::generateImageName($image);
            $path = self::storeImageInLocal($image, $imageName, 'users');
            $user->update(['image' => $path]);
        }
    }

    public static function deleteImages(Post $post)
    {
        // Delete all images related to a post
        if ($post->images()->count() > 0) {
            foreach ($post->images as $image) {
                self::deleteImageInLocal($image->path);
                $image->delete(); // Delete image record from database
            }
        }
    }

    public static function generateImageName($image)
    {
        return Str::uuid() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    }

    public static function storeImageInLocal($image, string $imageName, string $folder)
    {
        // Store image in the specified folder and return the path
        return $image->storeAs("uploads/$folder", $imageName, ['disk' => 'uploads']);
    }

    public static function deleteImageInLocal($path)
    {
        // Delete image if it exists in the specified path
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
