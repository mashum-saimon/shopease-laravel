<?php

namespace App\Services;

use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    public function send(string $email): string
    {
        $code = (string) random_int(100000, 999999);

        OtpVerification::where('email', $email)->delete();
        OtpVerification::create([
            'email' => $email,
            'code' => $code,
            'expires_at' => now()->addMinutes(config('shop.otp_ttl')),
        ]);

        Mail::raw("Your login code is {$code}. It expires in ".config('shop.otp_ttl').' minutes.', function ($message) use ($email) {
            $message->to($email)->subject('Your login OTP');
        });

        return $code;
    }

    /**
     * Verify the code and return the user (created on first login), or null if invalid.
     */
    public function verify(string $email, string $code): ?User
    {
        $otp = OtpVerification::where('email', $email)
            ->where('code', $code)
            ->where('expires_at', '>', now())
            ->first();

        if (! $otp) {
            return null;
        }

        $otp->delete();

        return User::firstOrCreate(['email' => $email], ['name' => strstr($email, '@', true)]);
    }
}
