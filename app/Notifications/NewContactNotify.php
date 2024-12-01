<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactNotify extends Notification implements ShouldQueue
{
    use Queueable;

    public $contact;

    /**
     * Create a new notification instance.
     *
     * @param object $contact
     */
    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param object $notifiable
     * @return array<string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param object $notifiable
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'contact_title' => $this->contact->title,
            'user_name' => $this->contact->name,
            'date' => now()->toIso8601String(),
            'link' => route('dashboard.contacts.show', $this->contact->id),
        ];
    }
}
