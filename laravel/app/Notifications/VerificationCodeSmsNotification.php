<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VerificationCodeSmsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $verificationCode;

    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    public function routeNotificationForSms()
    {
        return $this->mobile;
    }

    public function toSms(mixed $notifiable)
    {
        $apiKey = config('custom.api_key');
        Http::get('https://api.kavenegar.com/v1/' . $apiKey . '/verify/lookup.json', [
            'receptor' => $notifiable->routeNotificationFor('sms'),
//            'token' => $notifiable->otp_code,
//            'template' => $this->verificationCode->sms_verify_template
        ]);
        return true;
    }


//    public function toSms(mixed $notifiable)
//    {
////        $receptor = $notifiable->routeNotificationFor('sms');
//        if (config('app.env') == 'production') {
//        $apiKey = config('custom.api_key');
//        Http::get('https://api.kavenegar.com/v1/' . $apiKey . '/verify/lookup.json', [
//            'receptor' => $notifiable->mobile,
//            'token' => $notifiable->otp_code,
//            'template' => $this->verificationCode->sms_verify_template
//        ]);
//        }
//        return true;
//    }

//require '/vendor/autoload.php';
//$sender = "1000689696";
//$receptor = "09905749548";
//$message = ".وب سرویس پیام کوتاه کاوه نگار";
//$api = new \Kavenegar \KavenegarApi("594B2F7278447561656432382F577137496A5650757079495653714C6F755639453545557872434F3979773D");
//$api -> Send ( $sender,$receptor,$message);

}
