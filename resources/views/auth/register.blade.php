<x-layouts.guest>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">Name</label>
            <input class="form-input" id="name" name="name" type="text" value="{{ old('name') }}" required autofocus placeholder="Your name">
            @error('name') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input class="form-input" id="email" name="email" type="email" value="{{ old('email') }}" required placeholder="you@example.com">
            @error('email') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input class="form-input" id="password" name="password" type="password" required placeholder="Min 8 characters">
            @error('password') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <input class="form-input" id="password_confirmation" name="password_confirmation" type="password" required placeholder="Confirm password">
        </div>

        <button type="submit" class="btn-primary">Create Account</button>

        <div class="form-footer">
            Already have an account? <a href="{{ route('login') }}">Log in</a>
        </div>
    </form>
</x-layouts.guest>
