<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Ticket;
use App\Models\Window;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function  index()
    {
        return view('cashier.home.home');
    }

    public function showReports(Request $request)
{
    // Get the authenticated user
    $cashier = auth()->user();

    // Check if the cashier has an assigned window
    $assignedWindow = Window::where('cashier_id', $cashier->id)->first();

    if (!$assignedWindow) {
        // If no window is assigned, return empty results
        return view('cashier.reports.reports', [
            'tickets' => [],
            'services' => Service::all(),
            'windows' => [],
            'filters' => [],
        ])->with('error', 'No assigned window found for your account.');
    }

    // Fetch filters if any (e.g., by date, service)
    $filters = [
        'date' => $request->input('date'),
        'service' => $request->input('service'),
    ];

    // Fetch tickets for the assigned window and apply optional filters
    $tickets = Ticket::with(['service', 'user'])
        ->where('window_id', $assignedWindow->id)
        ->when($filters['date'], function ($query, $date) {
            $query->whereDate('created_at', $date);
        })
        ->when($filters['service'], function ($query, $serviceId) {
            $query->where('service_id', $serviceId);
        })
        ->get();

    // Fetch all services for filtering options
    $services = Service::all();

    return view('cashier.reports.reports', compact('tickets', 'services', 'filters', 'assignedWindow'));
}

public function exportToPDF(Request $request)
{
    // Fetch filters if any
    $filters = [
        'date' => $request->input('date'),
    ];

    $cashier = auth()->user();
    $assignedWindow = Window::where('cashier_id', $cashier->id)->first();

    if (!$assignedWindow) {
        return back()->with('error', 'No assigned window found for your account.');
    }

    // Fetch tickets for the assigned window
    $tickets = Ticket::with(['service', 'user'])
        ->where('window_id', $assignedWindow->id)
        ->when($filters['date'], function ($query, $date) {
            $query->whereDate('created_at', $date);
        })
        ->get();

    // Generate PDF
    $pdf = \PDF::loadView('cashier.reports.pdf', compact('tickets', 'assignedWindow'));
    return $pdf->download('reports.pdf');
}



    public function showQueue()
    {
        return view('cashier.queues.queues-index');
    }
}
