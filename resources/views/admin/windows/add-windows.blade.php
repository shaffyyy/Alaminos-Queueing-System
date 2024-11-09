<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Add New Window
            </h1>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <h2 class="text-2xl font-semibold mb-4">Create a New Window</h2>

                <!-- New Window Form -->
                <form action="{{ route('admin.store-window') }}" method="POST">
                    @csrf

                    <!-- Window Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Window Name</label>
                        <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <!-- Service Selection -->
                    <div class="mb-4">
                        <label for="service_id" class="block text-gray-700">Assign Service</label>
                        <select name="service_id" id="service_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select a Service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Cashier Selection -->
                    <div class="mb-4">
                        <label for="cashier_id" class="block text-gray-700">Assign Cashier</label>
                        <select name="cashier_id" id="cashier_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select a Cashier</option>
                            @foreach($cashiers as $cashier)
                                <option value="{{ $cashier->id }}">{{ $cashier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-between items-center mt-4">
                        <!-- Back Button -->
                        <a href="{{ route('admin-windows') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                            Back
                        </a>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                            Add Window
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
