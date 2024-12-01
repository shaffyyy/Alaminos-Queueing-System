<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Users
            </h1>
        </div>
    </x-slot>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Header with Search and Filter Form -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-700">Users</h2>

                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('admin-manage-user') }}" class="flex">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name"
                               class="border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:border-blue-500" />

                        <select name="usertype" class="ml-2 border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500">
                            <option value="">All Roles</option>
                            <option value="0" {{ request('usertype') == '0' ? 'selected' : '' }}>User</option>
                            <option value="1" {{ request('usertype') == '1' ? 'selected' : '' }}>Admin</option>
                            <option value="2" {{ request('usertype') == '2' ? 'selected' : '' }}>Cashier</option>
                            <option value="3" {{ request('usertype') == '3' ? 'selected' : '' }}>FD Cashier</option>
                            <option value="4" {{ request('usertype') == '4' ? 'selected' : '' }}>Special</option>
                        </select>

                        <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                            Filter
                        </button>
                    </form>
                </div>

                <!-- Check if there are any users to display -->
                @if($users->isEmpty())
                    <div class="text-center text-gray-500 py-8">
                        <p>No users available.</p>
                    </div>
                @else
                    <!-- Users Table -->
                    <div class="overflow-x-auto bg-gray-50 rounded-lg shadow-lg">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead class="bg-gray-600 text-white">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium">ID</th>
                                    <th class="px-4 py-3 text-left font-medium">Name</th>
                                    <th class="px-4 py-3 text-left font-medium">Email</th>
                                    <th class="px-4 py-3 text-left font-medium">User Type</th>
                                    <th class="px-4 py-3 text-left font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr class="{{ $loop->even ? 'bg-gray-200' : 'bg-gray-100' }} hover:bg-gray-300 transition duration-200">
                                        <td class="px-4 py-3 text-gray-700 font-semibold">{{ $user->id }}</td>
                                        <td class="px-4 py-3 text-gray-700 font-semibold">{{ $user->name }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                                        <td class="px-4 py-3">
                                            @if($user->usertype == 0)
                                                <span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">User</span>
                                            @elseif($user->usertype == 1)
                                                <span class="bg-red-100 text-red-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">Admin</span>
                                            @elseif($user->usertype == 2)
                                                <span class="bg-yellow-100 text-yellow-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">Cashier</span>
                                            @elseif($user->usertype == 3)
                                                <span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">FD Cashier</span>
                                            @elseif($user->usertype == 4)
                                                <span class="bg-purple-100 text-purple-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">Special</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">
                                            <a href="{{ route('admin-edit-user', $user->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                            <button onclick="deleteUser({{ $user->id }})" class="text-red-500 hover:text-red-700">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
