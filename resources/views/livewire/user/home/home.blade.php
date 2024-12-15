<div>
    <!-- Hero Section -->
    <div class="relative min-h-screen flex flex-col justify-center items-center text-white" 
        style="background-image: url('{{ asset('/assets/bg/lgualaminos.jpg') }}'); background-size: cover; background-position: center;">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-6xl">Welcome to QMI</h1>
            <p class="mt-4 max-w-xl mx-auto text-lg">
                Streamline your services with the Queuing Management System for Alaminos City Hall.
            </p>
            <div class="mt-8 space-x-4">
                <a href="{{ route('get-in-queue') }}" class="inline-block">
                    <button class="px-6 py-3 bg-white text-sky-800 font-semibold rounded-lg hover:bg-gray-200 transition duration-300">
                        Get in Line
                    </button>
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto py-16 px-6 lg:px-8 bg-white my-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <!-- Feature 1 -->
            <div class="p-6 bg-sky-100 rounded-lg shadow-md">
                <div class="flex justify-center mb-4">
                    <span class="text-sky-600 text-4xl">
                        <i class="fas fa-clock"></i> <!-- FontAwesome Clock Icon -->
                    </span>
                </div>
                <h3 class="text-xl font-bold mb-2">Efficient Queuing</h3>
                <p class="text-gray-700">
                    Manage waiting times effectively with real-time queuing updates.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="p-6 bg-green-100 rounded-lg shadow-md">
                <div class="flex justify-center mb-4">
                    <span class="text-green-600 text-4xl">
                        <i class="fas fa-desktop"></i> <!-- FontAwesome Desktop Computer Icon -->
                    </span>
                </div>
                <h3 class="text-xl font-bold mb-2">User-Friendly Interface</h3>
                <p class="text-gray-700">
                    An intuitive system designed for quick navigation and ease of use for all.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="p-6 bg-yellow-100 rounded-lg shadow-md">
                <div class="flex justify-center mb-4">
                    <span class="text-yellow-600 text-4xl">
                        <i class="fas fa-server"></i> <!-- FontAwesome Server Icon -->
                    </span>
                </div>
                <h3 class="text-xl font-bold mb-2">Multiple Services</h3>
                <p class="text-gray-700">
                    Access various city services, from document requests to business permits.
                </p>
            </div>
        </div>
    </div>
</div>
