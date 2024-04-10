<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class VerificationService
{
    public function generateVerificationCode(): int
    {
        if (config('app.env') !== 'production') {
            return 1111;
        }
        return mt_rand(100000, 999999);
    }
    public function hasRecentVerificationCode(string $identity): bool
    {
        return Cache::has($identity);
    }
    public function cacheVerificationCode(string $identity, int $verification_code): void
    {
        $cacheData = ['otp_code' => $verification_code, 'time' => now()->timestamp];
        Cache::put($identity, $cacheData, now()->addMinutes(2));
    }
    public function canRequestAgain(string $identity): bool
    {
        $cacheData = Cache::get($identity);
        if (!$cacheData) {
            return true;
        }
        return now()->timestamp > ($cacheData['time'] + 120);
    }

    public function verifyCode(string $identity, $inputCode): bool
    {
        $cachedData = Cache::get($identity);
        if ($cachedData && $cachedData['otp_code'] == $inputCode) {
            return true;
        }
        return false;
    }

    public function clearVerificationCode(string $identity): void
    {
        Cache::forget($identity);
    }

}
