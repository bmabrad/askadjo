<x-layouts.guest>
    @if (session('status'))
        <div class="alert-success">{{ session('status') }}</div>
    @endif

    <p style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 1.25rem;">
        Enter your email and we'll send you a link to reset your password.
    </p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input class="form-input" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
            @error('email') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn-primary">Send Reset Link</button>

        <div class="form-footer">
            <a href="{{ route('login') }}">Back to login</a>
        </div>
    </form>
</x-layouts.guest>
