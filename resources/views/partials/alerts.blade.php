@foreach (['success', 'error', 'status'] as $type)
    @if (session($type))
        <div class="alert alert-{{ $type === 'error' ? 'danger' : ($type === 'status' ? 'info' : 'success') }} alert-dismissible fade show">
            {{ session($type) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
@endforeach
@if (session('demo_otp'))
    <div class="alert alert-warning">Demo mode: your OTP is <strong>{{ session('demo_otp') }}</strong></div>
@endif
