@extends('layouts.app')

@section('title', 'Register - Step 3')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Progress Bar -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-3">Registration Progress</h5>
                <div class="progress mb-2">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-success" role="progressbar" style="width: 34%" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex justify-content-between small text-muted">
                    <span class="text-success">✓ Step 1: Account Info</span>
                    <span class="text-success">✓ Step 2: Billing</span>
                    <span class="text-primary fw-bold">Step 3: Tenant Setup</span>
                </div>
            </div>
        </div>

        <!-- Completion Status -->
        <div class="card mb-4 bg-light">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="card-title mb-1">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Almost Done!
                        </h6>
                        <p class="mb-0">Account and billing information saved. Let's set up your workspace!</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <span class="badge bg-success fs-6">97% Complete</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tenant Setup Form -->
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-building me-2"></i>
                    Tenant Workspace Setup
                </h4>
                <p class="mb-0 text-muted">Step 3 of 3: Create Your Workspace</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register.step3') }}">
                    @csrf

                    <!-- Tenant Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Workspace Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               placeholder="Enter your company or workspace name">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="form-text">This will be the display name for your workspace.</div>
                    </div>

                    <!-- Domain -->
                    <div class="mb-4">
                        <label for="domain" class="form-label">Domain <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control @error('domain') is-invalid @enderror" 
                                   id="domain" 
                                   name="domain" 
                                   value="{{ old('domain') }}" 
                                   required 
                                   placeholder="mycompany"
                                   pattern="[a-zA-Z0-9-_]+"
                                   style="text-transform: lowercase;">
                            <span class="input-group-text">.multi-tenant.test</span>
                        </div>
                        @error('domain')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="form-text">Choose a unique subdomain for your workspace. Only letters, numbers, hyphens, and underscores allowed.</div>
                        
                        <!-- Domain Preview -->
                        <div class="mt-2">
                            <small class="text-muted">Your workspace will be accessible at: </small>
                            <strong class="text-primary" id="domain-preview">https://yourcompany.multitenant.test</strong>
                        </div>
                    </div>

                    <!-- Features Preview -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="bi bi-star-fill text-warning me-2"></i>
                                What you'll get:
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><i class="bi bi-check text-success me-2"></i>Custom subdomain</li>
                                        <li><i class="bi bi-check text-success me-2"></i>Dedicated database</li>
                                        <li><i class="bi bi-check text-success me-2"></i>User management</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><i class="bi bi-check text-success me-2"></i>Analytics dashboard</li>
                                        <li><i class="bi bi-check text-success me-2"></i>API access</li>
                                        <li><i class="bi bi-check text-success me-2"></i>24/7 support</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms Agreement -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="workspace_terms" required>
                            <label class="form-check-label" for="workspace_terms">
                                I confirm that I have the authority to create this workspace and agree to the 
                                <a href="{{ route('privacy.policy') }}" target="_blank">Service Terms</a>
                            </label>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('register.step2') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Back to Billing
                        </a>
                        <button type="submit" class="btn btn-success btn-lg">
                            Complete Registration
                            <i class="bi bi-check-lg ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Section -->
        <div class="card mt-4 bg-light">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-lightbulb me-2"></i>
                    Need Help Choosing a Domain?
                </h6>
                <p class="card-text mb-2">Here are some tips for choosing a good domain:</p>
                <ul class="mb-0">
                    <li>Keep it short and memorable</li>
                    <li>Use your company name or brand</li>
                    <li>Avoid special characters except hyphens and underscores</li>
                    <li>Make sure it's unique and professional</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const domainInput = document.getElementById('domain');
    const domainPreview = document.getElementById('domain-preview');
    
    // Update domain preview
    function updateDomainPreview() {
        const domain = domainInput.value.toLowerCase() || 'yourcompany';
        domainPreview.textContent = `http://${domain}.multitenant.test`;
    }
    
    // Convert to lowercase and update preview
    domainInput.addEventListener('input', function(e) {
        e.target.value = e.target.value.toLowerCase().replace(/[^a-z0-9-_]/g, '');
        updateDomainPreview();
    });
    
    // Auto-suggest domain based on workspace name
    const nameInput = document.getElementById('name');
    nameInput.addEventListener('input', function(e) {
        if (!domainInput.value) {
            const suggested = e.target.value
                .toLowerCase()
                .replace(/[^a-z0-9]/g, '')
                .substring(0, 20);
            domainInput.value = suggested;
            updateDomainPreview();
        }
    });
    
    // Initial update
    updateDomainPreview();
});
</script>

@endsection