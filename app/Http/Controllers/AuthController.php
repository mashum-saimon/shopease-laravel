<?php

namespace App\Http\Controllers;

use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private OtpService $otp)
    {
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function sendOtp(Request $request): RedirectResponse
    {
        $data = $request->validate(['email' => ['required', 'email']]);

        $code = $this->otp->send($data['email']);

        $redirect = redirect()->route('login.verify')->with('email', $data['email'])
            ->with('status', 'We sent a 6-digit code to your email.');

        return config('shop.show_demo_otp') ? $redirect->with('demo_otp', $code) : $redirect;
    }

    public function showVerify(Request $request)
    {
        if (! session('email') && ! old('email')) {
            return redirect()->route('login');
        }

        return view('auth.verify');
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:6'],
        ]);

        $user = $this->otp->verify($data['email'], $data['code']);

        if (! $user) {
            return back()->withInput($request->only('email'))->withErrors(['code' => 'Invalid or expired code.']);
        }

        auth()->login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('home'))->with('success', 'Welcome back!');
    }

    public function profile()
    {
        return view('auth.profile', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $request->user()->update($data);

        return back()->with('success', 'Profile updated.');
    }

    public function logout(Request $request): RedirectResponse
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
