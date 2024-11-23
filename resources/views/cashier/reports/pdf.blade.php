<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .header {
            margin-bottom: 20px;
            text-align: center;
        }
        .header h2 {
            margin: 0;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Reports for Window: {{ $assignedWindow->name }}</h2>
        <p>Date: {{ \Carbon\Carbon::now()->format('Y-m-d') }}</p>
        <p>Time: {{ \Carbon\Carbon::now()->format('h:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Queue Number</th>
                <th>User</th>
                <th>Service</th>
                <th>OR Number</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->queue_number }}</td>
                    <td>{{ $ticket->user->name ?? 'N/A' }}</td>
                    <td>{{ $ticket->service->name ?? 'N/A' }}</td>
                    <td>{{ $ticket->or_number ?? 'N/A' }}</td>
                    <td>{{ ucfirst($ticket->status) }}</td>
                    <td>{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
