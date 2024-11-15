<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Comment;
use App\Models\Post;

class NewCommentNotify extends Notification
{
    public $comment, $post;

    public function __construct(Comment $comment, Post $post)
    {
        $this->comment = $comment;
        $this->post = $post;
    }

    public function via(object $notifiable): array
    {
        return ['broadcast', 'database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'userMakeCommentId' => $this->comment->user_id,
            'userMakeCommentName' => $this->comment->user->name,
            'post_title' => $this->post->title,
            'comment' => $this->comment->comment,
            'link' => route('front.post.show', $this->post->slug),
        ];
    }
    public function toBroadcast(object $notifiable)
    {
        return [
            'userMakeCommentId' => $this->comment->user_id,
            'userMakeCommentName' => $this->comment->user->name,
            'post_title' => $this->post->title,
            'comment' => $this->comment->comment,
            'link' => route('front.post.show', $this->post->slug),
        ];
    }
}
