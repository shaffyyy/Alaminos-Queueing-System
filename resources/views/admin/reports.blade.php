<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reports
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                <!-- Filters -->
                <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <!-- Date Filter -->
                    <div>
                        <label for="dateFilter" class="block text-sm font-medium text-gray-700">Date Filter</label>
                        <select name="dateFilter" id="dateFilter" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="today" {{ request('dateFilter') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="yesterday" {{ request('dateFilter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                            <option value="7days" {{ request('dateFilter') == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="thisMonth" {{ request('dateFilter') == 'thisMonth' ? 'selected' : '' }}>This Month</option>
                        </select>
                    </div>

                    <!-- Service Filter -->
                    <div>
                        <label for="serviceFilter" class="block text-sm font-medium text-gray-700">Service</label>
                        <select name="serviceFilter" id="serviceFilter" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Services</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" {{ request('serviceFilter') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                            Apply Filters
                        </button>
                    </div>
                </form>

                <!-- Ticket Report Table -->
                <h3 class="text-lg font-semibold mb-4">Tickets Summary</h3>
                <table class="min-w-full bg-white border">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border">Queue Number</th>
                            <th class="py-2 px-4 border">Service</th>
                            <th class="py-2 px-4 border">User</th>
                            <th class="py-2 px-4 border">Window</th>
                            <th class="py-2 px-4 border">Status</th>
                            <th class="py-2 px-4 border">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td class="py-2 px-4 border">{{ $ticket->queue_number }}</td>
                                <td class="py-2 px-4 border">{{ $ticket->service->name }}</td>
                                <td class="py-2 px-4 border">{{ $ticket->user->name }}</td>
                                <td class="py-2 px-4 border">{{ $ticket->window->name ?? 'N/A' }}</td>
                                <td class="py-2 px-4 border">{{ ucfirst($ticket->status) }}</td>
                                <td class="py-2 px-4 border">{{ $ticket->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-2 px-4 border text-center text-gray-500">No tickets found for the selected filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Feedback Summary -->
                <h3 class="text-lg font-semibold mt-8 mb-4">User Feedback</h3>
                <table class="min-w-full bg-white border">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border">User</th>
                            <th class="py-2 px-4 border">Rating</th>
                            <th class="py-2 px-4 border">Comment</th>
                            <th class="py-2 px-4 border">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($feedback as $fb)
                            <tr>
                                <td class="py-2 px-4 border">{{ $fb->user->name }}</td>
                                <td class="py-2 px-4 border">{{ $fb->rating }} / 5</td>
                                <td class="py-2 px-4 border">{{ $fb->feedback }}</td>
                                <td class="py-2 px-4 border">{{ $fb->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-2 px-4 border text-center text-gray-500">No feedback found for the selected filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
