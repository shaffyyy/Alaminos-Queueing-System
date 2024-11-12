<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Qmi') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen flex flex-col">
            @if(Auth::user()->usertype == 1)
                <!-- Admin Layout with Sidebar -->
                <div class="flex h-screen">
                    <div class="w-64 bg-gray-800 text-white fixed h-screen overflow-y-auto">
                        @livewire('admin-nav') <!-- Admin Sidebar -->
                    </div>

                    <div class="flex-1 ml-64">
                        <!-- Page Heading -->
                        @if (isset($header))
                            <header class="bg-white shadow">
                                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                    {{ $header }}
                                </div>
                            </header>
                        @endif

                        <!-- Page Content -->
                        <main class="p-4 flex-1">
                            {{ $slot }}
                        </main>
                    </div>
                </div>

            @elseif(Auth::user()->usertype == 2)
                <!-- Cashier Layout with Cashier Sidebar -->
                <div class="flex h-screen">
                    <div class="w-64 bg-gray-800 text-white fixed h-screen overflow-y-auto">
                        @livewire('cashier.nav.cashier-nav') <!-- Cashier Sidebar -->
                    </div>

                    <div class="flex-1 ml-64">
                        <!-- Page Heading -->
                        @if (isset($header))
                            <header class="bg-white shadow">
                                <div class="max-w-7xl mx-auto py-4 px-2 sm:px-6 lg:px-8">
                                    {{ $header }}
                                </div>
                            </header>
                        @endif

                        <!-- Page Content -->
                        <main class="p-4 flex-1">
                            {{ $slot }}
                        </main>
                    </div>
                </div>

            @elseif(Auth::user()->usertype == 3)
                <!-- FDCashier Layout with FDCashier Sidebar -->
                <div class="flex h-screen">
                    <div class="w-64 bg-gray-800 text-white fixed h-screen overflow-y-auto">
                        @livewire('fdcashier.nav.nav') <!-- FDCashier Sidebar -->
                    </div>

                    <div class="flex-1 ml-64">
                        <!-- Page Heading -->
                        @if (isset($header))
                            <header class="bg-white shadow">
                                <div class="max-w-7xl mx-auto py-4 px-2 sm:px-6 lg:px-8">
                                    {{ $header }}
                                </div>
                            </header>
                        @endif

                        <!-- Page Content -->
                        <main class="p-4 flex-1">
                            {{ $slot }}
                        </main>
                    </div>
                </div>

            @else
                <!-- Regular User Layout without Sidebar -->
                <div class="flex flex-col h-screen">
                    @livewire('navigation-menu') <!-- User Navigation -->

                    <!-- Page Heading -->
                    @if (isset($header))
                        <header class="bg-white shadow">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endif

                    <!-- Page Content -->
                    <main class="flex-1">
                        {{ $slot }}
                    </main>

                    <!-- Footer -->
                    @auth
                        @if (Auth::user()->usertype == 0)
                            @livewire('footer')
                        @endif
                    @endauth
                </div>
            @endif

            @stack('modals')
        </div>

        @livewireScripts
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        
    </body>
</html>
