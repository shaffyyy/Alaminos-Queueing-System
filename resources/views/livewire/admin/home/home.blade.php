<div class="">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:rounded-lg">
            <!-- Main Content -->
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
                <!-- End Dashboard Overview -->

                <!-- Statistics Section -->
                <div class="statistics-section mb-6 border rounded p-4 shadow bg-gray-100">
                    <h2 class="mb-4 text-xl font-semibold">Statistics</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white rounded p-4 shadow">
                            <h5 class="text-lg font-bold">Monthly Overview</h5>
                            <canvas id="monthlyChart"></canvas>
                        </div>
                        <div class="bg-white rounded p-4 shadow">
                            <h5 class="text-lg font-bold">Yearly Overview</h5>
                            <canvas id="yearlyChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- End Statistics Section -->

                <!-- Table of Windows -->
                <div class="recent-activities-section border rounded p-4 shadow bg-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Windows</h2>
                        <a href="" class="bg-blue-500 text-white py-2 px-4 rounded">See More</a>
                    </div>
                    <div class="overflow-x-auto bg-gray-50 rounded-lg shadow-lg">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead class="bg-gray-600 text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium">Window</th>
                                    <th class="px-4 py-2 text-left font-medium">Status</th>
                                    <th class="px-4 py-2 text-left font-medium">Service</th>
                                    <th class="px-4 py-2 text-left font-medium">Verified Queues</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($windows as $window)
                                    <tr class="{{ $loop->even ? 'bg-gray-200' : 'bg-gray-100' }} hover:bg-gray-300 transition duration-200">
                                        <td class="px-4 py-2 text-gray-700 font-semibold">{{ $window->name }}</td>
                                        <td class="px-4 py-2 {{ $window->status === 'online' ? 'text-green-500' : 'text-red-500' }}">
                                            {{ ucfirst($window->status) }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-600">
                                            @if($window->services->isNotEmpty())
                                                {{ $window->services->pluck('name')->join(', ') }}
                                            @else
                                                No Service Assigned
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 text-center text-gray-600">
                                            {{ $window->tickets()->where('verify', 'verified')->count() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Table of Windows -->
            </div>
            <!-- End Main Content -->
        </div>
    </div>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Monthly Data as Bar Chart
            var monthlyLabels = {!! json_encode(array_keys($monthlyData)) !!};
            var monthlyValues = {!! json_encode(array_values($monthlyData)) !!};

            var ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
            var monthlyChart = new Chart(ctxMonthly, {
                type: 'bar',
                data: {
                    labels: monthlyLabels.map(month => {
                        const monthNames = [
                            'January', 'February', 'March', 'April', 'May', 'June',
                            'July', 'August', 'September', 'October', 'November', 'December'
                        ];
                        return monthNames[month - 1]; // Convert month number to name
                    }),
                    datasets: [{
                        label: 'Monthly Tickets',
                        data: monthlyValues,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Yearly Data as Line Chart
            var yearlyLabels = {!! json_encode(array_keys($yearlyData)) !!};
            var yearlyValues = {!! json_encode(array_values($yearlyData)) !!};

            var ctxYearly = document.getElementById('yearlyChart').getContext('2d');
            var yearlyChart = new Chart(ctxYearly, {
                type: 'line',
                data: {
                    labels: yearlyLabels,
                    datasets: [{
                        label: 'Yearly Tickets',
                        data: yearlyValues,
                        backgroundColor: 'rgba(54, 162, 235, 0.4)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</div>
