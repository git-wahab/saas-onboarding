@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Admin Dashboard</h1>
            <span class="badge bg-primary">{{ Auth::user()->roles->first()->display_name ?? 'Admin' }}</span>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Users</h5>
                        <h2 class="card-text">{{ $totalUsers }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Tenants</h5>
                        <h2 class="card-text">{{ $totalTenants }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-building fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('landlord.admin.tenants.index') }}" class="text-white text-decoration-none">
                    <small>View Details <i class="bi bi-arrow-right"></i></small>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Active Workspaces</h5>
                        <h2 class="card-text">{{ $totalTenants }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-globe fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <small>Currently operational</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">New This Month</h5>
                        <h2 class="card-text">{{ \App\Models\User::whereMonth('created_at', now()->month)->count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-graph-up fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <small>Users registered this month</small>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Users</h5>
            </div>
            <div class="card-body">
                @if($recentUsers->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($recentUsers as $user)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ $user->name }}</h6>
                            <p class="mb-1 text-muted">{{ $user->email }}</p>
                            <small>Registered {{ $user->created_at->diffForHumans() }}</small>
                        </div>
                        <div>
                            @if($user->hasCompletedRegistration())
                                <span class="badge bg-success">Complete</span>
                            @else
                                <span class="badge bg-warning">{{ $user->registration_progress }}%</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted">No users found.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Tenants</h5>
                <a href="{{ route('landlord.admin.tenants.index') }}" class="btn btn-sm btn-outline-success">View All</a>
            </div>
            <div class="card-body">
                @if($recentTenants->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($recentTenants as $tenant)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ $tenant->name }}</h6>
                            <p class="mb-1 text-muted">{{ $tenant->domain }}.multitenant.test</p>
                            <small>Owner: {{ $tenant->user->name }} • Created {{ $tenant->created_at->diffForHumans() }}</small>
                        </div>
                        <div>
                            <a href="{{ route('landlord.admin.tenants.show', $tenant) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted">No tenants found.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('landlord.admin.tenants.index') }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="bi bi-building me-2"></i>
                            Manage Tenants
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary w-100 mb-2">
                            <i class="bi bi-house me-2"></i>
                            User Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection