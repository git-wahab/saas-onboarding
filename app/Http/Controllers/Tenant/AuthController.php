<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Multitenancy\Models\Tenant;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $tenant = Tenant::current();
        
        return view('tenant.login', compact('tenant'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('tenant')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('tenant.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);
    }

    public function showRegisterForm()
    {
        $tenant = Tenant::current();
        
        return view('tenant.register', compact('tenant'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = UserModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('tenant')->login($user);

        return redirect()->route('tenant.dashboard', ['tenant' => Tenant::current()->domain ?? Tenant::current()->id])
            ->with('success', 'Registration successful! Welcome to ' . Tenant::current()->name);
    }

    public function logout(Request $request)
    {
        Auth::guard('tenant')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('tenant.home', ['tenant' => Tenant::current()->domain ?? Tenant::current()->id])
            ->with('success', 'You have been logged out successfully.');
    }
}