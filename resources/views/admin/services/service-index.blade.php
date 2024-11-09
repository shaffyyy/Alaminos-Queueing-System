<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Monitor - Services List
            </h1>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div>
                    <h1 class="text-2xl font-bold mb-4">Services List</h1>

                    <!-- Success Message -->
                    @if (session()->has('message'))
                        <div class="bg-green-100 text-green-800 p-3 rounded-md mb-4">
                            {{ session('message') }}
                        </div>
                    @endif

                    <!-- Add New Service Button -->
                    <a href="{{ route('admin-add-services') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4 inline-block">Add New Service</a>

                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border">Name</th>
                                <th class="py-2 px-4 border">Description</th>
                                <th class="py-2 px-4 border">Status</th>
                                <th class="py-2 px-4 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td class="py-2 px-4 border">{{ $service->name }}</td>
                                    <td class="py-2 px-4 border">{{ $service->description }}</td>
                                    <td class="py-2 px-4 border">
                                        {{ $service->status ? 'Active' : 'Inactive' }}
                                    </td>
                                    <td class="py-2 px-4 border">
                                        <a href="{{ route('admin-edit-service', $service->id) }}" class="text-blue-500 hover:underline">Edit</a> |
                                        <button wire:click="deleteService({{ $service->id }})" class="text-red-500">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modals -->
                    {{-- Uncomment the Livewire modals if necessary --}}
                    {{-- @livewire('admin.services.service-create') --}}
                    {{-- @livewire('admin.services.service-edit') --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
