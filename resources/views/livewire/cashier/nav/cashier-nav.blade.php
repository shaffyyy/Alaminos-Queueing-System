<div class="min-h-screen bg-gray-100">
    <div class="flex">
        <!-- Sidebar: Display only for admin (usertype == 1) -->
        @auth
            @if (Auth::user()->usertype == 2)
                <div class="w-64 border-r-2 bg-white shadow-md h-screen">
                    <!-- Sidebar Header -->
                    <div class="p-4 bg-gray-800 text-white">
                        <h5 class="text-lg font-semibold">QMI (Cashier)</h5>
                    </div>

                    <!-- Sidebar Navigation Links -->
                    <ul class="mt-4 space-y-4">
                        <li class="px-4 py-2 flex items-center">
                            <i class="fas fa-tachometer-alt text-gray-700 mr-3"></i>
                            <x-admin-nav-link href="{{ route('cashier-index') }}" :active="request()->routeIs('cashier-index')">
                                {{ __('Dashboard') }}
                            </x-admin-nav-link>
                        </li>

                        <!-- Queues Link -->
                        <li class="px-4 py-2 flex items-center">
                            <i class="fas fa-list text-gray-700 mr-3"></i>
                            <x-admin-nav-link href="{{ route('cashier-queue') }}" :active="request()->routeIs('cashier-queue')">
                                {{ __('Queues') }}
                            </x-admin-nav-link>
                        </li>

                        <!-- Reports Link -->
                        <li class="px-4 py-2 flex items-center">
                            <i class="fas fa-chart-bar text-gray-700 mr-3"></i>
                            <x-admin-nav-link href="{{ route('cashier-reports') }}" :active="request()->routeIs('cashier-reports')">
                                {{ __('Reports') }}
                            </x-admin-nav-link>
                        </li>

                        <!-- Profile Link -->
                        <li class="px-4 py-2 flex items-center">
                            <i class="fas fa-user text-gray-700 mr-3"></i>
                            <x-admin-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                                {{ __('Profile') }}
                            </x-admin-nav-link>
                        </li>

                        <!-- Logout -->
                        <li class="px-4 py-2 flex items-center">
                            <i class="fas fa-sign-out-alt text-gray-700 mr-3"></i>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <button type="submit" class="font-extrabold flex items-center text-gray-700 hover:bg-gray-100 rounded-md w-full transition ease-in-out duration-150">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endif
        @endauth
    </div>
</div>

<!-- Include Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
