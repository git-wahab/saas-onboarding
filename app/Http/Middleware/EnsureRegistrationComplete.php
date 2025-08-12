<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRegistrationComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Skip registration requirements for admin and super-admin users
            if ($user->isAdmin() || $user->isSuperAdmin()) {
                return $next($request);
            }
            
            // Check if registration is complete for regular users
            if (!$user->hasCompletedRegistration()) {
                // Determine which step to redirect to
                if (!$user->billing()->exists()) {
                    return redirect()->route('register.step2')
                        ->with('warning', 'Please complete your billing information to continue.');
                }
                
                if (!$user->tenant()->exists()) {
                    return redirect()->route('register.step3')
                        ->with('warning', 'Please complete your workspace setup to continue.');
                }
            }
        }

        return $next($request);
    }
}
