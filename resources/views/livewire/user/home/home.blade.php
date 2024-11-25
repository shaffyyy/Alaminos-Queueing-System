<div>
    <!-- Hero Section -->
    <div class="relative min-h-screen flex flex-col justify-center items-center bg-gradient-to-r from-blue-500 to-teal-500 text-white">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-6xl">Welcome to QMI</h1>
            <p class="mt-4 max-w-xl mx-auto text-lg">
                Streamline your services with the Queuing Management System for Alaminos City Hall.
            </p>
            <div class="mt-8 space-x-4">
                <a href="{{ route('get-in-queue') }}">
                    <x-button color="white">Get in Line</x-button>
                </a>
                

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
</div>
