<div class="max-w-5xl mx-auto py-12 px-6">
    <!-- Contact Us Header -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Contact Us</h1>
        <p class="text-gray-600 text-lg">We’d love to hear from you! Fill out the form below or reach out directly.</p>
    </div>

    <!-- Contact Form -->
    <div class="bg-white p-8 rounded-lg shadow-lg mb-10">
        <form wire:submit.prevent="submitContactForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-user text-blue-500"></i> Name
                    </label>
                    <input type="text" wire:model="name" id="name" class="w-full border border-gray-300 rounded-lg p-3 pl-10" placeholder="Your Name">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-envelope text-blue-500"></i> Email
                    </label>
                    <input type="email" wire:model="email" id="email" class="w-full border border-gray-300 rounded-lg p-3 pl-10" placeholder="Your Email">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Subject Input -->
            <div class="mb-6">
                <label for="subject" class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-tag text-blue-500"></i> Subject
                </label>
                <input type="text" wire:model="subject" id="subject" class="w-full border border-gray-300 rounded-lg p-3 pl-10" placeholder="Subject">
                @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Message Input -->
            <div class="mb-8">
                <label for="message" class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-comment-dots text-blue-500"></i> Message
                </label>
                <textarea wire:model="message" id="message" class="w-full border border-gray-300 rounded-lg p-3 pl-10" rows="5" placeholder="Your Message"></textarea>
                @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-200 shadow-lg transform hover:scale-105">
                Send Message
            </button>
        </form>
    </div>

    <!-- Contact Information Section -->
    <div class="mt-12 bg-gray-100 p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Contact Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex items-center space-x-4">
                <i class="fas fa-phone-alt text-blue-500 text-2xl"></i>
                <div>
                    <span class="text-gray-700 font-semibold">Phone:</span>
                    <p class="text-gray-600">+63 916 4566 244</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <i class="fas fa-envelope text-blue-500 text-2xl"></i>
                <div>
                    <span class="text-gray-700 font-semibold">Email:</span>
                    <p class="text-gray-600">lattolatto0415@gmail.com</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <i class="fas fa-map-marker-alt text-blue-500 text-2xl"></i>
                <div>
                    <span class="text-gray-700 font-semibold">Address:</span>
                    <p class="text-gray-600">Alminos City, Pangasinan , Philippines</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <i class="fas fa-clock text-blue-500 text-2xl"></i>
                <div>
                    <span class="text-gray-700 font-semibold">Hours:</span>
                    <p class="text-gray-600">Mon - Fri, 8 AM - 4 PM</p>
                </div>
            </div>
        </div>
    </div>
</div>
