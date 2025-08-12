<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Billing;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function dashboard()
    {
        // Check if user has admin access
        if (!auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'You do not have permission to access the admin dashboard.');
        }

        $totalUsers = User::count();
        $totalTenants = Tenant::count();
        $recentUsers = User::latest()->take(5)->get();
        $recentTenants = Tenant::with('user')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalUsers', 'totalTenants', 'recentUsers', 'recentTenants'));
    }
}