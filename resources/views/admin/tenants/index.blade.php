@extends('layouts.admin')

@section('title', 'Manage Tenants')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Manage Tenants</h1>
</div>

<div class="card">
    <div class="card-body">
        @if($tenants->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tenant Name</th>
                        <th>Domain</th>
                        <th>Owner</th>
                        <th>Database</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tenants as $tenant)
                    <tr>
                        <td>{{ $tenant->id }}</td>
                        <td>
                            <strong>{{ $tenant->name }}</strong>
                        </td>
                        <td>
                            <a href="http://{{ $tenant->domain }}.multitenant.test" target="_blank" class="text-decoration-none">
                                {{ $tenant->domain }}.multitenant.test
                                <i class="bi bi-box-arrow-up-right ms-1"></i>
                            </a>
                        </td>
                        <td>
                            <div>
                                <strong>{{ $tenant->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $tenant->user->email }}</small>
                            </div>
                        </td>
                        <td>
                            <code>{{ $tenant->database }}</code>
                        </td>
                        <td>
                            <span data-bs-toggle="tooltip" title="{{ $tenant->created_at->format('M d, Y g:i A') }}">
                                {{ $tenant->created_at->diffForHumans() }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('landlord.admin.tenants.edit', $tenant) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $tenant->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $tenant->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Tenant</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the tenant <strong>"{{ $tenant->name }}"</strong>?</p>
                                            <p class="text-muted">This action cannot be undone and will remove all associated data.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form method="POST" action="{{ route('landlord.admin.tenants.destroy', $tenant) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete Tenant</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $tenants->links() }}
        </div>
        @endif
    </div>
</div>

<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endsection