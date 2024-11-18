<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QMI - Alaminos City Hall Queuing System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    {{-- icons fa --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


    <!-- Styles -->
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="antialiased bg-gray-100">
    <!-- Navbar Section -->
    <x-navbar>
        <x-slot name="logo">
            <a href="{{ route('home') }}">
                <x-application-mark class="block h-9 w-auto" />
            </a>
        </x-slot>
        @if (Route::has('login'))
            <div class="space-x-4">
                @auth
                    <x-nav-link href="{{ url('/home') }}" :active="request()->routeIs('home')">
                        Dashboard
                    </x-nav-link>
                @else
                    <x-nav-link href="{{ route('login') }}">Log in</x-nav-link>
                    @if (Route::has('register'))
                        <x-nav-link href="{{ route('register') }}" class="ml-4">Register</x-nav-link>
                    @endif
                @endauth
            </div>
        @endif
    </x-navbar>

    <!-- Hero Section -->
    <div class="relative min-h-screen flex flex-col justify-center items-center bg-gradient-to-r from-blue-500 to-teal-500 text-white">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-6xl">Welcome to QMI</h1>
            <p class="mt-4 max-w-xl mx-auto text-lg">
                Streamline your services with the Queuing Management System for Alaminos City Hall.
            </p>
            <div class="mt-8 space-x-4">
                @auth
                    <!-- Authenticated users -->
                    <a href="{{ route('get-in-queue') }}">
                        <x-button color="white">Get in Line</x-button>
                    </a>
                    
                @else
                    <!-- Guests -->
                    <a href="{{ route('login') }}">
                        <x-button color="white">Log in to Get in Line</x-button>
                    </a>
                
                @endauth
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto py-16 px-6 lg:px-8 bg-white my-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <x-feature-card title="Efficient Queuing" icon="clock" color="blue">
                Manage waiting times effectively with real-time queuing updates.
            </x-feature-card>

            <!-- Feature 2 -->
            <x-feature-card title="User-Friendly Interface" icon="desktop-computer" color="green">
                An intuitive system designed for quick navigation and ease of use for all.
            </x-feature-card>

            <!-- Feature 3 -->
            <x-feature-card title="Multiple Services" icon="server" color="yellow">
                Access various city services, from document requests to business permits.
            </x-feature-card>
        </div>
    </div>

    <!-- About Us Section -->
    <div class="bg-white py-20 px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-12">About QMI</h2>
            <p class="text-center text-gray-600 text-lg mb-12">
                QMI (Queuing Management System) transforms service delivery at Alaminos City Hall, ensuring seamless and accessible experiences for all citizens.
            </p>

            <div class="space-y-12">
                <!-- Card 1 -->
                <div class="flex flex-col md:flex-row items-center">
                    <div class="w-1/2 bg-gray-100 shadow-xl p-8 flex rounded-lg items-center justify-center transition transform hover:scale-105">
                        <div class="w-40 h-40 flex items-center justify-center bg-blue-500 text-white rounded-full">
                            <i class="fas fa-clock text-6xl"></i>
                        </div>
                    </div>
                    <div class="w-1/2 p-8 text-left">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Efficiency</h3>
                        <p class="text-gray-600 text-lg">
                            Streamline city hall operations to deliver faster and more effective services to all citizens.
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="flex flex-col md:flex-row items-center">

                    <div class="w-1/2 p-8 text-left">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Accessibility</h3>
                        <p class="text-gray-600 text-lg">
                            Designed to serve everyone, with a focus on priority services for PWD and senior citizens.
                        </p>
                    </div>
                    <div class="w-1/2 bg-gray-100 shadow-xl p-8 flex rounded-lg items-center justify-center transition transform hover:scale-105">
                        <div class="w-40 h-40 flex items-center justify-center bg-green-500 text-white rounded-full">
                            <i class="fas fa-users text-6xl"></i>
                        </div>
                    </div>
                
                </div>

                <!-- Card 3 -->
                <div class="flex flex-col md:flex-row items-center">
                    <div class="w-1/2 bg-gray-100 shadow-xl p-8 flex rounded-lg items-center justify-center transition transform hover:scale-105">
                        <div class="w-40 h-40 flex items-center justify-center bg-yellow-500 text-white rounded-full">
                            <i class="fas fa-bolt text-6xl"></i>
                        </div>
                    </div>
                    <div class="w-1/2 p-8 text-left">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Innovation</h3>
                        <p class="text-gray-600 text-lg">
                            Utilizes cutting-edge technology to provide modern, fast, and reliable public services.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- Footer Section -->
    <x-footer>
        <div class="max-w-7xl mx-auto text-center text-white">
            <p>QMI - Alaminos City Hall Queuing System</p>
            <p>Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
        </div>
    </x-footer>

    @livewireScripts
    @vite('resources/js/app.js')
</body>
</html>
