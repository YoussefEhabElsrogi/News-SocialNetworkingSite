<?php

namespace App\Livewire\Dashboard;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;

class LatestPostsComments extends Component
{
    public function render()
    {
        $latest_posts = Post::active()->with('user')->withCount('comments')->latest()->take(6)->get();
        $latest_comments = Comment::with(['user', 'post'])->latest()->take(6)->get();

        return view('livewire.dashboard.latest-posts-comments', [
            'latest_posts' => $latest_posts,
            'latest_comments' => $latest_comments,
        ]);
    }
}
