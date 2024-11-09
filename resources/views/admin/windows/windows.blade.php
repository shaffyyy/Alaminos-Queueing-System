<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Windows
            </h1>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold">List of Windows</h2>
                    <a href="{{ route('admin-add-windows') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">
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
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border">Window ID</th>
                                <th class="py-2 px-4 border">Name</th>
                                <th class="py-2 px-4 border">Service</th>
                                <th class="py-2 px-4 border">Cashier</th>
                                <th class="py-2 px-4 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($windows as $window)
                                <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                                    <td class="py-2 px-4 border">{{ $window->id }}</td>
                                    <td class="py-2 px-4 border">{{ $window->name }}</td>
                                    <td class="py-2 px-4 border">{{ $window->service->name ?? 'No Service Assigned' }}</td>
                                    <td class="py-2 px-4 border">{{ $window->cashier->name ?? 'No Cashier Assigned' }}</td>
                                    <td class="py-2 px-4 border">
                                        <a href="{{ route('admin-edit-windows', $window->id) }}" class="text-blue-500 hover:underline">Edit</a> |
                                        <button onclick="deleteConfirmation({{ $window->id }})" class="text-red-500 hover:underline">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                                // Set the form's action URL dynamically based on the windowId
                                document.getElementById('delete-form').action = '/admin/windows/' + windowId;
                                // Submit the form
                                document.getElementById('delete-form').submit();
                            }
                        });
                    }

                    // Show success alert if session has a success message
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
