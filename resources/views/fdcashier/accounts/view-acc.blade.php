<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Accounts
            </h1>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden sm:rounded-lg p-6">
                <div class="recent-activities-section border rounded p-4 shadow bg-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Accounts</h2>
                        <a href="{{ route('fdcashier-accounts-create') }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200">Create Account</a>
                    </div>
                    <div class="overflow-x-auto bg-gray-50 rounded-lg shadow-lg">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead class="bg-gray-600 text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium">Name</th>
                                    <th class="px-4 py-2 text-left font-medium">Email</th>
                                    <th class="px-4 py-2 text-left font-medium">User Type</th>
                                    <th class="px-4 py-2 text-left font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($accounts as $account)
                                    <tr class="{{ $loop->even ? 'bg-gray-200' : 'bg-gray-100' }} hover:bg-gray-300 transition duration-200">
                                        <td class="px-4 py-2 text-gray-700 font-semibold">{{ $account->name }}</td>
                                        <td class="px-4 py-2 text-gray-600">{{ $account->email }}</td>
                                        <td class="px-4 py-2 text-gray-600">
                                            {{ $account->usertype == 0 ? 'User' : 'Special' }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-600 flex space-x-2">
                                            <a href="{{ route('fdcashier-accounts-edit', $account->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>


                                            <button onclick="confirmDelete({{ $account->id }})" class="text-red-500 hover:text-red-700">Delete</button>
                                            <form method="POST" action="{{ route('fdcashier-accounts-delete', $account->id) }}" onsubmit="return confirm('Are you sure you want to delete this account?');">
                                                @csrf
                                                @method('DELETE')
                                                
                                            </form>
                                            
                                            
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-2 text-center text-gray-600">No accounts found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Confirmation for Delete
        function confirmDelete(accountId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${accountId}`).submit();
                }
            });
        }

        // Success Toast
        document.addEventListener('DOMContentLoaded', function () {
            @if (session()->has('success'))
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
