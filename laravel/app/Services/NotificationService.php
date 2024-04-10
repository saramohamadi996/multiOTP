<?php

namespace App\Services;

use App\Notifications\VerificationCodeEmailNotification;
use App\Notifications\VerificationCodeSmsNotification;
use App\Notifications\VerificationCodeTelegramNotification;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    public function sendVerificationNotification(string $method, string $identity, int $verificationCode): void
    {
        Notification::route($method, $identity)
            ->notify($this->getNotificationInstance($method, $verificationCode));
    }

    private function getNotificationInstance(string $method, int $verificationCode): object
    {
        return match ($method) {
            'mail' => new VerificationCodeEmailNotification($verificationCode),
            'sms' => new VerificationCodeSmsNotification($verificationCode),
            'telegram' => new VerificationCodeTelegramNotification($verificationCode),
            default => throw new \InvalidArgumentException("Unsupported method: $method"),
        };
    }
}
