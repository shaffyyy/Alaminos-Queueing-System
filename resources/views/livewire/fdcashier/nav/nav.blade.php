<div class="min-h-screen bg-gray-100">
    <div class="flex">
        <!-- Sidebar: Display only for admin (usertype == 1) -->
        @auth
            @if (Auth::user()->usertype == 3)
                <div class="w-64 border-r-2 bg-white shadow-md h-screen">
                    <!-- Sidebar Header -->
                    <div class="p-4 bg-gray-800 text-white">
                        <h5 class="text-lg font-semibold">QMI (Cashier fd)</h5>
                    </div>

                    <!-- Sidebar Navigation Links -->
                    <ul class="mt-4">
                        <li class="px-4 py-2">
                            <x-admin-nav-link href="{{ route('fdcashier-index') }}" :active="request()->routeIs('fdcashier-index')">
                                {{ __('Dashboard') }}
                            </x-admin-nav-link>
                        </li>

                        <!-- Queues Link -->
                        <li class="px-4 py-2">
                            <x-admin-nav-link href="{{ route('fdcashier-queue') }}" :active="request()->routeIs('fdcashier-queue')">
                                {{ __('Queues') }}
                            </x-admin-nav-link>
                        </li>

                        <!-- Windows Dropdown -->
                        {{-- <li class="px-4 py-2" x-data="{ open: false }">
                            <button @click="open = !open" class="w-full font-bold flex justify-between items-center text-gray-700 hover:bg-gray-100 rounded-md transition ease-in-out duration-150">
                                <span>{{ __('Windows') }}</span>
                                <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-cloak class="ml-4 mt-2">
                                <ul class="space-y-2">
                                    <li>
                                        <x-admin-nav-link href="{{ route('admin-windows') }}" :active="request()->routeIs('admin-windows')">
                                            {{ __('Manage Windows') }}
                                        </x-admin-nav-link>
                                    </li>
                                    <li>
                                        <x-admin-nav-link href="{{ route('admin-add-windows') }}" :active="request()->routeIs('admin-add-windows')">
                                            {{ __('Add Windows') }}
                                        </x-admin-nav-link>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}

                        <!-- Accounts Dropdown -->
                        {{-- <li class="px-4 py-2" x-data="{ open: false }">
                            <button @click="open = !open" class="w-full font-bold flex justify-between items-center text-gray-700 hover:bg-gray-100 rounded-md transition ease-in-out duration-150">
                                <span>{{ __('Accounts') }}</span>
                                <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-cloak class="ml-4 mt-2">
                                <ul class="space-y-2">
                                    <li>
                                        <x-admin-nav-link href="{{ route('admin-create-user') }}" :active="request()->routeIs('admin-create-user')">
                                            {{ __('Create User') }}
                                        </x-admin-nav-link>
                                    </li>
                                    <li>
                                        <x-admin-nav-link href="{{ route('admin-manage-user') }}" :active="request()->routeIs('admin-manage-user')">
                                            {{ __('Manage User') }}
                                        </x-admin-nav-link>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}

                        <!-- Services Dropdown -->
                        {{-- <li class="px-4 py-2" x-data="{ open: false }">
                            <button @click="open = !open" class="w-full font-bold flex justify-between items-center text-gray-700 hover:bg-gray-100 rounded-md transition ease-in-out duration-150">
                                <span>{{ __('Services') }}</span>
                                <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-cloak class="ml-4 mt-2">
                                <ul class="space-y-2">
                                    <li>
                                        <x-admin-nav-link href="{{ route('admin-view-services') }}" :active="request()->routeIs('admin-view-services')">
                                            {{ __('View Services') }}
                                        </x-admin-nav-link>
                                    </li>
                                    <li>
                                        <x-admin-nav-link href="{{ route('admin-add-services') }}" :active="request()->routeIs('admin-add-services')">
                                            {{ __('Add New Service') }}
                                        </x-admin-nav-link>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}

                        <li class="px-4 py-2">
                            <x-admin-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                                {{ __('Profile') }}
                            </x-admin-nav-link>
                        </li>
                        <li class="px-4 py-2">
                            <x-admin-nav-link href="{{ route('fdcashier-reports') }}" :active="request()->routeIs('fdcashier-reports')">
                                {{ __('Reports') }}
                            </x-admin-nav-link>
                        </li>
                        <li class="px-4 py-2">
                            <x-admin-nav-link href="{{ route('admin-monitor') }}" :active="request()->routeIs('admin-monitor')">
                                {{ __('Monitor') }}
                            </x-admin-nav-link>
                        </li>
                        <li class="px-4 py-2">
                            <x-admin-nav-link href="{{ route('admin-help') }}" :active="request()->routeIs('admin-help')">
                                {{ __('Help') }}
                            </x-admin-nav-link>
                        </li>
                        <li class="px-4 py-2">
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <button class="font-extrabold flex items-center text-gray-700 hover:bg-gray-100 rounded-md w-full transition ease-in-out duration-150">
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
