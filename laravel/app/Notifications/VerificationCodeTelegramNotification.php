<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class VerificationCodeTelegramNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $verificationCode;

    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    public function via($notifiable)
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        return "Your verification code is: " . $this->verificationCode;
    }
}
