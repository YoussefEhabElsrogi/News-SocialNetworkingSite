<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Ichtrojan\Otp\Otp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtpResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public $otp;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->otp = new Otp();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param object $notifiable
     * @return array<string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param object $notifiable
     * @return MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        $otpCode = $this->generateOtp($notifiable->email);

        return (new MailMessage)
            ->subject('Password Reset OTP')
            ->greeting('Hello!')
            ->line('You requested to reset your password.')
            ->line('Please use the following code to reset your password:')
            ->line('**' . $otpCode . '**')
            ->line('This code will expire in 10 minutes.')
            ->line('If you did not request this reset, please ignore this email.')
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
