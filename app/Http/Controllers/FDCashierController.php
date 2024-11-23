<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Service;
use App\Models\Window;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;

use Illuminate\Support\Facades\Hash;

class FDCashierController extends Controller
{
    // todo Home Dashboard
    public function index()
    {
        return view('fdcashier.home.home');
    }

    // Show Queues
    public function showQueue()
    {
        $queues = Ticket::where('status', 'waiting')->orWhere('status', 'in-service')->get();
        return view('fdcashier.queue.queue', compact('queues'));
    }







    // todo Walk-in Management
     // Walk-in Form
     public function walkIn()
     {
         $users = User::whereIn('usertype', [0, 4])->get();
         $services = Service::all();
 
         return view('fdcashier.walkin.walk-in', compact('users', 'services'));
     }
 
     // Generate Queue Number
     public function getNextQueueNumber(Request $request)
     {
         $request->validate([
             'service_id' => 'required|exists:services,id',
         ]);
 
         $service = Service::findOrFail($request->service_id);
         $serviceInitials = strtoupper(substr($service->name, 0, 2));
 
         // Fetch next ticket ID for generating the queue number
         $nextTicketId = Ticket::max('id') + 1;
         $queueNumber = $serviceInitials . str_pad($nextTicketId, 3, '0', STR_PAD_LEFT);
 
         return response()->json(['queueNumber' => $queueNumber]);
     }
 
     // Store Walk-in Ticket
     public function storeWalkIn(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'service_id' => 'required|exists:services,id',
        'priority' => 'nullable|boolean', // Optional checkbox input
    ]);

    $user = User::findOrFail($validated['user_id']);

    // Priority is based on either the checkbox or usertype = 4
    $isPriority = $request->has('priority') || $user->usertype == 4;

    $availableWindow = Window::where('status', 'active')
        ->whereHas('services', function ($query) use ($validated) {
            $query->where('services.id', $validated['service_id']);
        })
        ->withCount(['tickets' => function ($query) {
            $query->whereIn('status', ['waiting', 'in-service']);
        }])
        ->orderBy('tickets_count')
        ->first();

    if ($availableWindow) {
        $service = Service::find($validated['service_id']);
        $serviceInitials = strtoupper(substr($service->name, 0, 2));

        // Create ticket and assign queue number
        $ticket = Ticket::create([
            'user_id' => $validated['user_id'],
            'service_id' => $validated['service_id'],
            'window_id' => $availableWindow->id,
            'status' => 'waiting',
            'priority' => $isPriority,
        ]);

        $queueNumber = $serviceInitials . str_pad($ticket->id, 3, '0', STR_PAD_LEFT);
        $ticket->queue_number = $queueNumber;
        $ticket->save();

        return redirect()->route('fdcashier-walkin')->with('success', "Ticket #{$queueNumber} has been assigned to window {$availableWindow->name}.");
    }

    return redirect()->route('fdcashier-walkin')->with('error', 'No available windows for the selected service.');
}















    // todo Account Management
    public function showAcc()
    {
        $accounts = User::whereIn('usertype', [0, 4])->get(); // 0 = user, 4 = pwd
        return view('fdcashier.accounts.view-acc', compact('accounts'));
    }
    
    public function createAcc()
    {
        return view('fdcashier.accounts.create-acc');
    }

    public function storeAcc(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:0,4', // Use 'in' to specify allowed values
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'usertype' => $validated['role'], // Use 'usertype' instead of 'role'
        ]);

        return redirect()->route('fdcashier-accounts')->with('success', 'Account created successfully.');
    }

    public function editAcc($id)
    {
        $account = User::findOrFail($id);
        return view('fdcashier.accounts.edit-acc', compact('account'));
    }
    

    public function updateAcc(Request $request, $id)
    {
        $account = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:0,4', // Allow only user (0) and pwd (4)
        ]);

        $account->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'usertype' => $validated['role'], // Update usertype
        ]);

        return redirect()->route('fdcashier-accounts')->with('success', 'Account updated successfully.');
    }

    public function deleteAcc($id)
    {
        $account = User::findOrFail($id);

        $account->delete();

        return redirect()->route('fdcashier-accounts')->with('success', 'Account deleted successfully.');
    }

    // todo Report Management
    // public function showReports()
    // {
    //     return view('fdcashier.reports.reports');
    // }

    
    // Report functionality
    public function showReports(Request $request)
    {
        // Filters
        $dateFilter = $request->get('dateFilter', 'today');
        $serviceFilter = $request->get('serviceFilter', null);
        $windowFilter = $request->get('windowFilter', null);
    
        // Date Range Logic
        $startDate = Carbon::today();
        $endDate = Carbon::now();
    
        if ($dateFilter === 'yesterday') {
            $startDate = Carbon::yesterday();
            $endDate = Carbon::yesterday()->endOfDay();
        } elseif ($dateFilter === '7days') {
            $startDate = Carbon::now()->subDays(6);
            $endDate = Carbon::now();
        } elseif ($dateFilter === 'thisMonth') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now();
        }
    
        // Query Tickets with Filters
        $tickets = Ticket::with('service', 'user', 'window')
            ->when($serviceFilter, function ($query) use ($serviceFilter) {
                return $query->where('service_id', $serviceFilter);
            })
            ->when($windowFilter, function ($query) use ($windowFilter) {
                return $query->where('window_id', $windowFilter);
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
    
        // Fetch all services and windows for filtering options
        $services = Service::all();
        $windows = Window::with('services', 'cashier')->get();
    
        // Fetch feedback summary
        $feedback = Feedback::with('user', 'ticket')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
    
        return view('fdcashier.reports.reports', compact('tickets', 'services', 'feedback', 'windows', 'dateFilter', 'serviceFilter', 'windowFilter'));
    }
    



    // todo Monitor View
    public function monitor()
    {
        $queues = Ticket::all();
        return view('fdcashier.monitor.monitor', compact('queues'));
    }





}
