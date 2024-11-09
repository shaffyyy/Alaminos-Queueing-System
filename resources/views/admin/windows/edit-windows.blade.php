<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Window
            </h1>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Edit Window</h2>

                <form id="edit-window-form" action="{{ route('admin-update-window', $window->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block font-bold">Window Name</label>
                        <input type="text" name="name" id="name" value="{{ $window->name }}" class="w-full border p-2 rounded-md" required>
                        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="service_id" class="block font-bold">Service</label>
                        <select name="service_id" id="service_id" class="w-full border p-2 rounded-md" required>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ $window->service_id == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Cashier Selection -->
                    <div class="mb-4">
                        <label for="cashier_id" class="block font-bold">Assign Cashier</label>
                        <select name="cashier_id" id="cashier_id" class="w-full border p-2 rounded-md">
                            <option value="">Select a Cashier</option>
                            @foreach($cashiers as $cashier)
                                <option value="{{ $cashier->id }}" {{ $window->cashier_id == $cashier->id ? 'selected' : '' }}>
                                    {{ $cashier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('cashier_id') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <!-- Back Button -->
                        <a href="{{ route('admin-windows') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                            Back
                        </a>

                        <!-- Update Button -->
                        <button type="button" onclick="confirmUpdate()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                            Update Window
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmUpdate() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update this window?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('edit-window-form').submit();
                }
            });
        }
    </script>
</x-app-layout>
