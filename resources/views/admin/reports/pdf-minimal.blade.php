<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QMI Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        .table-wrapper {
            overflow-x: auto; /* Enable horizontal scroll for smaller screens */
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th {
            background-color: #374151; /* Dark gray header */
            color: white;
            text-align: left;
            padding: 10px;
        }
        .table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .table tr:nth-child(even) {
            background-color: #f9fafb; /* Light gray for alternate rows */
        }
        .table tr:nth-child(odd) {
            background-color: white; /* White for other rows */
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
        h1, h2 {
            color: #1f2937; /* Dark text color */
        }
        /* Ensure comments wrap properly and do not overflow */
        .feedback-column {
            max-width: 250px; /* Adjust width as needed */
            word-wrap: break-word; /* Break long words */
            overflow: hidden;
            text-overflow: ellipsis; /* Add ellipsis for long text */
        }
    </style>
</head>
<body>
    <div class="printThisPart">
        <!-- PDF Header -->
        <h1 class="text-center">Alaminos City Hall - QMI Report</h1>
        <p class="text-center">Generated on: {{ now()->format('F j, Y, g:i a') }}</p>

        <!-- Tickets Summary -->
        <h2 class="mb-4">Tickets Summary</h2>
        <div class="table-wrapper">
            <table class="table mb-4">
                <thead>
                    <tr>
                        <th>Queue Number</th>
                        <th>OR Number</th>
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
                            <td>{{ $ticket->or_number ?? 'N/A' }}</td>
                            <td>{{ $ticket->service->name }}</td>
                            <td>{{ $ticket->user->name }}</td>
                            <td>{{ $ticket->window->name ?? 'N/A' }}</td>
                            <td>{{ ucfirst($ticket->status) }}</td>
                            <td>{{ $ticket->created_at->format('F j, Y, g:i a') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No tickets found for the selected filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Feedback Summary -->
        <h2 class="mb-4">User Feedback</h2>
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Window</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($feedback as $fb)
                        <tr>
                            <td>{{ $fb->user->name }}</td>
                            <td>{{ $fb->rating }} / 5</td>
                            <td class="feedback-column">{{ $fb->feedback }}</td> <!-- Added class for wrapping text -->
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $fb->ticket->window->name ?? 'N/A' }}</td> 
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
</body>
</html>
