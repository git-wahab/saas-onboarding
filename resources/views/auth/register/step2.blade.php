@extends('layouts.app')

@section('title', 'Register - Step 2')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Progress Bar -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-3">Registration Progress</h5>
                <div class="progress mb-2">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 34%" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex justify-content-between small text-muted">
                    <span class="text-success">✓ Step 1: Account Info</span>
                    <span class="text-primary fw-bold">Step 2: Billing</span>
                    <span>Step 3: Tenant Setup</span>
                </div>
            </div>
        </div>

        <!-- User Info Display -->
        <div class="card mb-4 bg-light">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    Account Created Successfully
                </h6>
                <p class="mb-0">Welcome, <strong>{{ Auth::user()->name }}</strong>! Now let's set up your billing information.</p>
            </div>
        </div>

        <!-- Billing Form -->
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-credit-card me-2"></i>
                    Billing Information
                </h4>
                <p class="mb-0 text-muted">Step 2 of 3: Payment Details</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register.step2') }}">
                    @csrf

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Demo Notice:</strong> This is for demonstration purposes only. Never store real card information in plain text!
                    </div>
                    
                    <!-- Billing Name -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name on Card <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('first_name') is-invalid @enderror" 
                                   id="first_name" 
                                   name="first_name" 
                                   value="{{ old('first_name', Auth::user()->first_name) }}" 
                                   required 
                                   placeholder="First name">
                            @error('first_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name on Card <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('last_name') is-invalid @enderror" 
                                   id="last_name" 
                                   name="last_name" 
                                   value="{{ old('last_name', Auth::user()->last_name) }}" 
                                   required 
                                   placeholder="Last name">
                            @error('last_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Card Number -->
                    <div class="mb-3">
                        <label for="card_number" class="form-label">Card Number <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('card_number') is-invalid @enderror" 
                               id="card_number" 
                               name="card_number" 
                               value="{{ old('card_number') }}" 
                               required 
                               placeholder="1234 5678 9012 3456"
                               maxlength="19">
                        @error('card_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Expiry and CVV -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="expiry" class="form-label">Expiry Date <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('expiry') is-invalid @enderror" 
                                   id="expiry" 
                                   name="expiry" 
                                   value="{{ old('expiry') }}" 
                                   required 
                                   placeholder="MM/YY"
                                   maxlength="5">
                            @error('expiry')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cvv" class="form-label">CVV <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="cvv" 
                                   name="cvv" 
                                   placeholder="123"
                                   maxlength="4">
                            <div class="form-text">3-4 digits on the back of your card</div>
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" 
                               class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               required 
                               placeholder="+1 (555) 123-4567">
                        @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Security Notice -->
                    <div class="alert alert-warning">
                        <i class="bi bi-shield-exclamation me-2"></i>
                        <strong>Security:</strong> Your payment information is encrypted and stored securely. We use industry-standard security measures to protect your data.
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Back to Account Info
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            Continue to Tenant Setup
                            <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Section -->
        <div class="card mt-4 bg-light">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-question-circle me-2"></i>
                    Why do we need billing information?
                </h6>
                <p class="card-text mb-0">We collect billing information to:</p>
                <ul class="mt-2 mb-0">
                    <li>Set up your subscription for premium features</li>
                    <li>Enable automatic billing for your tenant workspace</li>
                    <li>Provide detailed usage reports and invoicing</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format card number input
    const cardInput = document.getElementById('card_number');
    cardInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        e.target.value = formattedValue;
    });

    // Format expiry date input
    const expiryInput = document.getElementById('expiry');
    expiryInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        e.target.value = value;
    });
});
</script>

@endsection