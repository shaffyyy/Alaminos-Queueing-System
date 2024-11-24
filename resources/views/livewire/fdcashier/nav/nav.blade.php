<div class="min-h-screen bg-gray-100">
    <div class="flex">
        <!-- Sidebar: Display only for admin (usertype == 1) -->
        @auth
            @if (Auth::user()->usertype == 3)
                <div class="w-64 border-r-2 bg-white shadow-md h-screen">
                    <!-- Sidebar Header -->
                    <div class="p-4 bg-gray-800 text-white">
                        <h5 class="text-lg font-semibold">QMI (Front Desk)</h5>
                    </div>

                    <!-- Sidebar Navigation Links -->
                    <ul class="mt-4">
                        <li class="px-4 py-2">
                            <x-admin-nav-link href="{{ route('fdcashier-index') }}" :active="request()->routeIs('fdcashier-index')">
                                <i class="fas fa-tachometer-alt mr-2"></i> {{ __('Dashboard') }}
                            </x-admin-nav-link>
                        </li>

                        <!-- Queues Link -->
                        <li class="px-4 py-2">
                            <x-admin-nav-link href="{{ route('fdcashier-queue') }}" :active="request()->routeIs('fdcashier-queue')">
                                <i class="fas fa-list-ul mr-2"></i> {{ __('Queues') }}
                            </x-admin-nav-link>
                        </li>
                        
                        <li class="px-4 py-2">
                            <x-admin-nav-link href="{{ route('fdcashier-walkin') }}" :active="request()->routeIs('fdcashier-walkin')">
                                <i class="fas fa-user-friends mr-2"></i> {{ __('Walk In Queue') }}
                            </x-admin-nav-link>
                        </li>
                        
                        <li class="px-4 py-2">
                            <x-admin-nav-link href="{{ route('fdcashier-accounts') }}" :active="request()->routeIs('fdcashier-accounts')">
                                <i class="fas fa-user-circle mr-2"></i> {{ __('Accounts') }}
                            </x-admin-nav-link>
                        </li>

                        <li class="px-4 py-2">
                            <x-admin-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                                <i class="fas fa-user mr-2"></i> {{ __('Profile') }}
                            </x-admin-nav-link>
                        </li>
                        
                        <li class="px-4 py-2">
                            <x-admin-nav-link href="{{ route('fdcashier-reports') }}" :active="request()->routeIs('fdcashier-reports')">
                                <i class="fas fa-file-alt mr-2"></i> {{ __('Reports') }}
                            </x-admin-nav-link>
                        </li>
                        
                        <li class="px-4 py-2">
                            <x-admin-nav-link href="{{ route('admin-monitor') }}" :active="request()->routeIs('admin-monitor')">
                                <i class="fas fa-desktop mr-2"></i> {{ __('Monitor') }}
                            </x-admin-nav-link>
                        </li>
                        
                        <li class="px-4 py-2">
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <button class="font-extrabold flex items-center text-gray-700 hover:bg-gray-100 rounded-md w-full transition ease-in-out duration-150">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
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
