<div class="">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:rounded-lg">
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

                <!-- Statistics Section -->
                <div class="statistics-section mb-6 border rounded p-4 shadow bg-gray-100">
                    <h2 class="mb-4 text-xl font-semibold">Statistics</h2>
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <!-- Monthly Overview -->
                        <div class="bg-white rounded p-4 shadow">
                            <h5 class="text-lg font-bold">Monthly Overview</h5>
                            <canvas id="monthlyChart"></canvas>
                        </div>

                        <!-- Feedback Overview -->
                        <div class="bg-white rounded p-4 shadow mt-6">
                            <h5 class="text-lg font-bold">Feedback Overview</h5>
                            <div class="flex flex-wrap md:flex-nowrap items-center">
                                <!-- Average Feedback -->
                                <div class="w-full md:w-1/2 flex justify-center items-center p-4">
                                    <div class="text-center">
                                        <h6 class="font-bold text-lg">Average Feedback</h6>
                                        <p class="mt-2 text-4xl font-extrabold text-blue-600">
                                            {{ $averageFeedback }} / 5
                                        </p>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Based on {{ array_sum($feedbackData) }} feedback entries.
                                        </p>
                                    </div>
                                </div>

                                <!-- Feedback Chart -->
                                <div class="w-full md:w-1/2 flex justify-center items-center p-4">
                                    <canvas id="feedbackChart" style="max-width: 300px; max-height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
            </div>
        </div>
    </div>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Monthly Data as Bar Chart
            const monthlyLabels = {!! json_encode(array_keys($monthlyData)) !!};
            const monthlyValues = {!! json_encode(array_values($monthlyData)) !!};

            const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
            new Chart(ctxMonthly, {
                type: 'bar',
                data: {
                    labels: monthlyLabels.map(month => {
                        const monthNames = [
                            'January', 'February', 'March', 'April', 'May', 'June',
                            'July', 'August', 'September', 'October', 'November', 'December'
                        ];
                        return monthNames[month - 1];
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

            // Feedback Data as Pie Chart
            const feedbackLabels = {!! json_encode(array_keys($feedbackData)) !!};
            const feedbackValues = {!! json_encode(array_values($feedbackData)) !!};

            const ctxFeedback = document.getElementById('feedbackChart').getContext('2d');
            new Chart(ctxFeedback, {
                type: 'pie',
                data: {
                    labels: feedbackLabels.map(rating => `${rating} Stars`),
                    datasets: [{
                        label: 'Feedback Distribution',
                        data: feedbackValues,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>
</div>
