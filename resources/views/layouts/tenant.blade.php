<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $tenant->name ?? 'Tenant App')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/tenant.css') }}">
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <a href="{{ route('tenant.home', ['tenant' => $tenant->domain?? $tenant->id]) }}" class="text-xl font-bold text-gray-800">
                                {{ $tenant->name ?? 'Tenant App' }}
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('tenant.home', ['tenant' => $tenant->domain?? $tenant->id]) }}" 
                               class="@if(request()->routeIs('tenant.home')) border-indigo-500 text-gray-900 @else border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 @endif inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Home
                            </a>
                            
                            @auth('tenant')
                                <a href="{{ route('tenant.dashboard', ['tenant' => $tenant->domain?? $tenant->id]) }}" 
                                   class="@if(request()->routeIs('tenant.dashboard')) border-indigo-500 text-gray-900 @else border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 @endif inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Dashboard
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Right side -->
                    <div class="flex items-center space-x-4">
                        @auth('tenant')
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-700">{{ auth('tenant')->user()->name }}</span>
                                <form method="POST" action="{{ route('tenant.logout', ['tenant' => $tenant->domain?? $tenant->id]) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('tenant.login', ['tenant' => $tenant->domain?? $tenant->id]) }}" class="text-sm text-gray-500 hover:text-gray-700">Login</a>
                            <a href="{{ route('tenant.register', ['tenant' => $tenant->domain?? $tenant->id]) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-16">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        © {{ date('Y') }} {{ $tenant->name ?? 'Tenant App' }}. All rights reserved.
                    </div>
                    <div class="flex space-x-6">
                        <a href="{{ route('tenant.privacy.policy', ['tenant' => $tenant->domain?? $tenant->id]) }}" class="text-sm text-gray-500 hover:text-gray-700">
                            Privacy Policy
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- Custom JavaScript -->
    <script src="{{ asset('js/tenant.js') }}"></script>
</body>
</html>