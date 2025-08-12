@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Dashboard</h1>
            <span class="badge bg-success">{{ now()->format('l, F j, Y') }}</span>
        </div>
    </div>
</div>

<!-- Registration Progress Check -->
@if(!Auth::user()->hasCompletedRegistration())
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-warning">
            <h5 class="alert-heading">Complete Your Registration</h5>
            <p>Your registration is {{ Auth::user()->registration_progress }}% complete. Please finish setting up your account to access all features.</p>
            <hr>
            @if(!Auth::user()->billing()->exists())
                <a href="{{ route('register.step2') }}" class="btn btn-warning">Complete Billing Information</a>
            @elseif(!Auth::user()->tenant()->exists())
                <a href="{{ route('register.step3') }}" class="btn btn-warning">Complete Tenant Setup</a>
            @endif
        </div>
    </div>
</div>
@endif

<!-- Welcome Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h2 class="card-title">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="card-text">Here's an overview of your account and recent activity.</p>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <small>Member since: {{ Auth::user()->created_at->format('F j, Y') }}</small>
                    </div>
                    <div class="col-md-6 text-end">
                        @if(Auth::user()->hasCompletedRegistration())
                            <span class="badge bg-success">✓ Registration Complete</span>
                        @else
                            <span class="badge bg-warning">Registration {{ Auth::user()->registration_progress }}% Complete</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Account Information -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Account Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td>{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ Auth::user()->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Member Since:</strong></td>
                        <td>{{ Auth::user()->created_at->format('F j, Y') }}</td>
                    </tr>
                    @if(Auth::user()->billing)
                    <tr>
                        <td><strong>Billing:</strong></td>
                        <td>{{ Auth::user()->billing->masked_card_number }}</td>
                    </tr>
                    @endif
                    @if(Auth::user()->tenant)
                    <tr>
                        <td><strong>Workspace:</strong></td>
                        <td>{{ Auth::user()->tenant->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Domain:</strong></td>
                        <td><a href="http://{{ Auth::user()->tenant->domain }}.multitenant.test" target="_blank">{{ Auth::user()->tenant->domain }}.multitenant.test</a></td>
                    </tr>
                    @endif
                </table>
                <div class="mt-3">
                    <button class="btn btn-outline-primary btn-sm">Edit Profile</button>
                    <button class="btn btn-outline-secondary btn-sm">Change Password</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if(Auth::user()->tenant)
                        <a href="http://{{ Auth::user()->tenant->domain }}.multitenant.test" target="_blank" class="btn btn-outline-success">
                            <i class="bi bi-box-arrow-up-right me-2"></i>
                            Visit Your Workspace
                        </a>
                    @endif
                    <button class="btn btn-outline-primary">View Profile</button>
                    <button class="btn btn-outline-info">Account Settings</button>
                    <button class="btn btn-outline-warning">Notifications</button>
                    @if(!Auth::user()->hasCompletedRegistration())
                        @if(!Auth::user()->billing)
                            <a href="{{ route('register.step2') }}" class="btn btn-warning">Complete Billing</a>
                        @elseif(!Auth::user()->tenant)
                            <a href="{{ route('register.step3') }}" class="btn btn-warning">Complete Setup</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Registration</h5>
                <h3 class="card-text">{{ Auth::user()->registration_progress }}%</h3>
                <small>Progress</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Login Count</h5>
                <h3 class="card-text">{{ rand(10, 100) }}</h3>
                <small>Total logins</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Days Active</h5>
                <h3 class="card-text">{{ Auth::user()->created_at->diffInDays(now()) }}</h3>
                <small>Since registration</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white {{ Auth::user()->hasCompletedRegistration() ? 'bg-success' : 'bg-danger' }}">
            <div class="card-body">
                <h5 class="card-title">Account Status</h5>
                <h3 class="card-text">{{ Auth::user()->hasCompletedRegistration() ? 'Complete' : 'Pending' }}</h3>
                <small>Current status</small>
            </div>
        </div>
    </div>
</div>

<!-- Registration Steps Progress -->
@if(!Auth::user()->hasCompletedRegistration())
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Complete Your Registration</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center p-3 {{ Auth::user()->exists ? 'text-success' : 'text-muted' }}">
                            <i class="bi bi-person-plus fs-1 {{ Auth::user()->exists ? 'text-success' : 'text-muted' }}"></i>
                            <h6 class="mt-2">Account Info</h6>
                            @if(Auth::user()->exists)
                                <span class="badge bg-success">✓ Complete</span>
                            @else
                                <span class="badge bg-secondary">Pending</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 {{ Auth::user()->billing ? 'text-success' : 'text-muted' }}">
                            <i class="bi bi-credit-card fs-1 {{ Auth::user()->billing ? 'text-success' : 'text-muted' }}"></i>
                            <h6 class="mt-2">Billing Info</h6>
                            @if(Auth::user()->billing)
                                <span class="badge bg-success">✓ Complete</span>
                            @else
                                <a href="{{ route('register.step2') }}" class="btn btn-sm btn-warning">Complete</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 {{ Auth::user()->tenant ? 'text-success' : 'text-muted' }}">
                            <i class="bi bi-building fs-1 {{ Auth::user()->tenant ? 'text-success' : 'text-muted' }}"></i>
                            <h6 class="mt-2">Tenant Setup</h6>
                            @if(Auth::user()->tenant)
                                <span class="badge bg-success">✓ Complete</span>
                            @else
                                @if(Auth::user()->billing)
                                    <a href="{{ route('register.step3') }}" class="btn btn-sm btn-warning">Complete</a>
                                @else
                                    <span class="badge bg-secondary">Pending</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Recent Activity -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Activity</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Account created</h6>
                            <p class="mb-1">Welcome to our platform!</p>
                            <small>{{ Auth::user()->created_at->diffForHumans() }}</small>
                        </div>
                        <span class="badge bg-success rounded-pill">New</span>
                    </div>
                    @if(Auth::user()->billing)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Billing information added</h6>
                            <p class="mb-1">Payment method configured successfully</p>
                            <small>{{ Auth::user()->billing->created_at->diffForHumans() }}</small>
                        </div>
                        <span class="badge bg-info rounded-pill">Billing</span>
                    </div>
                    @endif
                    @if(Auth::user()->tenant)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Workspace created</h6>
                            <p class="mb-1">{{ Auth::user()->tenant->name }} workspace is ready</p>
                            <small>{{ Auth::user()->tenant->created_at->diffForHumans() }}</small>
                        </div>
                        <span class="badge bg-success rounded-pill">Complete</span>
                    </div>
                    @endif
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Dashboard accessed</h6>
                            <p class="mb-1">You're currently viewing your dashboard</p>
                            <small>Just now</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">Current</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsectiond>{{ Auth::user()->created_at->format('F j, Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Last Updated:</strong></td>
                        <td>{{ Auth::user()->updated_at->format('F j, Y g:i A') }}</td>
                    </tr>
                </table>
                <div class="mt-3">
                    <button class="btn btn-outline-primary btn-sm">Edit Profile</button>
                    <button class="btn btn-outline-secondary btn-sm">Change Password</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary">View Profile</button>
                    <button class="btn btn-outline-info">Account Settings</button>
                    <button class="btn btn-outline-success">Security Settings</button>
                    <button class="btn btn-outline-warning">Notifications</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Profile Views</h5>
                <h3 class="card-text">{{ rand(50, 500) }}</h3>
                <small>This month</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Login Count</h5>
                <h3 class="card-text">{{ rand(10, 100) }}</h3>
                <small>Total logins</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Days Active</h5>
                <h3 class="card-text">{{ Auth::user()->created_at->diffInDays(now()) }}</h3>
                <small>Since registration</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h5 class="card-title">Account Status</h5>
                <h3 class="card-text">Active</h3>
                <small>Current status</small>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Activity</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Account created</h6>
                            <p class="mb-1">Welcome to our platform!</p>
                            <small>{{ Auth::user()->created_at->diffForHumans() }}</small>
                        </div>
                        <span class="badge bg-success rounded-pill">New</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Dashboard accessed</h6>
                            <p class="mb-1">You're currently viewing your dashboard</p>
                            <small>Just now</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">Current</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Profile updated</h6>
                            <p class="mb-1">Account information was last modified</p>
                            <small>{{ Auth::user()->updated_at->diffForHumans() }}</small>
                        </div>
                        <span class="badge bg-info rounded-pill">Update</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection