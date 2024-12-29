<x-guest-layout>
    <div class="relative bg-cover bg-center min-h-screen flex justify-center items-center p-5" style="background-image: url('{{ asset('/assets/bg/lgualaminos.jpg') }}');">
        <!-- Dark overlay -->
        <div class="absolute top-0 left-0 w-full h-full bg-black opacity-50 z-1"></div>

        <div class="bg-white bg-opacity-80 flex flex-col md:flex-row w-full max-w-4xl rounded-lg overflow-hidden shadow-lg gap-5 relative z-2">
            <!-- Left Column: Registration Form -->
            <div class="flex-1 p-10 min-w-0">
                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>

                    <div class="mt-4">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-label for="terms">
                                <div class="flex items-center">
                                    <x-checkbox name="terms" id="terms" required />
                                    <div class="ms-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-label>
                        </div>
                    @endif

                    <div class="flex items-center justify-between mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-button>
                            {{ __('Register') }}
                        </x-button>
                    </div>
                </form>
            </div>

            <!-- Right Column: Logo and Welcome Message -->
            <div class="flex-1 bg-white flex flex-col justify-center items-center p-10 text-center min-w-0">
                <x-authentication-card-logo />
                <h2 class="mt-5 text-3xl md:text-4xl font-bold text-black">Welcome to QMI</h2>
                <p class="mt-3 text-xl text-black">Queue Management System for LGU Alaminos</p>
                <p class="mt-5 text-sm sm:text-base text-gray-600">Join us to experience an efficient and seamless queuing system.</p>
            </div>
        </div>
    </div>
</x-guest-layout>
