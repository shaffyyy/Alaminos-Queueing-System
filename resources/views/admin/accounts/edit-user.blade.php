<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit User
            </h1>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-8">

                <!-- Success Message -->
                @if (session()->has('success'))
                    <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6 text-center">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Edit User Form -->
                <form id="update-user-form" action="{{ route('admin-update-user', $user->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="usertype" class="block text-sm font-medium text-gray-700">User Type</label>
                        <select name="usertype" id="usertype" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="0" {{ $user->usertype == 0 ? 'selected' : '' }}>User</option>
                            <option value="0" {{ $user->usertype == 4 ? 'selected' : '' }}>PWD</option>
                            <option value="1" {{ $user->usertype == 1 ? 'selected' : '' }}>Admin</option>
                            <option value="2" {{ $user->usertype == 2 ? 'selected' : '' }}>Cashier</option>
                            <option value="3" {{ $user->usertype == 3 ? 'selected' : '' }}>FD Cashier</option>
                        </select>
                        @error('usertype') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end space-x-4">
                        <!-- Back Button -->
                        <a href="{{ route('admin-manage-user') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-150">
                            Back
                        </a>

                        <!-- Update Button with SweetAlert -->
                        <button type="button" onclick="confirmUpdate()" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-150">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmUpdate() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to update this user's information.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('update-user-form').submit();
                }
            });
        }
    </script>
</x-app-layout>
