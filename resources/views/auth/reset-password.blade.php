<x-layouts.guest>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input class="form-input" id="email" name="email" type="email" value="{{ old('email', $email ?? '') }}" required placeholder="you@example.com">
            @error('email') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">New Password</label>
            <input class="form-input" id="password" name="password" type="password" required placeholder="Min 8 characters">
            @error('password') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <input class="form-input" id="password_confirmation" name="password_confirmation" type="password" required placeholder="Confirm password">
        </div>

        <button type="submit" class="btn-primary">Reset Password</button>
    </form>
</x-layouts.guest>
