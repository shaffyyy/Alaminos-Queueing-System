<div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="text-center mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Queue History</h1>
        <p class="text-gray-600 text-base md:text-lg">Review your past queue records and monitor service history.</p>
    </div>

    <!-- Date Filter Dropdown aligned to the right -->
    <div class="flex justify-end mb-8">
        <label for="dateFilter" class="mr-2 text-gray-700 font-semibold">Filter by Date:</label>
        <select id="dateFilter" wire:model="selectedDateFilter" wire:change="filterByDate($event.target.value)" class="border border-gray-300 rounded-lg p-2">
            <option value="all">All</option>
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="7days">Previous 7 Days</option>
        </select>
    </div>

    <!-- Today's Queue Section -->
    @if ($selectedDateFilter === 'today')
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-blue-800 mb-4">Today's Queues</h2>
            <div class="space-y-4">
                @foreach($tickets->where('created_at', '>=', now()->startOfDay()) as $ticket)
                    <div class="border border-gray-200 rounded-lg p-4 bg-white shadow-md hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-bold text-blue-600">Queue Number: {{ $ticket->queue_number ?? 'N/A' }}</h2>
                                <p class="text-sm text-gray-600"><strong>Service:</strong> {{ $ticket->service->name ?? 'N/A' }}</p>
                                <p class="text-sm">
                                    <strong>Status:</strong>
                                    <span class="
                                        @if($ticket->status === 'waiting') text-yellow-500 
                                        @elseif($ticket->status === 'in-service') text-blue-500 
                                        @elseif($ticket->status === 'completed') text-green-500 
                                        @elseif($ticket->status === 'cancelled') text-red-500 
                                        @endif font-semibold
                                    ">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <button wire:click="deleteTicket({{ $ticket->id }})"
                                        onclick="return confirmDelete()"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition duration-200">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Queue History Section with Dynamic Header based on filter -->
    <div wire:poll.2s="loadQueueStatus" class="space-y-4">
        <h2 class="text-2xl font-semibold text-blue-800 mb-4">
            @switch($selectedDateFilter)
                @case('yesterday')
                    Yesterday's Queues
                    @break
                @case('7days')
                    Queues from the Past 7 Days
                    @break
                @case('all')
                    All Queue History
                    @break
                @default
                    Queue History
            @endswitch
        </h2>
        
        @if($tickets->isEmpty())
            <div class="text-center text-gray-500 py-8">
                <p>No queue history available.</p>
            </div>
        @else
            @foreach($tickets->where('created_at', '<', now()->startOfDay()) as $ticket)
                <div class="border border-gray-200 rounded-lg p-4 bg-white shadow-md hover:shadow-lg transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <!-- Ticket Information -->
                        <div>
                            <h2 class="text-lg font-bold text-blue-600">Queue Number: {{ $ticket->queue_number ?? 'N/A' }}</h2>
                            <p class="text-sm text-gray-600"><strong>Service:</strong> {{ $ticket->service->name ?? 'N/A' }}</p>
                            <p class="text-sm">
                                <strong>Status:</strong> 
                                <span class="
                                    @if($ticket->status === 'waiting') text-yellow-500 
                                    @elseif($ticket->status === 'in-service') text-blue-500 
                                    @elseif($ticket->status === 'completed') text-green-500 
                                    @elseif($ticket->status === 'cancelled') text-red-500 
                                    @endif font-semibold
                                ">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </p>
                            <p class="text-sm text-gray-600">
                                <strong>Date:</strong> {{ $ticket->created_at->format('Y-m-d') }}
                            </p>
                        </div>
                        <div>
                            <button wire:click="deleteTicket({{ $ticket->id }})"
                                    onclick="return confirmDelete()"
                                    class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition duration-200">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $tickets->links() }}
    </div>

    <!-- SweetAlert Confirmation and Notification Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete() {
            return Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                return result.isConfirmed;
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if (session()->has('message'))
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('message') }}',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true
                });
            @elseif (session()->has('error'))
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true
                });
            @endif
        });
    </script>
</div>
