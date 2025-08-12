<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Billing;
use App\Models\Tenant;

// use App\Models\Tenant;

class RegistrationController extends Controller
{
    /**
     * Show Step 1: User Information
     */
    public function step1()
    {
        // Check if user is already logged in and redirect to appropriate step
        if (Auth::check()) {
            return $this->redirectToNextStep(Auth::user());
        }

        return view('auth.register.step1');
    }

    /**
     * Store Step 1: User Information
     */
    public function storeStep1(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Login the user
            Auth::login($user);

            // Store registration step in session
            session(['registration_step' => 2]);

            DB::commit();

            return redirect()->route('register.step2')->with('success', 'Account created! Please complete your billing information.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong. Please try again.'])->withInput();
        }
    }

    /**
     * Show Step 2: Billing Information
     */
    public function step2()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('register')->with('error', 'Please complete step 1 first.');
        }

        $user = Auth::user();

        // If billing already exists, skip to step 3
        if ($user->billing()->exists()) {
            return redirect()->route('register.step3');
        }

        return view('auth.register.step2');
    }

    /**
     * Store Step 2: Billing Information
     */
    public function storeStep2(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('register')->with('error', 'Please complete step 1 first.');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'card_number' => 'required|string|min:16|max:19',
            'expiry'      => 'required|date_format:m/y',
            'phone' => 'required|string|max:20',
        ]);

        try {
            DB::beginTransaction();

            // Create billing record
            Billing::create([
                'user_id' => Auth::id(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'card_number' => $request->card_number, // Note: In production, encrypt this!
                'expiry' => $request->expiry,
                'phone' => $request->phone,
            ]);

            // Update registration step
            session(['registration_step' => 3]);

            DB::commit();

            return redirect()->route('register.step3')->with('success', 'Billing information saved! Please set up your tenant.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong. Please try again.'])->withInput();
        }
    }

    /**
     * Show Step 3: Tenant Information
     */
    public function step3()
    {
        if (!Auth::check()) {
            return redirect()->route('register')->with('error', 'Please complete step 1 first.');
        }

        $user = Auth::user();

        // Check if previous steps are completed
        if (!$user->billing()->exists()) {
            return redirect()->route('register.step2')->with('error', 'Please complete billing information first.');
        }

        // If tenant already exists, redirect to dashboard
        if ($user->tenant()->exists()) {
            return redirect()->route('dashboard')->with('success', 'Registration completed successfully!');
        }

        return view('auth.register.step3');
    }

    /**
     * Store Step 3: Tenant Information
     */
    public function storeStep3(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('register')->with('error', 'Please complete step 1 first.');
        }

        $user = Auth::user();

        if (!$user->billing()->exists()) {
            return redirect()->route('register.step2')->with('error', 'Please complete billing information first.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:tenants,domain|alpha_dash',
        ]);

        try {
            DB::beginTransaction();

            // Generate unique database name
            $database = strtolower($request->domain);

            // Create tenant record
            Tenant::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'domain' => strtolower($request->domain),
                'database' => $database,
            ]);

            // Clear registration step from session
            session()->forget('registration_step');

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Registration completed successfully! Welcome to your dashboard.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong. Please try again.'])->withInput();
        }
    }


    /**
     * Redirect user to the next appropriate step
     */
    private function redirectToNextStep(User $user)
    {
        if (!$user->billing()->exists()) {
            return redirect()->route('register.step2');
        }

        return redirect()->route('dashboard');
    }
}