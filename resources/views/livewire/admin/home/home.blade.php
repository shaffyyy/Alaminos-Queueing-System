<div wire:poll.10s class="">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
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
                            <!-- Chart or Graph Here -->
                            <canvas id="monthlyChart"></canvas>
                        </div>
                        <div class="bg-white rounded p-4 shadow">
                            <h5 class="text-lg font-bold">Yearly Overview</h5>
                            <!-- Chart or Graph Here -->
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
                        {{-- <a href="{{ route('admin.windows') }}" class="bg-blue-500 text-white py-2 px-4 rounded">See More</a> --}}
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Window</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Status</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Service</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Verified Queues</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($windows as $window)
                                    <tr>
                                        <td class="px-4 py-2">{{ $window->name }}</td>
                                        <td class="px-4 py-2 {{ $window->status === 'online' ? 'text-green-500' : 'text-red-500' }}">{{ ucfirst($window->status) }}</td>
                                        <td class="px-4 py-2">{{ $window->service->name ?? 'No Service Assigned' }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <!-- Count verified tickets for this window -->
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

    <!-- SweetAlert and Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Monthly Pie Chart
        var ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
        var monthlyChart = new Chart(ctxMonthly, {
            type: 'doughnut',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Monthly Data',
                    data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)',
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });

        // Yearly Pie Chart
        var ctxYearly = document.getElementById('yearlyChart').getContext('2d');
        var yearlyChart = new Chart(ctxYearly, {
            type: 'doughnut',
            data: {
                labels: ['2018', '2019', '2020', '2021', '2022', '2023', '2024'],
                datasets: [{
                    label: 'Yearly Data',
                    data: [100, 200, 300, 400, 500, 600, 700],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)',
                        'rgba(255, 99, 196)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 196, 1)'
                    ],
                    borderWidth: 3
                }]
            }
        });
    </script>
</div>
