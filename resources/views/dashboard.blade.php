@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="auth-shell">
        <div class="auth-panel dashboard-panel">
            <div class="auth-header">
                <span class="auth-badge">ACCOUNT</span>
                <h1>Welcome, {{ Auth::user()->name }}</h1>
                <p>Your dashboard is ready and your session is secured.</p>
            </div>

            @if (session('status'))
                <div class="auth-status" role="status">
                    {{ session('status') }}
                </div>
            @endif

            <div class="dashboard-metrics">
                <div class="metric-card">
                    <span class="metric-label">Member since</span>
                    <strong>{{ Auth::user()->created_at->format('F j, Y') }}</strong>
                </div>
                <div class="metric-card">
                    <span class="metric-label">Email</span>
                    <strong>{{ Auth::user()->email }}</strong>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="auth-form">
                @csrf
                <button type="submit" class="auth-button auth-button-secondary">Log out</button>
            </form>
        </div>
    </div>
@endsection
