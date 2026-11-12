@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="auth-shell">
        <div class="auth-panel">
            <div class="auth-header">
                <span class="auth-badge">ABOUT SPORTSMAN</span>
                <h1>Welcome back</h1>
                <p>Sign in to continue your athlete profile journey.</p>
            </div>

            @if (session('status'))
                <div class="auth-status" role="status">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="auth-error" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="auth-form" data-auth-form>
                @csrf

                <div class="auth-field">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="auth-input @error('email') auth-input-error @enderror" autocomplete="email" required autofocus>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password">Password</label>
                    <div class="password-control">
                        <input id="password" name="password" type="password" class="auth-input @error('password') auth-input-error @enderror" autocomplete="current-password" required>
                        <button type="button" class="password-toggle" data-password-toggle aria-controls="password" aria-label="Show password" aria-pressed="false">Show</button>
                    </div>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-row">
                    <label class="remember-box" for="remember">
                        <input id="remember" type="checkbox" name="remember" value="1">
                        <span>Remember me</span>
                    </label>

                    <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
                </div>

                <button type="submit" class="auth-button" data-loading-text="Signing in...">Sign in</button>
            </form>

            <p class="auth-footer">
                Need an account?
                <a href="{{ route('register') }}" class="auth-link">Create one</a>
            </p>
        </div>
    </div>
@endsection
