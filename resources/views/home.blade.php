@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<div class="row">
    <div class="col-12">
        <div class="jumbotron bg-primary text-white p-5 rounded">
            <div class="container">
                <h1 class="display-4">Welcome to Laravel App</h1>
                <p class="lead">This is a simple Laravel application with user authentication, built with clean and modern design principles.</p>
                @guest
                <hr class="my-4" style="border-color: rgba(255,255,255,0.3);">
                <p>Join our community today and get access to exclusive features.</p>
                <div class="mt-4">
                    <a class="btn btn-light btn-lg me-3" href="{{ route('register') }}" role="button">Get Started</a>
                    <a class="btn btn-outline-light btn-lg" href="{{ route('login') }}" role="button">Login</a>
                </div>
                @else
                <hr class="my-4" style="border-color: rgba(255,255,255,0.3);">
                <p>Welcome back, {{ Auth::user()->name }}!</p>
                <a class="btn btn-light btn-lg" href="{{ route('dashboard') }}" role="button">Go to Dashboard</a>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="row mt-5">
    <div class="col-12">
        <h2 class="text-center mb-4">Features</h2>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-shield-check text-primary"></i> 
                    Secure Authentication
                </h5>
                <p class="card-text">Built-in user registration and login system with proper validation and security measures.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-speedometer2 text-primary"></i>
                    User Dashboard
                </h5>
                <p class="card-text">Personalized dashboard for authenticated users with easy access to account features.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-mobile-alt text-primary"></i>
                    Responsive Design
                </h5>
                <p class="card-text">Mobile-first responsive design that works perfectly on all devices and screen sizes.</p>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
@auth
<div class="row mt-5">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-body">
                <h3 class="card-title">Quick Stats</h3>
                <div class="row">
                    <div class="col-md-4 text-center">
                        <h4 class="text-primary">{{ \App\Models\User::count() }}</h4>
                        <p>Registered Users</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <h4 class="text-success">{{ now()->format('Y') }}</h4>
                        <p>Current Year</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <h4 class="text-info">{{ now()->format('M d') }}</h4>
                        <p>Today's Date</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endauth

<!-- Call to Action -->
@guest
<div class="row mt-5">
    <div class="col-12">
        <div class="text-center p-4 bg-light rounded">
            <h3>Ready to get started?</h3>
            <p class="mb-4">Create your account today and join our growing community.</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Sign Up Now</a>
        </div>
    </div>
</div>
@endguest
@endsection