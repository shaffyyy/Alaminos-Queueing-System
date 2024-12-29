<div>
    <!-- Hero Section -->
    <div class="relative min-h-screen flex flex-col justify-center items-center text-white" 
        style="background-image: url('{{ asset('/assets/bg/lgualaminos.jpg') }}'); background-size: cover; background-position: center;">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-6xl">Welcome to QMI Alaminos City Queueing System</h1>
            <p class="mt-4 max-w-xl mx-auto text-lg">
                Efficient, Hassle-Free Queue Management. Experience a smoother and more organized way of managing your time with QMI Alaminos City’s queueing system.
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
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Key Features</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <!-- Feature 1 -->
            <div class="p-6 bg-blue-100 rounded-lg shadow-md">
                <div class="flex justify-center mb-4">
                    <span class="text-blue-600 text-4xl">
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
                        <i class="fas fa-desktop"></i> <!-- FontAwesome Desktop Icon -->
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

    <!-- How It Works Section -->
    <div class="max-w-7xl my-2 mx-auto py-12 px-6 lg:px-8 bg-gray-50">
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">How It Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <!-- Step 1 -->
            <div class="p-6 bg-sky-200 rounded-lg shadow-md">
                <div class="text-4xl text-sky-600 mb-4">
                    <i class="fas fa-user-plus"></i> <!-- FontAwesome User Plus Icon -->
                </div>
                <h3 class="font-semibold text-lg text-sky-700">Register/Login</h3>
                <p class="text-gray-700 mt-2">
                    Sign up or log in to access your account.
                </p>
            </div>
            <!-- Step 2 -->
            <div class="p-6 bg-teal-100 rounded-lg shadow-md">
                <div class="text-4xl text-teal-600 mb-4">
                    <i class="fas fa-tasks"></i> <!-- FontAwesome Tasks Icon -->
                </div>
                <h3 class="font-semibold text-lg text-teal-700">Choose Your Service</h3>
                <p class="text-gray-700 mt-2">
                    Select the type of service you need.
                </p>
            </div>
            <!-- Step 3 -->
            <div class="p-6 bg-orange-100 rounded-lg shadow-md">
                <div class="text-4xl text-orange-600 mb-4">
                    <i class="fas fa-ticket-alt"></i> <!-- FontAwesome Ticket Icon -->
                </div>
                <h3 class="font-semibold text-lg text-orange-700">Get Your Queue Number</h3>
                <p class="text-gray-700 mt-2">
                    Instantly receive your queue ticket.
                </p>
            </div>
            <!-- Step 4 -->
            <div class="p-6 bg-red-100 rounded-lg shadow-md">
                <div class="text-4xl text-red-600 mb-4">
                    <i class="fas fa-chart-line"></i> <!-- FontAwesome Line Chart Icon -->
                </div>
                <h3 class="font-semibold text-lg text-red-700">Track Your Progress</h3>
                <p class="text-gray-700 mt-2">
                    Stay updated on your queue status.
                </p>
            </div>
        </div>
    </div>

     <!-- Benefits Section -->
     <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Benefits of Using Our Queueing System</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <!-- Benefit 1 -->
                <div class="bg-blue-100 p-8 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                    <div class="flex justify-center mb-4 text-4xl text-blue-600">
                        <i class="fas fa-clock"></i> <!-- FontAwesome Clock Icon -->
                    </div>
                    <h3 class="text-xl font-semibold text-center mb-4 text-gray-800">No More Long Lines</h3>
                    <p class="text-gray-600 text-center">
                        Save yourself the stress of waiting in physical queues with our digital solution.
                    </p>
                </div>
                <!-- Benefit 2 -->
                <div class="bg-green-100 p-8 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                    <div class="flex justify-center mb-4 text-4xl text-green-600">
                        <i class="fas fa-calendar-check"></i> <!-- FontAwesome Calendar Check Icon -->
                    </div>
                    <h3 class="text-xl font-semibold text-center mb-4 text-gray-800">Better Time Management</h3>
                    <p class="text-gray-600 text-center">
                        Plan your day better with accurate queue time estimates and minimal wait times.
                    </p>
                </div>
                <!-- Benefit 3 -->
                <div class="bg-yellow-100 p-8 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                    <div class="flex justify-center mb-4 text-4xl text-yellow-600">
                        <i class="fas fa-thumbs-up"></i> <!-- FontAwesome Thumbs Up Icon -->
                    </div>
                    <h3 class="text-xl font-semibold text-center mb-4 text-gray-800">Improved Customer Experience</h3>
                    <p class="text-gray-600 text-center">
                        A streamlined process ensures fast and reliable service delivery for every user.
                    </p>
                </div>
                <!-- Benefit 4 -->
                <div class="bg-purple-100 p-8 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                    <div class="flex justify-center mb-4 text-4xl text-purple-600">
                        <i class="fas fa-wheelchair"></i> <!-- FontAwesome Wheelchair Icon -->
                    </div>
                    <h3 class="text-xl font-semibold text-center mb-4 text-gray-800">Accessibility for All</h3>
                    <p class="text-gray-600 text-center">
                        Our system is designed to be simple and accessible for everyone, including seniors and first-time users.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
</div>
