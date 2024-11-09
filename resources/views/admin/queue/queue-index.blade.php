<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Queue Management
            </h1>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="">
            <div class="">
                @livewire('admin.queue.queue') <!-- Correctly referencing the Livewire component -->
            </div>
        </div>
    </div>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Filter Form -->
                <div class="mb-4 flex justify-end">
                    <form method="GET" action="{{ route('admin-view-queue') }}" class="flex items-center">
                        <label for="verify" class="mr-2 font-medium">Filter:</label>
                        <select name="verify" id="verify" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm">
                            <option value="all" {{ $verificationStatus === 'all' ? 'selected' : '' }}>All</option>
                            <option value="verified" {{ $verificationStatus === 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="unverified" {{ $verificationStatus === 'unverified' ? 'selected' : '' }}>Unverified</option>
                        </select>
                    </form>
                </div>

                <!-- Display Queue -->
                @if($queues->isEmpty())
                    <div class="text-center text-gray-500 py-8">
                        <p>No queues available.</p>
                    </div>
                @else
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border">Ticket ID</th>
                                <th class="py-2 px-4 border">User</th>
                                <th class="py-2 px-4 border">Service</th>
                                <th class="py-2 px-4 border">Window</th>
                                <th class="py-2 px-4 border">Status</th>
                                <th class="py-2 px-4 border">Verification</th>
                                <th class="py-2 px-4 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($queues as $queue)
                                <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                                    <td class="py-2 px-4 border">{{ $queue->id }}</td>
                                    <td class="py-2 px-4 border">{{ $queue->user->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border">{{ $queue->service->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border">{{ $queue->window->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border">{{ ucfirst($queue->status) }}</td>
                                    <td class="py-2 px-4 border">{{ ucfirst($queue->verify) }}</td>
                                    <td class="py-2 px-4 border">
                                        <a href="#" class="text-blue-500 hover:underline">Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div> --}}
</x-app-layout>
