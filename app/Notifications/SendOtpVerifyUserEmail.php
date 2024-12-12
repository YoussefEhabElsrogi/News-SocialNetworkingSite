<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Ichtrojan\Otp\Otp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtpVerifyUserEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public $otp;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->otp = new Otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        // Generate OTP
        $otp = $this->generateOtp($notifiable->email);

        // Create the email message
        return (new MailMessage)
            ->subject('Your OTP Verification Code')
            ->greeting('Hello!')
            ->line('Please use the following code to verify your email:')
            ->line('**' . $otp . '**')
            ->line('This code will expire in 10 minutes.')
            ->line('If you did not request this code, please ignore this email.')
            ->salutation('Regards, Your Application Team');
    }

    /**
     * Generate the OTP using the OTP service.
     *
     * @param string $email
     * @return string
     */
    protected function generateOtp(string $email): string
    {
        $otpData = $this->otp->generate($email, 'numeric', 6, 10);
        return $otpData->token;
    }
}
