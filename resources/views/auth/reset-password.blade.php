@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <div class="auth-shell">
        <div class="auth-panel auth-small-panel">
            <div class="auth-header">
                <span class="auth-badge">NEW PASSWORD</span>
                <h1>Set a new password</h1>
                <p>Choose a strong password to secure your account.</p>
            </div>

            @if ($errors->any())
                <div class="auth-error" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="auth-form" data-auth-form>
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="auth-field">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="auth-input @error('email') auth-input-error @enderror" autocomplete="email" required>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password">New password</label>
                    <div class="password-control">
                        <input id="password" name="password" type="password" class="auth-input @error('password') auth-input-error @enderror" autocomplete="new-password" required>
                        <button type="button" class="password-toggle" data-password-toggle aria-controls="password" aria-label="Show password" aria-pressed="false">Show</button>
                    </div>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password_confirmation">Confirm new password</label>
                    <div class="password-control">
                        <input id="password_confirmation" name="password_confirmation" type="password" class="auth-input @error('password') auth-input-error @enderror" autocomplete="new-password" required>
                        <button type="button" class="password-toggle" data-password-toggle aria-controls="password_confirmation" aria-label="Show password" aria-pressed="false">Show</button>
                    </div>
                </div>

                <button type="submit" class="auth-button" data-loading-text="Resetting password...">Reset password</button>
            </form>
        </div>
    </div>
@endsection
