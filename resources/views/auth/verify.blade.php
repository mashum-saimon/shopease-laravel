@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-3">Enter your code</h4>
                    <form method="POST" action="{{ route('login.verify.submit') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('email', old('email')) }}">
                        <p class="text-muted small">Code sent to <strong>{{ session('email', old('email')) }}</strong></p>
                        <div class="mb-3">
                            <label class="form-label">6-digit OTP</label>
                            <input type="text" name="code" inputmode="numeric" maxlength="6" class="form-control @error('code') is-invalid @enderror" required autofocus>
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button class="btn btn-primary w-100">Verify &amp; Login</button>
                    </form>
                    <a href="{{ route('login') }}" class="d-block text-center mt-3 small">Use a different email</a>
                </div>
            </div>
        </div>
    </div>
@endsection
