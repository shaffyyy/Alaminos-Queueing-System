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

    <!-- Queue History Table -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        @if($tickets->isEmpty())
            <div class="text-center text-gray-500 py-8">
                <p>No queue history available.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border text-xs sm:text-sm md:text-base">Ticket ID</th>
                            <th class="py-2 px-4 border text-xs sm:text-sm md:text-base">Service</th>
                            <th class="py-2 px-4 border text-xs sm:text-sm md:text-base">Status</th>
                            <th class="py-2 px-4 border text-xs sm:text-sm md:text-base">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                                <td class="py-2 px-4 border text-xs sm:text-sm md:text-base">{{ $ticket->id }}</td>
                                <td class="py-2 px-4 border text-xs sm:text-sm md:text-base">{{ $ticket->service->name ?? 'N/A' }}</td>
                                <td class="py-2 px-4 border text-xs sm:text-sm md:text-base">{{ ucfirst($ticket->status) }}</td>
                                <td class="py-2 px-4 border text-xs sm:text-sm md:text-base">{{ $ticket->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $tickets->links() }}
    </div>
</div>
