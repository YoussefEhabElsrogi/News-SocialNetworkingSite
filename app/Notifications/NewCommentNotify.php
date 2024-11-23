<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotify extends Notification
{
    /**
     * Create a new notification instance.
     */
    public $comment, $post;
    public function __construct($comment, $post)
    {
        $this->comment = $comment;
        $this->post = $post;
    }


    public function via(object $notifiable): array
    {
        return  ['database', 'broadcast'];
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
        return [
            'userMakeCommentId' => $this->comment->user_id,
            'userMakeCommentName' => auth()->user()->name,
            'post_title' => $this->post->title,
            'comment' => $this->comment->comment,
            'link' => route('front.post.show', $this->post->slug),
        ];
    }
    public function broadcastType(): string
    {
        return 'NewCommentNotify';
    }
    public function databaseType(object $notifiable): string
    {
        return 'NewCommentNotify';
    }
}
