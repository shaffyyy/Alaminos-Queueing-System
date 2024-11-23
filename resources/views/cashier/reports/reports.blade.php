<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Reports for Window: {{ $assignedWindow->name }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden sm:rounded-lg">
                <h1 class="text-2xl font-bold mb-6">Reports</h1>

                <form method="GET" action="{{ route('cashier-reports') }}" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="date" class="block text-gray-700 font-semibold">Date</label>
                            <input type="date" name="date" id="date" class="w-full border-gray-300 rounded-lg" value="{{ request('date') }}">
                        </div>
                    </div>
                    <div class="mt-4 flex space-x-2">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Filter</button>
                        <button type="button" onclick="window.print()" class="bg-green-500 text-white px-4 py-2 rounded-lg">Print</button>
                        <a href="{{ route('cashier-reports-pdf', request()->all()) }}" target="_blank" class="bg-red-500 text-white px-4 py-2 rounded-lg">Save as PDF</a>
                    </div>
                </form>
            
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <table class="min-w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="border border-gray-300 px-4 py-2">Queue Number</th>
                                <th class="border border-gray-300 px-4 py-2">User</th>
                                <th class="border border-gray-300 px-4 py-2">Service</th>
                                <th class="border border-gray-300 px-4 py-2">OR Number</th>
                                <th class="border border-gray-300 px-4 py-2">Status</th>
                                <th class="border border-gray-300 px-4 py-2">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tickets as $ticket)
                                <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                                    <td class="border border-gray-300 px-4 py-2">{{ $ticket->queue_number }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $ticket->user->name ?? 'N/A' }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $ticket->service->name ?? 'N/A' }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $ticket->or_number ?? 'N/A' }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ ucfirst($ticket->status) }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-500 py-4">No records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Print functionality already provided by the browser using window.print()
    </script>
</x-app-layout>
