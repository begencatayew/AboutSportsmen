@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
    <div class="auth-shell">
        <div class="auth-panel auth-small-panel">
            <div class="auth-header">
                <span class="auth-badge">PASSWORD RESET</span>
                <h1>Forgot your password?</h1>
                <p>Enter your email and we will send a secure reset link.</p>
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

            <form method="POST" action="{{ route('password.email') }}" class="auth-form" data-auth-form>
                @csrf

                <div class="auth-field">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="auth-input @error('email') auth-input-error @enderror" autocomplete="email" required>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="auth-button" data-loading-text="Sending...">Send reset link</button>
            </form>

            <p class="auth-footer">
                <a href="{{ route('login') }}" class="auth-link">Back to login</a>
            </p>
        </div>
    </div>
@endsection
