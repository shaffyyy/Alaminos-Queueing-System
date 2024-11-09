<div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8" wire:poll.5s="refreshTickets">
    <!-- Monitor Header -->
    <div class="text-center mb-8 flex justify-between items-center">
        <h1 class="text-5xl font-bold text-gray-800 mb-4">Queue Monitor</h1>
        
        <!-- Full Screen and Toggle Button -->
        <div class="flex space-x-4">
            <button onclick="toggleFullScreen()" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-200">
                Full Screen
            </button>
            <button wire:click="toggleUnverified" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-600 transition duration-200">
                {{ $showUnverified ? 'Show Verified' : 'Show Unverified' }}
            </button>
        </div>
    </div>

    <!-- Queue Table Display -->
    <div class="bg-white rounded-lg shadow-lg p-6 overflow-x-auto" id="monitorTable">
        <table class="min-w-full text-center">
            <thead class="bg-blue-600 text-white text-lg">
                <tr>
                    <th class="py-4 px-6">Ticket ID</th>
                    <th class="py-4 px-6">Service</th>
                    <th class="py-4 px-6">Window</th>
                    <th class="py-4 px-6">Status</th>
                </tr>
            </thead>
            <tbody class="text-xl text-gray-800">
                @forelse($tickets as $ticket)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                        <td class="py-4 px-6">{{ $ticket->id }}</td>
                        <td class="py-4 px-6">{{ $ticket->service->name ?? 'N/A' }}</td>
                        <td class="py-4 px-6">{{ $ticket->window->name ?? 'N/A' }}</td>
                        <td class="py-4 px-6 font-semibold {{ $ticket->status == 'in-service' ? 'text-yellow-500' : 'text-green-500' }}">
                            {{ ucfirst($ticket->status) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-6 text-2xl text-gray-500">No {{ $showUnverified ? 'unverified' : 'verified' }} tickets</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Full Screen JavaScript -->
<script>
    function toggleFullScreen() {
        let element = document.getElementById("monitorTable");

        if (!document.fullscreenElement) {
            element.requestFullscreen().catch(err => {
                alert(`Error attempting to enable full-screen mode: ${err.message}`);
            });
        } else {
            document.exitFullscreen();
        }
    }
</script>
