<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Monitor - Add New Service
            </h1>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div>
                    <h1 class="text-2xl font-bold mb-4">Add New Service</h1>

                    <!-- Success Message -->
                    @if (session()->has('message'))
                        <div class="bg-green-100 text-green-800 p-3 rounded-md mb-4">
                            {{ session('message') }}
                        </div>
                    @endif

                    <!-- Add Service Form -->
                    <form action="{{ route('admin-store-services') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block font-bold">Service Name</label>
                            <input type="text" name="name" id="name" class="w-full border p-2" required>
                            @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block font-bold">Description</label>
                            <textarea name="description" id="description" class="w-full border p-2"></textarea>
                            @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Service</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
