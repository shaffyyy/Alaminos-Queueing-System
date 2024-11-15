<x-app-layout>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .print-section, .print-section * {
                visibility: visible;
            }
            .print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
    
    <x-slot name="header">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Reports
            </h1>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-4">
                    <h2 class="text-xl font-semibold mb-2">Available Reports</h2>

                    <!-- Reports Table wrapped in print-section -->
                    <div class="print-section">
                        <table class="min-w-full bg-white border">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border">Report Type</th>
                                    <th class="py-2 px-4 border">Date Range</th>
                                    <th class="py-2 px-4 border">Created At</th>
                                    <th class="py-2 px-4 border">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border">Daily Report</td>
                                    <td class="py-2 px-4 border">2023-01-01 to 2023-01-31</td>
                                    <td class="py-2 px-4 border">2023-02-01</td>
                                    <td class="py-2 px-4 border">
                                        <a href="#" class="text-blue-500">View</a> |
                                        <a href="#" class="text-blue-500">Download</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border">Weekly Report</td>
                                    <td class="py-2 px-4 border">2023-01-01 to 2023-01-07</td>
                                    <td class="py-2 px-4 border">2023-01-08</td>
                                    <td class="py-2 px-4 border">
                                        <a href="#" class="text-blue-500">View</a> |
                                        <a href="#" class="text-blue-500">Download</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border">Monthly Report</td>
                                    <td class="py-2 px-4 border">2023-01-01 to 2023-01-31</td>
                                    <td class="py-2 px-4 border">2023-02-01</td>
                                    <td class="py-2 px-4 border">
                                        <a href="#" class="text-blue-500">View</a> |
                                        <a href="#" class="text-blue-500">Download</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Print Button -->
                <div class="flex justify-end">
                    <button onclick="window.print()" class="bg-green-500 text-white px-4 py-2 rounded-md">
                        Print Reports
                    </button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
