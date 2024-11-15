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
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="7days">Previous 7 Days</option>
        </select>
    </div>

    <!-- Queue History Section -->
    <div class="space-y-4">
        @if($tickets->isEmpty())
            <div class="text-center text-gray-500 py-8">
                <p>No queue history available.</p>
            </div>
        @else
            @foreach($tickets as $ticket)
                <div class="border border-gray-300 rounded-lg p-4 bg-gray-200 shadow-md hover:shadow-lg transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <!-- Ticket Information -->
                        <div>
                            <h2 class="text-lg font-bold text-blue-600">Queue Number: {{ $ticket->queue_number ?? 'N/A' }}</h2>
                            <p class="text-sm text-gray-700"><strong>Service:</strong> {{ $ticket->service->name ?? 'N/A' }}</p>
                            <p class="text-sm">
                                <strong>Status:</strong> 
                                <span class="@if($ticket->status === 'waiting') text-yellow-600 
                                              @elseif($ticket->status === 'in-service') text-blue-600 
                                              @elseif($ticket->status === 'completed') text-green-600 
                                              @elseif($ticket->status === 'cancelled') text-red-600 
                                              @endif font-semibold">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <button wire:click="deleteTicket({{ $ticket->id }})"
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
</div>
