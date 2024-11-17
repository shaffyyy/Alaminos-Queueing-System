<x-app-layout>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .text-bold {
            font-weight: bold;
        }
        .mb-4 {
            margin-bottom: 16px;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Generate PDF
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="printThisPart bg-white shadow-xl sm:rounded-lg p-6">
                <!-- PDF Header -->
                <h1 class="text-center">Alaminos City Hall - QMI Report</h1>
                <p class="text-center">Generated on: {{ now()->format('F j, Y, g:i a') }}</p>

                <!-- Tickets Summary -->
                <h2 class="mb-4">Tickets Summary</h2>
                <table class="table mb-4">
                    <thead>
                        <tr>
                            <th>Queue Number</th>
                            <th>Service</th>
                            <th>User</th>
                            <th>Window</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->queue_number }}</td>
                                <td>{{ $ticket->service->name }}</td>
                                <td>{{ $ticket->user->name }}</td>
                                <td>{{ $ticket->window->name ?? 'N/A' }}</td>
                                <td>{{ ucfirst($ticket->status) }}</td>
                                <td>{{ $ticket->created_at->format('F j, Y, g:i a') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No tickets found for the selected filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Feedback Summary -->
                <h2 class="mb-4">User Feedback</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($feedback as $fb)
                            <tr>
                                <td>{{ $fb->user->name }}</td>
                                <td>{{ $fb->rating }} / 5</td>
                                <td>{{ $fb->feedback }}</td>
                                <td>{{ $fb->created_at->format('F j, Y, g:i a') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No feedback found for the selected filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
