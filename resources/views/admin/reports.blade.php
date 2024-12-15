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
                <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
                    <!-- Date Filter -->
                    <div>
                        <label for="dateFilter" class="block text-sm font-medium text-gray-700">Date Filter</label>
                        <select name="dateFilter" id="dateFilter" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="today" {{ request('dateFilter') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="yesterday" {{ request('dateFilter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                            <option value="7days" {{ request('dateFilter') == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="thisMonth" {{ request('dateFilter') == 'thisMonth' ? 'selected' : '' }}>This Month</option>
                            <option value="lastMonth" {{ request('dateFilter') == 'lastMonth' ? 'selected' : '' }}>Last Month</option>
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

                    <!-- Window Filter -->
                    <div>
                        <label for="windowFilter" class="block text-sm font-medium text-gray-700">Window</label>
                        <select name="windowFilter" id="windowFilter" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Windows</option>
                            @foreach ($windows as $window)
                                <option value="{{ $window->id }}" {{ request('windowFilter') == $window->id ? 'selected' : '' }}>
                                    {{ $window->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="statusFilter" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="statusFilter" id="statusFilter" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Statuses</option>
                            <option value="completed" {{ request('statusFilter') == 'completed' ? 'selected' : '' }}>Complete</option>
                            <option value="cancelled" {{ request('statusFilter') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                            Apply Filters
                        </button>
                    </div>
                </form>

                <!-- Tickets Report Grouped by Window -->
                <h3 class="text-lg font-semibold mb-4">Transaction Summary</h3>
                @foreach ($tickets->groupBy('window.name')->sortKeys()->sortByDesc(fn($key) => $key === 'Window 1') as $windowName => $windowTickets)
                    <h4 class="text-md font-semibold my-4">{{ $windowName ?? 'No Window Assigned' }}</h4>
                    <div class="overflow-x-auto mb-8">
                        <table class="min-w-full bg-white border rounded-lg shadow-lg">
                            <thead class="bg-gray-700 text-white">
                                <tr>
                                    <th class="px-6 py-3 text-left font-medium text-sm">Queue Number</th>
                                    <th class="px-6 py-3 text-left font-medium text-sm">OR Number</th>
                                    <th class="px-6 py-3 text-left font-medium text-sm">Service</th>
                                    <th class="px-6 py-3 text-left font-medium text-sm">User</th>
                                    <th class="px-6 py-3 text-left font-medium text-sm">Status</th>
                                    <th class="px-6 py-3 text-left font-medium text-sm">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($windowTickets as $ticket)
                                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200 transition duration-200">
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ $ticket->queue_number }}</td>
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ $ticket->or_number ?? 'N/A' }}</td>
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ $ticket->service->name }}</td>
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ $ticket->user->name }}</td>
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ ucfirst($ticket->status) }}</td>
                                        <td class="px-6 py-3 text-sm text-gray-700">{{ $ticket->created_at }}</td>
                                    </tr>
                                @endforeach
                                <!-- Tally -->
                                <tr class="bg-gray-200 font-semibold">
                                    <td colspan="5" class="px-6 py-3 text-right">Total Tickets</td>
                                    <td class="px-6 py-3 text-left">{{ $windowTickets->count() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach

              <!-- Feedback Report Grouped by Window -->
<h3 class="text-lg font-semibold mt-8 mb-4">Feedback Summary</h3>
@foreach ($feedback->groupBy('ticket.window.name')->sortKeys()->sortByDesc(fn($key) => $key === 'Window 1') as $windowName => $windowFeedback)
    <h4 class="text-md font-semibold my-4">{{ $windowName ?? 'No Window Assigned' }}</h4>
    <div class="overflow-x-auto mb-8">
        <table class="min-w-full bg-white border rounded-lg shadow-lg">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-sm">User</th>
                    <th class="px-6 py-3 text-left font-medium text-sm">Rating</th>
                    <th class="px-6 py-3 text-left font-medium text-sm">Comment</th>
                    <th class="px-6 py-3 text-left font-medium text-sm">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($windowFeedback as $fb)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200 transition duration-200">
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $fb->user->name }}</td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $fb->rating }} / 5</td>
                        <td class="px-6 py-3 text-sm text-gray-700" style="max-width: 200px; word-wrap: break-word; overflow: auto;">
                            {{ $fb->feedback }}
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{ $fb->created_at }}</td>
                    </tr>
                @endforeach
                <!-- Tally -->
                <tr class="bg-gray-200 font-semibold">
                    <td colspan="3" class="px-6 py-3 text-right">Average Rating</td>
                    <td class="px-6 py-3 text-left">
                        {{ number_format($windowFeedback->avg('rating'), 2) }} / 5
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endforeach


                <div class="flex justify-end mt-4">
                    <a href="{{ route('admin-reports-pdf', request()->query()) }}" target="_blank" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                        Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
