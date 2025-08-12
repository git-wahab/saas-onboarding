<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    /**
     * Display a listing of tenants.
     */
    public function index()
    {
        // Check permission
        if (!auth()->user()->hasPermission('tenants.view')) {
            abort(403, 'You do not have permission to view tenants.');
        }

        $tenants = Tenant::with('user')->paginate(15);
        
        return view('admin.tenants.index', compact('tenants'));
    }

    /**
     * Store a newly created tenant in storage.
     */
    public function store(Request $request)
    {
        // Check permission
        if (!auth()->user()->hasPermission('tenants.create')) {
            abort(403, 'You do not have permission to create tenants.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id|unique:tenants,user_id',
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:tenants,domain|alpha_dash',
        ]);

        try {
            DB::beginTransaction();

            // Generate unique database name
            $database = 'tenant_' . strtolower($request->domain) . '_' . time();

            Tenant::create([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'domain' => strtolower($request->domain),
                'database' => $database,
            ]);

            DB::commit();

            return redirect()->route('landlord.admin.tenants.index')
                ->with('success', 'Tenant created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Display the specified tenant.
     */
    public function show(Tenant $tenant)
    {
        // Check permission
        if (!auth()->user()->hasPermission('tenants.view')) {
            abort(403, 'You do not have permission to view tenants.');
        }

        $tenant->load('user', 'user.billing');
        
        return view('admin.tenants.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified tenant.
     */
    public function edit(Tenant $tenant)
    {
        // Check permission
        if (!auth()->user()->hasPermission('tenants.edit')) {
            abort(403, 'You do not have permission to edit tenants.');
        }

        $users = User::where('id', $tenant->user_id)
            ->orWhereDoesntHave('tenant')
            ->get();
        
        return view('admin.tenants.edit', compact('tenant', 'users'));
    }

    /**
     * Update the specified tenant in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        // Check permission
        if (!auth()->user()->hasPermission('tenants.edit')) {
            abort(403, 'You do not have permission to edit tenants.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id|unique:tenants,user_id,' . $tenant->id,
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|alpha_dash|unique:tenants,domain,' . $tenant->id,
        ]);

        try {
            DB::beginTransaction();

            $tenant->update([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'domain' => strtolower($request->domain),
            ]);

            DB::commit();

            return redirect()->route('landlord.admin.tenants.index')
                ->with('success', 'Tenant updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Remove the specified tenant from storage.
     */
    public function destroy(Tenant $tenant)
    {
        // Check permission
        if (!auth()->user()->hasPermission('tenants.delete')) {
            abort(403, 'You do not have permission to delete tenants.');
        }

        try {
            DB::beginTransaction();

            $tenantName = $tenant->name;
            $tenant->delete();

            DB::commit();

            return redirect()->route('landlord.admin.tenants.index')
                ->with('success', "Tenant '{$tenantName}' deleted successfully.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }
}