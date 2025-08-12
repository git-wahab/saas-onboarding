<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    /**
     * Show the privacy policy page
     */
    public function privacyPolicy()
    {
        return view('privacy-policy');
    }

    /**
     * Show the dashboard (protected route)
     */
    public function dashboard()
    {
        $user = auth()->user();

        // Admins bypass registration requirements
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return redirect()->route('landlord.admin.dashboard');
        }
        return view('dashboard');
    }
}
