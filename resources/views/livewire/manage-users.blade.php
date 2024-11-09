<div>
    <!-- Header with Search and Filter Form -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">Users</h2>
        
        <!-- Search and Filter Form -->
        <div class="flex space-x-2">
            <input type="text" wire:model.debounce.300ms="search" placeholder="Search by name" class="border-gray-300 rounded-md shadow-sm">
            
            <select wire:model="usertype" class="border-gray-300 rounded-md shadow-sm">
                <option value="">All Roles</option>
                <option value="0">User</option>
                <option value="1">Admin</option>
                <option value="2">Cashier</option>
                <option value="3">FD Cashier</option>
            </select>
        </div>
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
                            <a href="#" class="text-blue-500 hover:text-blue-700">Edit</a>
                            <a href="#" class="text-red-500 hover:text-red-700">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
