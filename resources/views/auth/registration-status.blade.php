@extends('layouts.app')

@section('title', 'Complete Registration')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Progress Header -->
        <div class="card mb-4 bg-primary text-white">
            <div class="card-body text-center">
                <h2>Complete Your Registration</h2>
                <p class="mb-0">You're {{ Auth::user()->registration_progress }}% complete!</p>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Step 1: Account -->
                    <div class="col-md-4">
                        <div class="text-center p-4 {{ Auth::user()->exists ? 'bg-success text-white' : 'bg-light' }} rounded">
                            <i class="bi bi-person-check fs-1"></i>
                            <h5 class="mt-2">Account Created</h5>
                            <span class="badge {{ Auth::user()->exists ? 'bg-light text-success' : 'bg-secondary' }}">
                                {{ Auth::user()->exists ? '✓ Complete' : 'Pending' }}
                            </span>
                        </div>
                    </div>

                    <!-- Step 2: Billing -->
                    <div class="col-md-4">
                        <div class="text-center p-4 {{ Auth::user()->billing ? 'bg-success text-white' : 'bg-light' }} rounded">
                            <i class="bi bi-credit-card fs-1"></i>
                            <h5 class="mt-2">Billing Info</h5>
                            @if(Auth::user()->billing)
                                <span class="badge bg-light text-success">✓ Complete</span>
                            @else
                                <a href="{{ route('register.step2') }}" class="btn btn-warning btn-sm">Add Now</a>
                            @endif
                        </div>
                    </div>

                    <!-- Step 3: Tenant -->
                    <div class="col-md-4">
                        <div class="text-center p-4 {{ Auth::user()->tenant ? 'bg-success text-white' : 'bg-light' }} rounded">
                            <i class="bi bi-building fs-1"></i>
                            <h5 class="mt-2">Workspace</h5>
                            @if(Auth::user()->tenant)
                                <span class="badge bg-light text-success">✓ Complete</span>
                            @elseif(Auth::user()->billing)
                                <a href="{{ route('register.step3') }}" class="btn btn-warning btn-sm">Setup Now</a>
                            @else
                                <span class="badge bg-secondary">Pending</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mt-4">
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ Auth::user()->registration_progress }}%">
                            {{ Auth::user()->registration_progress }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Next Steps</h5>
            </div>
            <div class="card-body">
                @if(!Auth::user()->billing)
                    <div class="alert alert-warning">
                        <h6 class="alert-heading">Add Billing Information</h6>
                        <p>Complete your billing details to continue with workspace setup.</p>
                        <a href="{{ route('register.step2') }}" class="btn btn-warning">Add Billing Info</a>
                    </div>
                @elseif(!Auth::user()->tenant)
                    <div class="alert alert-info">
                        <h6 class="alert-heading">Setup Your Workspace</h6>
                        <p>Create your custom workspace to complete registration.</p>
                        <a href="{{ route('register.step3') }}" class="btn btn-primary">Setup Workspace</a>
                    </div>
                @else
                    <div class="alert alert-success">
                        <h6 class="alert-heading">Registration Complete!</h6>
                        <p>Congratulations! Your account is fully set up and ready to use.</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-success">Go to Dashboard</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection