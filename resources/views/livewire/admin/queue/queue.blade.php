<div class="py-12" wire:poll.2s="loadQueues">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-100 overflow-hidden shadow-xl sm:rounded-lg p-6">

            <!-- Search and Filter Buttons -->
            <div class="flex gap-4 mb-4">
                <input type="text" wire:model.debounce.500ms="search" placeholder="Search by Queue Number"
                    class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 w-1/3" />

                <button wire:click="showVerified" class="px-4 py-2 rounded-lg font-semibold 
                    {{ $verificationStatus === 'verified' ? 'bg-blue-600 text-white' : 'bg-gray-400 text-gray-50' }}">
                    Verified
                </button>

                <button wire:click="showUnverified" class="relative px-4 py-2 rounded-lg font-semibold 
                    {{ $verificationStatus === 'unverified' ? 'bg-blue-600 text-white' : 'bg-gray-400 text-gray-50' }}">
                    Unverified
                    @if($newUnverifiedCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ $newUnverifiedCount }}
                        </span>
                    @endif
                </button>
            </div>

            <!-- Display Queue -->
            @if($queues->isEmpty())
                <div class="text-center text-gray-500 py-8">
                    <p>No queues available.</p>
                </div>
            @else
                <div class="overflow-x-auto bg-gray-50 rounded-lg shadow-lg">
                    <table class="min-w-full border divide-y divide-gray-200 bg-gray-100">
                        <thead class="bg-gray-600 text-white">
                            <tr>
                                <th class="py-3 px-4 border text-left font-medium">Queue Number</th>
                                <th class="py-3 px-4 border text-left font-medium">User</th>
                                <th class="py-3 px-4 border text-left font-medium">Service</th>
                                <th class="py-3 px-4 border text-left font-medium">Window</th>
                                <th class="py-3 px-4 border text-left font-medium">Status</th>
                                <th class="py-3 px-4 border text-left font-medium">Verification</th>
                                <th class="py-3 px-4 border text-left font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($queues as $queue)
                                <tr class="{{ $loop->even ? 'bg-gray-200' : 'bg-gray-100' }} hover:bg-gray-300 transition duration-200">
                                    <td class="py-3 px-4 border font-semibold text-gray-700">{{ $queue->queue_number ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 border text-gray-600">{{ $queue->user->name ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 border text-gray-600">{{ $queue->service->name ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 border text-gray-600">{{ $queue->window->name ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 border text-gray-600">{{ ucfirst($queue->status) }}</td>
                                    <td class="py-3 px-4 border text-gray-600">{{ ucfirst($queue->verify) }}</td>
                                    <td class="py-3 px-4 border flex space-x-2">
                                        @if($queue->verify === 'verified')
                                            <button wire:click="$emit('confirmUndo', {{ $queue->id }})" class="bg-yellow-500 text-white py-1 px-3 rounded-lg hover:bg-yellow-600 transition duration-200">
                                                Undo
                                            </button>
                                        @else
                                            <button wire:click="$emit('confirmVerify', {{ $queue->id }})" class="bg-green-500 text-white py-1 px-3 rounded-lg hover:bg-green-600 transition duration-200">
                                                Verify
                                            </button>
                                        @endif
                                        <button wire:click="$emit('confirmCancel', {{ $queue->id }})" class="bg-red-500 text-white py-1 px-3 rounded-lg hover:bg-red-600 transition duration-200">
                                            Cancel
                                        </button>
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

<!-- SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Livewire.on('confirmVerify', (ticketId) => {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to verify this ticket?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, verify it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('verifyTicket', ticketId);
            }
        });
    });

    Livewire.on('confirmUndo', (ticketId) => {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to undo verification for this ticket?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, undo it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('undoVerifyTicket', ticketId);
            }
        });
    });

    Livewire.on('confirmCancel', (ticketId) => {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to cancel this ticket?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('cancelTicket', ticketId);
            }
        });
    });

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
