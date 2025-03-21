<div class="p-6 bg-gray-100 rounded-lg shadow-lg">
    <!-- Dropdown for selecting a window -->
    <div class="mb-4">
        <label for="window-select" class="block text-gray-700 font-medium mb-2">Select Window:</label>
        <select id="window-select" wire:model="selectedWindowId" class="w-full p-2 border rounded-lg">
            <option value="">-- Choose a Window --</option>
            @foreach($windows as $window)
                <option value="{{ $window->id }}">{{ $window->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Tickets Table -->
    @if($tickets && count($tickets) > 0)
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full border divide-y divide-gray-200">
                <thead class="bg-gray-600 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left font-medium">Queue Number</th>
                        <th class="py-3 px-4 text-left font-medium">User</th>
                        <th class="py-3 px-4 text-left font-medium">Service</th>
                        <th class="py-3 px-4 text-left font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-gray-200' }} hover:bg-gray-300 transition">
                            <td class="py-3 px-4">{{ $ticket->queue_number }}</td>
                            <td class="py-3 px-4">{{ $ticket->user->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4">{{ $ticket->service->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4">{{ ucfirst($ticket->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center text-gray-500">
            <p>No tickets available for the selected window.</p>
        </div>
    @endif
</div>
