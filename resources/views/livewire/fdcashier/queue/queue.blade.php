<div class="py-12" wire:poll.2s="loadQueues">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

            <!-- Filter Form -->
            <div class="mb-4 flex justify-between items-center">
                <!-- Search Input -->
                <div class="flex items-center">
                    <label for="search" class="mr-2 font-medium">Search by Ticket ID:</label>
                    <input type="text" wire:model.debounce.300ms="searchTerm" id="search" placeholder="Enter Ticket ID" class="border-gray-300 rounded-md shadow-sm">
                </div>
                
                <!-- Verification Filter -->
                <div class="flex items-center">
                    <label for="verify" class="mr-2 font-medium">Filter:</label>
                    <select wire:model="verificationStatus" id="verify" class="border-gray-300 rounded-md shadow-sm">
                        <option value="all">All</option>
                        <option value="verified">Verified</option>
                        <option value="unverified">Unverified</option>
                    </select>
                </div>
            </div>

            <!-- Display Queue -->
            @if($queues->isEmpty())
                <div class="text-center text-gray-500 py-8">
                    <p>No queues available.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border">Ticket ID</th>
                                <th class="py-2 px-4 border">User</th>
                                <th class="py-2 px-4 border">Service</th>
                                <th class="py-2 px-4 border">Window</th>
                                <th class="py-2 px-4 border">Status</th>
                                <th class="py-2 px-4 border">Verification</th>
                                <th class="py-2 px-4 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($queues as $queue)
                                <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                                    <td class="py-2 px-4 border">{{ $queue->id }}</td>
                                    <td class="py-2 px-4 border">{{ $queue->user->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border">{{ $queue->service->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border">{{ $queue->window->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border">{{ ucfirst($queue->status) }}</td>
                                    <td class="py-2 px-4 border">{{ ucfirst($queue->verify) }}</td>
                                    <td class="py-2 px-4 border">
                                        @if($queue->verify === 'verified')
                                            <!-- Undo Verification Button -->
                                            <button wire:click="undoVerifyTicket({{ $queue->id }})" onclick="return confirmUndo()" class="bg-yellow-500 text-white py-1 px-3 rounded-lg hover:bg-yellow-600 transition duration-200">
                                                Undo
                                            </button>
                                        @else
                                            <!-- Verify Button -->
                                            <button wire:click="verifyTicket({{ $queue->id }})" onclick="return confirmVerification()" class="bg-green-500 text-white py-1 px-3 rounded-lg hover:bg-green-600 transition duration-200">
                                                Verify
                                            </button>
                                        @endif
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
                function confirmVerification() {
                    return Swal.fire({
                        title: 'Are you sure?',
                        text: 'Do you want to verify this ticket?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, verify it!'
                    }).then((result) => {
                        return result.isConfirmed;
                    });
                }

                function confirmUndo() {
                    return Swal.fire({
                        title: 'Are you sure?',
                        text: 'Do you want to undo verification for this ticket?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, undo it!'
                    }).then((result) => {
                        return result.isConfirmed;
                    });
                }

                document.addEventListener('livewire:load', function () {
                    @if(session()->has('verification_message'))
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: '{{ session('verification_message') }}',
                            showConfirmButton: false,
                            timer: 1500,
                            toast: true
                        });
                    @endif
                });
            </script>
        </div>
    </div>
</div>
