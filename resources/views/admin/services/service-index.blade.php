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
            <div class="bg-gray-200 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div>
                    <h1 class="text-2xl font-bold mb-4">Services List</h1>

                    <!-- Success Message -->
                    @if (session()->has('message'))
                        <div class="bg-green-100 text-green-800 p-3 rounded-md mb-4">
                            {{ session('message') }}
                        </div>
                    @endif

                    <!-- Add New Service Button -->
                    <a href="{{ route('admin-add-services') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4 inline-block hover:bg-blue-600 transition duration-200">Add New Service</a>

                    <!-- Table -->
                    <div class="overflow-x-auto bg-gray-50 rounded-lg shadow-lg">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead class="bg-gray-600 text-white">
                                <tr>
                                    <th class="py-3 px-4 border text-left font-medium">Name</th>
                                    <th class="py-3 px-4 border text-left font-medium">Description</th>
                                    
                                    <th class="py-3 px-4 border text-left font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($services as $service)
                                    <tr class="{{ $loop->even ? 'bg-gray-200' : 'bg-gray-100' }} hover:bg-gray-300 transition duration-200">
                                        <td class="py-3 px-4 border font-semibold text-gray-700">{{ $service->name }}</td>
                                        <td class="py-3 px-4 border text-gray-600">{{ $service->description }}</td>
                                        
                                        <td class="py-3 px-4 border text-gray-600">
                                            <a href="{{ route('admin-edit-service', $service->id) }}" class="text-blue-500 hover:underline">Edit</a> |
                                            <button onclick="deleteConfirmation({{ $service->id }})" class="text-red-500 hover:underline">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deleteConfirmation(serviceId) {
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
                    // Create a form dynamically to send a DELETE request
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/services/${serviceId}`;

                    // Add CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);

                    // Add the DELETE method input (since forms only support GET and POST methods)
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    // Append the form to the body and submit it
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Show success alert if session has a success message
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('message'))
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('message') }}',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true
                });
            @endif
        });

        // Show success alert if session has a success message
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true
                });
            @endif
        });
    </script>
</x-app-layout>
