<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class NewCommentNotify extends Notification
{
    use Queueable;

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
            'userMakeCommentName' => auth()->user()->name,
            'post_title' => $this->post->title,
            'comment' => $this->comment->comment,
            'link' => route('front.post.show', $this->post->slug),
        ];
    }
    public function toBroadcast(object $notifiable)
    {
        return [
            'userMakeCommentId' => $this->comment->user_id,
            'userMakeCommentName' => auth()->user()->name,
            'post_title' => $this->post->title,
            'comment' => $this->comment->comment,
            'link' => route('front.post.show', $this->post->slug),
        ];
    }
}
