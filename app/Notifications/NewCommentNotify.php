<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotify extends Notification implements ShouldBroadcast
{
    // Remove the Queueable trait
    // use Queueable;

    public $comment, $post;

    /**
     * Create a new notification instance.
     */
    public function __construct($comment, $post)
    {
        $this->comment = $comment;
        $this->post = $post;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase(object $notifiable)
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
        return new BroadcastMessage([
            'userMakeCommentId' => $this->comment->user_id,
            'userMakeCommentName' => auth()->user()->name,
            'post_title' => $this->post->title,
            'comment' => $this->comment->comment,
            'link' => route('front.post.show', $this->post->slug),
        ]);
    }
}
