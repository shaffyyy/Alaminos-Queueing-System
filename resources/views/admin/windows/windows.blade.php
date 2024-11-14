<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Windows
            </h1>
        </div>
    </x-slot>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-700">List of Windows</h2>
                    <a href="{{ route('admin-add-windows') }}" 
                       class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                        Add New Window
                    </a>
                </div>

                <!-- Check if there are any windows to display -->
                @if($windows->isEmpty())
                    <div class="text-center text-gray-500 py-8">
                        <p>No windows available.</p>
                    </div>
                @else
                    <!-- Windows Table -->
                    <div class="overflow-x-auto bg-gray-50 rounded-lg shadow-lg">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead class="bg-gray-600 text-white">
                                <tr>
                                    <th class="py-3 px-4 text-left font-medium">Window ID</th>
                                    <th class="py-3 px-4 text-left font-medium">Name</th>
                                    <th class="py-3 px-4 text-center font-medium">Services</th>
                                    <th class="py-3 px-4 text-left font-medium">Cashier</th>
                                    <th class="py-3 px-4 text-left font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($windows as $window)
                                    <tr class="{{ $loop->even ? 'bg-gray-200' : 'bg-gray-100' }} hover:bg-gray-300 transition duration-200">
                                        <td class="py-3 px-4 text-gray-700 font-semibold">{{ $window->id }}</td>
                                        <td class="py-3 px-4 text-gray-700">{{ $window->name }}</td>
                                        <td class="py-3 px-4 text-center text-gray-600">
                                            @if($window->services->isNotEmpty())
                                                @foreach($window->services as $service)
                                                    <span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">
                                                        {{ $service->name }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-gray-500">No Services Assigned</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-gray-600">{{ $window->cashier->name ?? 'No Cashier Assigned' }}</td>
                                        <td class="py-3 px-4">
                                            <a href="{{ route('admin-edit-windows', $window->id) }}" 
                                               class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                            <button onclick="deleteConfirmation({{ $window->id }})" 
                                                    class="text-red-500 hover:text-red-700">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <!-- SweetAlert2 Script -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    function deleteConfirmation(windowId) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'You won\'t be able to revert this!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('delete-form').action = '/admin/windows/' + windowId;
                                document.getElementById('delete-form').submit();
                            }
                        });
                    }

                    document.addEventListener('DOMContentLoaded', function () {
                        @if(session('success'))
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: '{{ session('success') }}',
                                showConfirmButton: false,
                                timer: 1000,
                                toast: true
                            });
                        @endif
                    });
                </script>

                <!-- Delete Form -->
                <form id="delete-form" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
