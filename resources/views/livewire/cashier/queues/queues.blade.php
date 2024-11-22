<div class="py-12" wire:poll.2s="loadQueues">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-200 overflow-hidden shadow-xl sm:rounded-lg p-6">
            @if($assignedWindow)
                <h2 class="text-2xl font-bold mb-4 text-gray-700">Window: {{ $assignedWindow->name }}</h2>

                @if($queues->isEmpty())
                    <div class="text-center text-gray-500 py-8">
                        <p>No verified queues available for this window.</p>
                    </div>
                @else
                    <div class="overflow-x-auto bg-gray-50 rounded-lg shadow-lg">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead class="bg-gray-600 text-white">
                                <tr>
                                    <th class="py-3 px-4 border text-left font-medium">Queue Number</th>
                                    <th class="py-3 px-4 border text-left font-medium">User</th>
                                    <th class="py-3 px-4 border text-left font-medium">Service</th>
                                    <th class="py-3 px-4 border text-left font-medium">Status</th>
                                    <th class="py-3 px-4 border text-left font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($queues as $queue)
                                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-gray-200' }} hover:bg-gray-300 transition duration-200">
                                        <td class="py-3 px-4 border font-semibold text-gray-700">{{ $queue->queue_number }}</td>
                                        <td class="py-3 px-4 border text-gray-600">{{ $queue->user->name ?? 'N/A' }}</td>
                                        <td class="py-3 px-4 border text-gray-600">{{ $queue->service->name ?? 'N/A' }}</td>
                                        <td class="py-3 px-4 border text-gray-600">{{ ucfirst($queue->status) }}</td>
                                        <td class="py-3 px-4 border">
                                            @if($queue->status === 'waiting')
                                                <button wire:click="startService({{ $queue->id }})"
                                                    onclick="announceQueueNumber('{{ $queue->queue_number }}')"
                                                    class="bg-blue-500 text-white py-1 px-3 rounded-lg hover:bg-blue-600 transition duration-200">
                                                    Start Service
                                                </button>
                                            @elseif($queue->status === 'in-service')
                                                <button wire:click="completeService({{ $queue->id }})"
                                                    class="bg-green-500 text-white py-1 px-3 rounded-lg hover:bg-green-600 transition duration-200">
                                                    Complete Service
                                                </button>
                                            @endif
                                            <button wire:click="cancelQueue({{ $queue->id }})"
                                                class="bg-red-500 text-white py-1 px-3 rounded-lg hover:bg-red-600 transition duration-200">
                                                Cancel
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @else
                <div class="text-center text-gray-500 py-8">
                    <p>No window assigned to this account.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript for Voice Announcement -->
    <script>
        function announceQueueNumber(queueNumber) {
            if ('speechSynthesis' in window) {
                const message = new SpeechSynthesisUtterance(`Now serving queue number ${queueNumber}`);
                message.lang = 'en-US';
                message.rate = 1;
                message.pitch = 1;
                window.speechSynthesis.speak(message);
            } else {
                alert('Sorry, your browser does not support voice announcements.');
            }
        }
    </script>
</div>
