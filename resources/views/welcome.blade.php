@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px; margin: 80px auto;">
    <div class="card shadow">
        <div class="card-header text-center bg-primary text-white">
            <h2>Welcome to MOTIVUS Car Rental</h2>
        </div>
        <div class="card-body text-center">
            <p class="lead">Easily rent a car with us. Sign in or create an account to get started!</p>
            <div class="d-flex justify-content-center gap-3 mt-4">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Create Account</a>
            </div>
            <hr>
            <div class="mt-3">
                <a href="{{ url('/auth/redirect/google') }}" class="btn btn-danger btn-lg w-100">
                    <i class="bi bi-google"></i> Continue with Google
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
