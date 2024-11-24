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
                <form action="{{ route('admin-update-service', $service->id) }}" method="POST">
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

                    {{-- <div class="mb-4">
                        <label for="status" class="block font-bold">Status</label>
                        <select name="status" id="status" class="w-full border p-2 rounded-md">
                            <option value="1" {{ $service->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$service->status ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div> --}}

                    <div class="flex justify-end">
                        <a href="{{ route('admin-view-services') }}" class="mr-4 bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</a>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update Service</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
