<div class="py-12 bg-slate-200">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="main-content container mx-auto px-5 py-3">
                <!-- Dashboard Overview -->
                <div class="overview-section mb-6 border rounded p-4 shadow bg-gray-100">
                    <h2 class="mb-4 text-xl font-semibold">Dashboard Overview</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-500 text-white rounded p-4 shadow">
                            <h5 class="text-lg font-bold">Total Queues</h5>
                            <p class="text-3xl">{{ $totalQueues }}</p>
                        </div>
                        <div class="bg-green-500 text-white rounded p-4 shadow">
                            <h5 class="text-lg font-bold">Active Queues</h5>
                            <p class="text-3xl">{{ $activeQueues }}</p>
                        </div>
                        <div class="bg-red-500 text-white rounded p-4 shadow">
                            <h5 class="text-lg font-bold">Pending Queues</h5>
                            <p class="text-3xl">{{ $pendingQueues }}</p>
                        </div>
                    </div>
                </div>

                <!-- Real-Time Table of Windows -->
                <div class="recent-activities-section border rounded p-4 shadow bg-gray-100" wire:poll.5s>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Windows</h2>
                        <a href="{{route('cashier-queue')}}" class="bg-blue-500 text-white py-2 px-4 rounded">See More</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Window</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Status</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Service</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Current Queues</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($windows as $window)
                                    <tr>
                                        <td class="px-4 py-2">{{ $window->name }}</td>
                                        <td class="px-4 py-2 {{ $window->status === 'active' ? 'text-green-500' : 'text-red-500' }}">
                                            {{ ucfirst($window->status) }}
                                        </td>
                                        <td class="px-4 py-2">{{ $window->service->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">
                                            {{ $window->tickets_count }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
