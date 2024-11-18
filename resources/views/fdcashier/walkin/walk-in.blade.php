<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Walk-in Form
            </h1>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('fdcashier-walkin-store') }}" method="POST">
                    @csrf

                    <!-- User Selection -->
                    <div class="mb-4">
                        <label for="user_id" class="block text-gray-700 font-bold mb-2">Select User</label>
                        <select name="user_id" id="user_id" class="w-full border-gray-300 rounded-lg p-2 shadow-sm" required>
                            <option value="">Select a User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->usertype == 4 ? 'PWD' : 'User' }})</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Service Selection -->
                    <div class="mb-4">
                        <label for="service_id" class="block text-gray-700 font-bold mb-2">Select Service</label>
                        <select name="service_id" id="service_id" class="w-full border-gray-300 rounded-lg p-2 shadow-sm" required>
                            <option value="">Select a Service</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" data-initials="{{ strtoupper(substr($service->name, 0, 2)) }}">
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Display Queue Number -->
                    <div id="queue-number-container" class="mb-4 hidden">
                        <label class="block text-gray-700 font-bold mb-2">Queue Number</label>
                        <div id="queue-number" class="w-full p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                            <!-- Queue number will be displayed here -->
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('fdcashier-walkin') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">Cancel</a>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">Assign Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Select2 and jQuery -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize Select2 for user selection
            $('#user_id').select2({
                placeholder: 'Search for a user',
                allowClear: true
            });

            // Calculate and display queue number when service is selected
            $('#service_id').on('change', function () {
                const selectedService = $(this).find('option:selected');
                const serviceInitials = selectedService.data('initials');
                const randomNumber = Math.floor(100 + Math.random() * 900); // Generate a random 3-digit number
                
                if (serviceInitials) {
                    const queueNumber = `${serviceInitials}${randomNumber}`;
                    $('#queue-number').text(queueNumber);
                    $('#queue-number-container').removeClass('hidden');
                } else {
                    $('#queue-number').text('');
                    $('#queue-number-container').addClass('hidden');
                }
            });
        });
    </script>
</x-app-layout>
