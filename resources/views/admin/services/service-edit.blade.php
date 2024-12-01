<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Service
            </h1>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Success Message -->
                @if (session()->has('success'))
                    <div class="bg-green-100 text-green-800 p-3 rounded-md mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Edit Service Form -->
                <form id="editServiceForm" action="{{ route('admin-update-service', $service->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block font-bold">Service Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}" class="w-full border p-2 rounded-md" required>
                        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block font-bold">Description</label>
                        <textarea name="description" id="description" class="w-full border p-2 rounded-md">{{ old('description', $service->description) }}</textarea>
                        @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin-view-services') }}" class="mr-4 bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</a>
                        <button type="button" onclick="confirmSubmit()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update Service</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function confirmSubmit() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update this service?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    document.getElementById('editServiceForm').submit();
                }
            });
        }
    </script>
</x-app-layout>
