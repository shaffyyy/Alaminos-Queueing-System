<div class="py-12" wire:poll.2s="loadQueues">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-200 overflow-hidden shadow-xl sm:rounded-lg p-6">
              
            @if($assignedWindow)
               <!-- Flex container for Window Name and Button -->
               <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-700 whitespace-nowrap">Window: {{ $assignedWindow->name }}</h2>
                    <a href="{{ route('cashier-visitPage') }}"
                    class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition duration-200">
                        Visit Other Queue
                    </a>
                </div>
            
            </div>
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
                                            <!-- Notify Button -->
                                            <button onclick="callQueueNumber('{{ $queue->queue_number }}')"
                                                class="bg-yellow-500 text-white py-1 px-3 rounded-lg hover:bg-yellow-600 transition duration-200">
                                                Call
                                            </button>
                                            @if($queue->status === 'waiting')
                                                <button wire:click="startService({{ $queue->id }})"
                                                    onclick="announceQueueNumber('{{ $queue->queue_number }}')"
                                                    class="bg-blue-500 text-white py-1 px-3 rounded-lg hover:bg-blue-600 transition duration-200">
                                                    Start Service
                                                </button>
                                            @elseif($queue->status === 'in-service')
                                                <button wire:click="openOrModal({{ $queue->id }})"
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

    <!-- OR Number Modal -->
    @if($showOrModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-lg p-6 w-96">
                <h3 class="text-xl font-bold mb-4 text-gray-700">Enter OR Number</h3>
                <form wire:submit.prevent="submitOrNumber">
                    <div class="mb-4">
                        <label for="or_number" class="block text-gray-600 font-medium mb-2">OR Number</label>
                        <input type="text" id="or_number" wire:model="orNumber"
                            class="w-full border border-gray-300 rounded-lg p-2">
                        @error('orNumber') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" wire:click="closeOrModal"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- JavaScript for Voice Announcement -->
    <script>
        function announceQueueNumber(queueNumber) {
            if ('speechSynthesis' in window) {
                const message = new SpeechSynthesisUtterance(`Now serving queue number ${queueNumber}`);
                message.lang = 'en-US'; // You can adjust this for different languages
                message.rate = 1; // Speed of the voice
                message.pitch = 1; // Pitch of the voice
                window.speechSynthesis.speak(message);
            } else {
                alert('Sorry, your browser does not support voice announcements.');
            }
        }
        function callQueueNumber(queueNumber) {
            if ('speechSynthesis' in window) {
                const message = new SpeechSynthesisUtterance(`Please proceed to the window, number ${queueNumber}`);
                message.lang = 'en-US'; // You can adjust this for different languages
                message.rate = 1; // Speed of the voice
                message.pitch = 1; // Pitch of the voice
                window.speechSynthesis.speak(message);
            } else {
                alert('Sorry, your browser does not support voice announcements.');
            }
        }
    </script>
    
</div>
