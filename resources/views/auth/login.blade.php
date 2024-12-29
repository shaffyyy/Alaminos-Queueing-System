<x-guest-layout>
    <div class="relative bg-cover bg-center min-h-screen flex justify-center items-center p-5" style="background-image: url('{{ asset('/assets/bg/lgualaminos.jpg') }}');">
        <!-- Dark overlay -->
        <div class="absolute top-0 left-0 w-full h-full bg-black opacity-50 z-1"></div>

        <div class="bg-white bg-opacity-80 flex flex-col md:flex-row w-full max-w-4xl rounded-lg overflow-hidden shadow-lg gap-5 relative z-2">
            <!-- Left Column: Login Form -->
            <div class="flex-1 p-10 min-w-0">
                <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-button>
                            {{ __('Log in') }}
                        </x-button>
                    </div>

                    <div class="mt-4 text-center">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                            {{ __('Sign Up Here!') }}
                        </a>
                    </div>
                </form>
            </div>

            <!-- Right Column: Logo and Welcome Message -->
            <div class="flex-1 bg-white flex flex-col justify-center items-center p-10 text-center min-w-0">
                <x-authentication-card-logo />
                <h2 class="mt-5 text-3xl md:text-4xl font-bold text-black">Welcome to QMI</h2>
                <p class="mt-3 text-xl text-black">Queue Management System for LGU Alaminos</p>
            </div>
        </div>
    </div>
</x-guest-layout>
