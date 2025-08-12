@extends('layouts.app')

@section('title', 'Register - Step 1')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Progress Bar -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-3">Registration Progress</h5>
                <div class="progress mb-2">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex justify-content-between small text-muted">
                    <span class="text-primary fw-bold">Step 1: Account Info</span>
                    <span>Step 2: Billing</span>
                    <span>Step 3: Tenant Setup</span>
                </div>
            </div>
        </div>

        <!-- Registration Form -->
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-person-plus me-2"></i>
                    Create Your Account
                </h4>
                <p class="mb-0 text-muted">Step 1 of 3: Personal Information</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register.step1') }}">
                    @csrf
                    
                    <!-- First Name -->
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('first_name') is-invalid @enderror" 
                               id="first_name" 
                               name="first_name" 
                               value="{{ old('first_name') }}" 
                               required 
                               placeholder="Enter your first name">
                        @error('first_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('last_name') is-invalid @enderror" 
                               id="last_name" 
                               name="last_name" 
                               value="{{ old('last_name') }}" 
                               required 
                               placeholder="Enter your last name">
                        @error('last_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               placeholder="Enter your email address">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required 
                               placeholder="Create a strong password">
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="form-text">Password must be at least 8 characters long.</div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" 
                               class="form-control @error('password_confirmation') is-invalid @enderror" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required 
                               placeholder="Confirm your password">
                        @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="{{ route('privacy.policy') }}" target="_blank">Terms of Service</a> and <a href="{{ route('privacy.policy') }}" target="_blank">Privacy Policy</a>
                            </label>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Continue to Billing Information
                            <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <p class="mb-0">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Section -->
        <div class="card mt-4 bg-light">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-info-circle me-2"></i>
                    What's Next?
                </h6>
                <p class="card-text mb-0">After creating your account, you'll need to:</p>
                <ul class="mt-2 mb-0">
                    <li>Add your billing information for subscription management</li>
                    <li>Set up your tenant domain and workspace</li>
                    <li>Access your personalized dashboard</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection