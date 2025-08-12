@extends('layouts.admin')

@section('title', 'Edit Tenant')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Edit Tenant</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('landlord.admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('landlord.admin.tenants.index') }}">Tenants</a></li>
                <li class="breadcrumb-item"><a href="{{ route('landlord.admin.tenants.show', $tenant) }}">{{ $tenant->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('landlord.admin.tenants.show', $tenant) }}" class="btn btn-outline-secondary me-2">
            <i class="bi bi-eye me-1"></i>
            View Details
        </a>
        <a href="{{ route('landlord.admin.tenants.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Edit Form -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Tenant Information
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('landlord.admin.tenants.update', $tenant) }}">
                    @csrf
                    @method('PUT')

                    <!-- Current Info Alert -->
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="bi bi-info-circle me-2"></i>
                            Current Information
                        </h6>
                        <p class="mb-0">
                            <strong>Current Domain:</strong> {{ $tenant->domain }}.multitenant.test<br>
                            <strong>Current Owner:</strong> {{ $tenant->user->name }} ({{ $tenant->user->email }})<br>
                            <strong>Database:</strong> {{ $tenant->database }}
                        </p>
                    </div>

                    <!-- Owner Selection -->
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Owner <span class="text-danger">*</span></label>
                        <select class="form-select @error('user_id') is-invalid @enderror" 
                                id="user_id" 
                                name="user_id" 
                                required>
                            <option value="">Select a user...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                        {{ old('user_id', $tenant->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                    @if($user->tenant && $user->id !== $tenant->user_id)
                                        - Has Tenant: {{ $user->tenant->name }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="form-text">
                            Only users without a tenant or the current owner are shown.
                        </div>
                    </div>

                    <!-- Tenant Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Workspace Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $tenant->name) }}" 
                               required 
                               placeholder="Enter workspace name">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="form-text">
                            This will be the display name for the workspace.
                        </div>
                    </div>

                    <!-- Domain -->
                    <div class="mb-4">
                        <label for="domain" class="form-label">Domain <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control @error('domain') is-invalid @enderror" 
                                   id="domain" 
                                   name="domain" 
                                   value="{{ old('domain', $tenant->domain) }}" 
                                   required 
                                   placeholder="subdomain"
                                   pattern="[a-zA-Z0-9-_]+"
                                   style="text-transform: lowercase;">
                            <span class="input-group-text">.multitenant.test</span>
                        </div>
                        @error('domain')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="form-text">
                            Only letters, numbers, hyphens, and underscores allowed. Must be unique.
                        </div>
                        
                        <!-- Domain Preview -->
                        <div class="mt-2">
                            <small class="text-muted">Workspace URL: </small>
                            <strong class="text-primary" id="domain-preview">
                                http://{{ $tenant->domain }}.multitenant.test
                            </strong>
                        </div>
                    </div>

                    <!-- Warning for Domain Change -->
                    <div class="alert alert-warning" id="domain-warning" style="display: none;">
                        <h6 class="alert-heading">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Domain Change Warning
                        </h6>
                        <p class="mb-0">
                            Changing the domain will affect the workspace URL. Make sure to update any bookmarks or links.
                        </p>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('landlord.admin.tenants.show', $tenant) }}" class="btn btn-secondary me-md-2">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>
                            Update Tenant
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar with Additional Info -->
    <div class="col-lg-4">
        <!-- Tenant Details -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Tenant Details
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td><strong>ID:</strong></td>
                        <td>{{ $tenant->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Created:</strong></td>
                        <td>{{ $tenant->created_at->format('M d, Y g:i A') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Updated:</strong></td>
                        <td>{{ $tenant->updated_at->format('M d, Y g:i A') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Database:</strong></td>
                        <td><code>{{ $tenant->database }}</code></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Current Owner Info -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-person me-2"></i>
                    Current Owner
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                         style="width: 40px; height: 40px;">
                        {{ $tenant->user->initials }}
                    </div>
                    <div>
                        <h6 class="mb-0">{{ $tenant->user->name }}</h6>
                        <small class="text-muted">{{ $tenant->user->email }}</small>
                        <div class="mt-1">
                            @foreach($tenant->user->roles as $role)
                                <span class="badge bg-secondary">{{ $role->display_name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="text-muted small">Member Since</div>
                        <div>{{ $tenant->user->created_at->format('M Y') }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Registration</div>
                        <div>
                            @if($tenant->user->hasCompletedRegistration())
                                <span class="badge bg-success">Complete</span>
                            @else
                                <span class="badge bg-warning">{{ $tenant->user->registration_progress }}%</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-lightning me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="https://{{ $tenant->domain }}.multitenant.test" 
                       target="_blank" 
                       class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-box-arrow-up-right me-2"></i>
                        Visit Workspace
                    </a>
                    
                    @if(Auth::user()->hasPermission('tenants.delete'))
                    <button type="button" 
                            class="btn btn-outline-danger btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-2"></i>
                        Delete Tenant
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
@if(Auth::user()->hasPermission('tenants.delete'))
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Tenant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h6 class="alert-heading">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Permanent Deletion Warning
                    </h6>
                    <p class="mb-0">
                        This action cannot be undone. All workspace data, configurations, and associated records will be permanently deleted.
                    </p>
                </div>
                
                <p>Are you sure you want to delete the tenant <strong>"{{ $tenant->name }}"</strong>?</p>
                
                <div class="bg-light p-3 rounded">
                    <h6>This will delete:</h6>
                    <ul class="mb-0">
                        <li>Workspace: {{ $tenant->name }}</li>
                        <li>Domain: {{ $tenant->domain }}.multitenant.test</li>
                        <li>Database: {{ $tenant->database }}</li>
                        <li>All associated configurations</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('landlord.admin.tenants.destroy', $tenant) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>
                        Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const domainInput = document.getElementById('domain');
    const domainPreview = document.getElementById('domain-preview');
    const domainWarning = document.getElementById('domain-warning');
    const originalDomain = '{{ $tenant->domain }}';
    
    // Update domain preview and show warning
    function updateDomainPreview() {
        const domain = domainInput.value.toLowerCase() || 'subdomain';
        domainPreview.textContent = `http://${domain}.multitenant.test`;
        
        // Show warning if domain changed
        if (domain !== originalDomain) {
            domainWarning.style.display = 'block';
        } else {
            domainWarning.style.display = 'none';
        }
    }
    
    // Convert to lowercase and update preview
    domainInput.addEventListener('input', function(e) {
        e.target.value = e.target.value.toLowerCase().replace(/[^a-z0-9-_]/g, '');
        updateDomainPreview();
    });
    
    // Auto-suggest domain based on workspace name
    const nameInput = document.getElementById('name');
    nameInput.addEventListener('input', function(e) {
        // Only auto-suggest if domain hasn't been manually changed
        if (domainInput.value === originalDomain || domainInput.value === '') {
            const suggested = e.target.value
                .toLowerCase()
                .replace(/[^a-z0-9]/g, '')
                .substring(0, 20);
            domainInput.value = suggested || originalDomain;
            updateDomainPreview();
        }
    });
    
    // Initial setup
    updateDomainPreview();
});
</script>
@endsection