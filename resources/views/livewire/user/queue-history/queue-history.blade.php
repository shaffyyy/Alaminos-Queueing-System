<div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="text-center mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Queue History</h1>
        <p class="text-gray-600 text-base md:text-lg">Review your past queue records and monitor service history.</p>
    </div>

    <!-- Flash Messages -->
    @if(session()->has('message'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Queue History Section -->
    <div class="space-y-4">
        @if($tickets->isEmpty())
            <div class="text-center text-gray-500 py-8">
                <p>No queue history available.</p>
            </div>
        @else
            @foreach($tickets as $ticket)
            <div class="border border-gray-300 rounded-lg p-4 bg-indigo-200 shadow-md hover:shadow-lg transition transform hover:scale-105">
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
            
                    <!-- Actions -->
                    <div class="flex space-x-4">
                        @if($ticket->status === 'completed')
                            @if($this->hasFeedback($ticket->id))
                                <!-- Display Stars -->
                                <div class="flex space-x-1">
                                    @for($i = 1; $i <= $this->getFeedbackRating($ticket->id); $i++)
                                        <span class="text-yellow-500 text-xl">&#9733;</span>
                                    @endfor
                                    @for($i = $this->getFeedbackRating($ticket->id) + 1; $i <= 5; $i++)
                                        <span class="text-gray-300 text-xl">&#9733;</span>
                                    @endfor
                                </div>
                            @else
                                <!-- Feedback Button -->
                                <button wire:click="openFeedbackModal({{ $ticket->id }})"
                                        class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition duration-200">
                                    Leave Feedback
                                </button>
                            @endif
                        @endif
            
                        <!-- Delete Button -->
                        <button wire:click="deleteTicket({{ $ticket->id }})"
                                onclick="if(!confirm('Are you sure you want to delete this ticket? This action cannot be undone.')) return false;"
                                class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition duration-200">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            
            @endforeach
        @endif
    </div>
    

    <!-- Feedback Modal -->
    @if($showFeedbackModal)
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <h2 class="text-lg font-bold mb-4">Leave Feedback</h2>
                <form wire:submit.prevent="submitFeedback">
                    <!-- Star Rating -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Rating</label>
                        <div class="flex space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" wire:click="$set('rating', {{ $i }})" class="text-2xl">
                                    <span class="{{ $i <= $rating ? 'text-yellow-500' : 'text-gray-300' }}">&#9733;</span>
                                </button>
                            @endfor
                        </div>
                        @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Feedback Description -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Feedback</label>
                        <textarea wire:model="feedback" class="w-full border border-gray-300 rounded-lg p-2" rows="4" placeholder="Write your feedback here..."></textarea>
                        @error('feedback') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" wire:click="closeFeedbackModal" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
