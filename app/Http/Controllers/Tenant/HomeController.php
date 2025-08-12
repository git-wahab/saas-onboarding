<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Tenant;

class HomeController extends Controller
{
    public function index()
    {
        $tenant = Tenant::current();
        
        return view('tenant.home', compact('tenant'));
    }

    public function privacyPolicy()
    {
        $tenant = Tenant::current();
        
        return view('tenant.privacy-policy', compact('tenant'));
    }

    public function dashboard()
    {
        $tenant = Tenant::current();
        $user = auth('tenant')->user();
        
        return view('tenant.dashboard', compact('tenant', 'user'));
    }
}