<div class="max-w-5xl mx-auto py-12 px-6">
    <!-- Header Section -->
    <div class="text-center mb-12">
        <h1 class="text-5xl font-bold text-gray-800 mb-6">About Us</h1>
        <p class="text-lg text-gray-600">
            Dedicated to quality, committed to excellence.
        </p>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Mission Card -->
        <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-200">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Our Mission</h2>
            <p class="text-gray-700">
                Our mission is to set new benchmarks of quality in every project we undertake. We strive to surpass our clients' expectations through innovation and unwavering integrity.
            </p>
        </div>

        <!-- Vision Card -->
        <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-200">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Our Vision</h2>
            <p class="text-gray-700">
                Our vision is to lead with excellence and to build meaningful, lasting relationships with our clients and the community. We aim to inspire, innovate, and impact.
            </p>
        </div>
    </div>

    <!-- Values Section with Two Per Row -->
    <div class="mt-12 bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-200">
        <h2 class="text-2xl font-semibold text-gray-800 mb-8 text-center">Our Values</h2>
        <div class="flex flex-wrap -mx-4 text-center">
            <!-- Value 1 -->
            <div class="w-full md:w-1/2 px-4 mb-8">
                <div class="flex flex-col items-center">
                    <span class="bg-blue-100 text-blue-600 p-4 rounded-full mb-4">
                        <i class="fas fa-balance-scale fa-2x"></i> <!-- Integrity Icon -->
                    </span>
                    <p class="text-xl font-semibold text-gray-800 mb-2">Integrity</p>
                    <p class="text-gray-700 px-4">We uphold honesty in all our actions.</p>
                </div>
            </div>
            <!-- Value 2 -->
            <div class="w-full md:w-1/2 px-4 mb-8">
                <div class="flex flex-col items-center">
                    <span class="bg-green-100 text-green-600 p-4 rounded-full mb-4">
                        <i class="fas fa-star fa-2x"></i> <!-- Excellence Icon -->
                    </span>
                    <p class="text-xl font-semibold text-gray-800 mb-2">Excellence</p>
                    <p class="text-gray-700 px-4">We strive to exceed expectations.</p>
                </div>
            </div>
            <!-- Value 3 -->
            <div class="w-full md:w-1/2 px-4 mb-8">
                <div class="flex flex-col items-center">
                    <span class="bg-yellow-100 text-yellow-600 p-4 rounded-full mb-4">
                        <i class="fas fa-lightbulb fa-2x"></i> <!-- Innovation Icon -->
                    </span>
                    <p class="text-xl font-semibold text-gray-800 mb-2">Innovation</p>
                    <p class="text-gray-700 px-4">Embracing new ideas.</p>
                </div>
            </div>
            <!-- Value 4 -->
            <div class="w-full md:w-1/2 px-4 mb-8">
                <div class="flex flex-col items-center">
                    <span class="bg-purple-100 text-purple-600 p-4 rounded-full mb-4">
                        <i class="fas fa-users fa-2x"></i> <!-- Community Icon -->
                    </span>
                    <p class="text-xl font-semibold text-gray-800 mb-2">Community</p>
                    <p class="text-gray-700 px-4">Together, we achieve more.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call-to-Action Section -->
    <div class="mt-16 text-center">
        <p class="text-lg text-gray-700">
            Ready to learn more? <a href="{{ route('contact-us') }}" class="text-blue-600 font-medium hover:underline">Contact us</a> today to find out how we can work together.
        </p>
    </div>
</div>

<!-- FontAwesome Icons (include this in your layout head) -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
