<x-layouts.guest>
    @if (session('status'))
        <div class="alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input class="form-input" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
            @error('email') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input class="form-input" id="password" name="password" type="password" required placeholder="Password">
            @error('password') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn-primary">Log In</button>

        <div class="form-footer">
            <a href="{{ route('password.request') }}">Forgot password?</a>
            &middot;
            <a href="{{ route('register') }}">Create an account</a>
        </div>
    </form>
</x-layouts.guest>
