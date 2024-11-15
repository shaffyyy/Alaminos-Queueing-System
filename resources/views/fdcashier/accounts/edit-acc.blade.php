<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Account
            </h1>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Back Button -->
                <div class="mb-4">
                    <a href="{{ route('fdcashier-accounts') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        Back
                    </a>
                </div>

                <form id="update-account-form" action="{{ route('fdcashier-accounts-update', $account->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
                        <input type="text" name="name" id="name" value="{{ $account->name }}" class="w-full border-gray-300 rounded-lg p-2 shadow-sm" required>
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ $account->email }}" class="w-full border-gray-300 rounded-lg p-2 shadow-sm" required>
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- User Type Selection -->
                    <div class="mb-4">
                        <label for="role" class="block text-gray-700 font-bold mb-2">User Type</label>
                        <select name="role" id="role" class="w-full border-gray-300 rounded-lg p-2 shadow-sm" required>
                            <option value="0" {{ $account->usertype == 0 ? 'selected' : '' }}>User</option>
                            <option value="4" {{ $account->usertype == 4 ? 'selected' : '' }}>PWD</option>
                        </select>
                        @error('role')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                            Update Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Add Confirmation Script -->
    <script>
        document.getElementById('update-account-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update this account?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Submit the form if confirmed
                }
            });
        });
    </script>
</x-app-layout>
