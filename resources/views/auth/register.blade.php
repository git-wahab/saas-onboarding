@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="alert alert-info">
            <h5 class="alert-heading">Multi-Step Registration</h5>
            <p>We've upgraded to a multi-step registration process for a better experience!</p>
            <hr>
            <p class="mb-0">You'll complete your account in 3 easy steps:</p>
            <ol class="mt-2 mb-0">
                <li>Account Information</li>
                <li>Billing Details</li>
                <li>Workspace Setup</li>
            </ol>
        </div>

        <div class="card">
            <div class="card-header text-center">
                <h4 class="mb-0">Get Started</h4>
                <p class="mb-0 text-muted">Begin your registration journey</p>
            </div>
            <div class="card-body text-center">
                <i class="bi bi-person-plus display-1 text-primary mb-3"></i>
                <h5>Ready to create your account?</h5>
                <p class="text-muted mb-4">Join thousands of users who trust our platform for their business needs.</p>
                
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                    Start Registration
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
                
                <div class="mt-4">
                    <small class="text-muted">Already have an account? <a href="{{ route('login') }}">Login here</a></small>
                </div>
            </div>
        </div>

        <!-- Features Preview -->
        <div class="card mt-4 bg-light">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-star-fill text-warning me-2"></i>
                    What's included:
                </h6>
                <div class="row">
                    <div class="col-6">
                        <ul class="list-unstyled mb-0 small">
                            <li><i class="bi bi-check text-success me-1"></i> Secure account</li>
                            <li><i class="bi bi-check text-success me-1"></i> Custom workspace</li>
                            <li><i class="bi bi-check text-success me-1"></i> Billing management</li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled mb-0 small">
                            <li><i class="bi bi-check text-success me-1"></i> Analytics dashboard</li>
                            <li><i class="bi bi-check text-success me-1"></i> 24/7 support</li>
                            <li><i class="bi bi-check text-success me-1"></i> API access</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Redirect to step 1 automatically
document.addEventListener('DOMContentLoaded', function() {
    // Check if we should redirect to step 1
    const startButton = document.querySelector('a[href="{{ route('register') }}"]');
    if (startButton && window.location.pathname === '/register') {
        // Update href to go to step 1
        startButton.href = "{{ route('register') }}";
        
        // Auto redirect after 2 seconds if user doesn't click
        setTimeout(function() {
            if (window.location.pathname === '/register') {
                window.location.href = "{{ route('register') }}";
            }
        }, 3000);
    }
});
</script>
@endsection