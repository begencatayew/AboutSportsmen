@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="auth-shell">
        <div class="auth-panel">
            <div class="auth-header">
                <span class="auth-badge">ABOUT SPORTSMAN</span>
                <h1>Create your account</h1>
                <p>Join the community and build your athlete profile.</p>
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

            <form method="POST" action="{{ route('register') }}" class="auth-form" data-auth-form>
                @csrf

                <div class="auth-field">
                    <label for="name">Full name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" class="auth-input @error('name') auth-input-error @enderror" autocomplete="name" required autofocus>
                    @error('name')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="auth-input @error('email') auth-input-error @enderror" autocomplete="email" required>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password">Password</label>
                    <div class="password-control">
                        <input id="password" name="password" type="password" class="auth-input @error('password') auth-input-error @enderror" autocomplete="new-password" required>
                        <button type="button" class="password-toggle" data-password-toggle aria-controls="password" aria-label="Show password" aria-pressed="false">Show</button>
                    </div>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password_confirmation">Confirm password</label>
                    <div class="password-control">
                        <input id="password_confirmation" name="password_confirmation" type="password" class="auth-input @error('password') auth-input-error @enderror" autocomplete="new-password" required>
                        <button type="button" class="password-toggle" data-password-toggle aria-controls="password_confirmation" aria-label="Show password" aria-pressed="false">Show</button>
                    </div>
                </div>

                <button type="submit" class="auth-button" data-loading-text="Creating account...">Create account</button>
            </form>

            <p class="auth-footer">
                Already have an account?
                <a href="{{ route('login') }}" class="auth-link">Log in</a>
            </p>
        </div>
    </div>
@endsection
