<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Users
            </h1>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Header with Search and Filter Form -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold">Users</h2>
                    
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('admin-manage-user') }}" class="flex">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name" class="border-gray-300 rounded-md shadow-sm">
                        
                        <select name="usertype" class="ml-2 border-gray-300 rounded-md shadow-sm">
                            <option value="">All Roles</option>
                            <option value="0" {{ request('usertype') == '0' ? 'selected' : '' }}>User</option>
                            <option value="1" {{ request('usertype') == '1' ? 'selected' : '' }}>Admin</option>
                            <option value="2" {{ request('usertype') == '2' ? 'selected' : '' }}>Cashier</option>
                            <option value="3" {{ request('usertype') == '3' ? 'selected' : '' }}>FD Cashier</option>
                        </select>

                        <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Filter</button>
                    </form>
                </div>

                <!-- Check if there are any users to display -->
                @if($users->isEmpty())
                    <div class="text-center text-gray-500 py-8">
                        <p>No users available.</p>
                    </div>
                @else
                    <!-- Users Table -->
                    <table class="w-full table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Type</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->id }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->email }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                        @if($user->usertype == 0)
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">User</span>
                                        @elseif($user->usertype == 1)
                                            <span class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Admin</span>
                                        @elseif($user->usertype == 2)
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Cashier</span>
                                        @elseif($user->usertype == 3)
                                            <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">FD Cashier</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <a href="{{ route('admin-edit-user', $user->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                        <button onclick="deleteUser({{ $user->id }})" class="text-red-500 hover:text-red-700">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>

    <!-- SweetAlert Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function deleteUser(userId) {
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
                    let form = document.createElement('form');
                    form.action = '/admin/users/' + userId;
                    form.method = 'POST';
                    form.innerHTML = '@csrf @method('DELETE')';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Show SweetAlert for successful updates
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
</x-app-layout>
