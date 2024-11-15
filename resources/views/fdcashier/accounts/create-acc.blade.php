<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Account
            </h1>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form id="create-account-form" action="{{ route('fdcashier-accounts-store') }}" method="POST">
                    @csrf

                    <!-- Name Field -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
                        <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-lg p-2 shadow-sm" required>
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                        <input type="email" name="email" id="email" class="w-full border-gray-300 rounded-lg p-2 shadow-sm" required>
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
                        <input type="password" name="password" id="password" class="w-full border-gray-300 rounded-lg p-2 shadow-sm" required>
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border-gray-300 rounded-lg p-2 shadow-sm" required>
                        @error('password_confirmation')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- User Type Selection -->
                    <div class="mb-4">
                        <label for="role" class="block text-gray-700 font-bold mb-2">User Type</label>
                        <select name="role" id="role" class="w-full border-gray-300 rounded-lg p-2 shadow-sm" required>
                            <option value="">Select a Role</option>
                            <option value="0">User</option>
                            <option value="4">Special</option>
                        </select>
                        @error('role')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Confirmation Script -->
    <script>
        document.getElementById('create-account-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to create this account?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, create it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Submit the form if confirmed
                }
            });
        });
    </script>

    <!-- Include SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</x-app-layout>
