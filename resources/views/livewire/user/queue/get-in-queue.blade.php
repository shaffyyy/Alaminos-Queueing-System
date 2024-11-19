<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Get in Queue</h1>
        <p class="text-gray-600 mb-8">Join the line for quick, convenient service. Please select your service below to get started!</p>
    </div>

    @if(Auth::user()->hasVerifiedEmail())
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <form wire:submit.prevent="joinQueue">
                <div class="mb-4">
                    <label for="service" class="block text-gray-700 font-semibold mb-2">Select Service</label>
                    <select wire:model="service" id="service" class="w-full border border-gray-300 rounded-lg p-3">
                        <option value="">Choose a service...</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                    @error('service') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-200">
                    Join Queue
                </button>
            </form>
        </div>
    @else
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
            <p class="font-bold">Email Verification Required</p>
            <p>You need to verify your email address to join the queue. Please check your email for a verification link.</p>
        </div>
    @endif

    <div wire:poll.5s="loadQueueStatus" class="mt-12 bg-blue-100 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-blue-800 mb-4">Your Queue Status</h2>
    
        @if ($queueNumber)
            <p class="text-blue-700">You are currently in line. Please wait for your number to be called.</p>
            <div class="mt-4">
                <p class="font-bold text-blue-900 text-3xl">Queue Number: <span class="text-blue-600">{{ $queueNumber }}</span></p>
            </div>

            @if ($assignedWindow)
                <div class="mt-6 bg-green-100 p-4 rounded-lg shadow-md">
                    <p class="font-bold text-green-800">Assigned Window</p>
                    <p class="text-gray-700">Please proceed to: <span class="font-semibold">{{ $assignedWindow }}</span></p>
                </div>
            @endif

            <button wire:click="cancelTicket({{ $currentTicketId }})"
                    onclick="return confirm('Are you sure you want to cancel this ticket?')"
                    class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition duration-200">
                Cancel
            </button>
        @else
            <p class="text-blue-700">Please join the queue to see your status here.</p>
        @endif
    </div>

    <!-- Queue Monitoring Section -->
    <div wire:poll.5s="loadQueueMonitoring" class="mt-12 bg-gray-900 text-white p-10 rounded-lg shadow-lg flex items-center justify-center">
        <h2 class="text-3xl font-bold text-center mb-8">Queue Monitoring</h2>
        @if(empty($queues))
            <div class="text-center text-gray-400">
                <p>No active queues at the moment.</p>
            </div>
        @else
            <div class="bg-gray-800 p-12 rounded-lg shadow-lg text-center w-full max-w-4xl">
                <h3 class="text-4xl font-bold text-white mb-6">{{ $queues[0]['queue_number'] }}</h3>
                <p class="text-2xl text-gray-300 mb-4">
                    <strong>Service:</strong> {{ $queues[0]['service'] }}
                </p>
                <p class="text-2xl">
                    <strong>Status:</strong> 
                    <span class="{{ $queues[0]['status'] === 'In-service' ? 'text-green-400' : 'text-yellow-400' }}">
                        {{ ucfirst($queues[0]['status']) }}
                    </span>
                </p>
                @if($queues[0]['assigned_window'])
                    <p class="text-xl text-blue-400 mt-6">
                        Proceed to: <strong>{{ $queues[0]['assigned_window'] }}</strong>
                    </p>
                @endif
            </div>
        @endif
    </div>
</div>
