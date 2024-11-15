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
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
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
</x-app-layout>
