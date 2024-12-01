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
 
     public function storeWalkIn(Request $request)
     {
         $validated = $request->validate([
             'user_id' => 'required|exists:users,id',
             'service_id' => 'required|exists:services,id',
             'priority' => 'nullable|boolean', // Optional checkbox input
         ]);
     
         $user = User::findOrFail($validated['user_id']);
     
         // Determine priority based on checkbox or usertype = 4
         $isPriority = $request->has('priority') || $user->usertype == 4;
     
         // Query windows based on priority or non-priority
         $availableWindow = Window::where('status', 'active')
             ->where('isPriority', $isPriority ? 1 : 0) // Match priority if applicable
             ->whereHas('services', function ($query) use ($validated) {
                 $query->where('services.id', $validated['service_id']);
             })
             ->withCount(['tickets' => function ($query) {
                 $query->whereIn('status', ['waiting', 'in-service']);
             }])
             ->orderBy('tickets_count') // Assign the window with the least tickets
             ->first();
     
         // If no window is found for the specific priority, fall back to any available window
         if (!$availableWindow) {
             $availableWindow = Window::where('status', 'active')
                 ->whereHas('services', function ($query) use ($validated) {
                     $query->where('services.id', $validated['service_id']);
                 })
                 ->withCount(['tickets' => function ($query) {
                     $query->whereIn('status', ['waiting', 'in-service']);
                 }])
                 ->orderBy('tickets_count')
                 ->first();
         }
     
         // If still no window is available, return an error
         if (!$availableWindow) {
             return redirect()->route('fdcashier-walkin')->with('error', 'No available windows for the selected service.');
         }
     
         // Generate queue number
         $service = Service::findOrFail($validated['service_id']);
         $serviceInitials = strtoupper(substr($service->name, 0, 2));
     
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
     














    // todo Account Management
    public function showAcc(Request $request)
{
    // Check if there's a search query
    $search = $request->input('search');

    // Fetch accounts with search functionality
    if ($search) {
        $accounts = User::where('name', 'like', '%' . $search . '%')
                        ->whereIn('usertype', [0, 4]) // Only user or special types
                        ->get();
    } else {
        // If no search query, return all accounts
        $accounts = User::whereIn('usertype', [0, 4])->get();
    }

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
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'usertype' => 'required|integer|in:0,4',
    ]);

    // Save the user
    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'usertype' => (int) $validated['usertype'], // Cast role to integer
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
       // Get filters from request, with default values
       $dateFilter = $request->get('dateFilter', 'today');
       $serviceFilter = $request->get('serviceFilter', null);
       $windowFilter = $request->get('windowFilter', null);
       $statusFilter = $request->get('statusFilter', null); // New status filter
   
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
     } elseif ($dateFilter === 'lastMonth') {
         $startDate = Carbon::now()->subMonth()->startOfMonth();
         $endDate = Carbon::now()->subMonth()->endOfMonth();
     }
 
       // Query Tickets with Filters
       $tickets = Ticket::with('service', 'user', 'window')
           ->when($serviceFilter, function ($query) use ($serviceFilter) {
               return $query->where('service_id', $serviceFilter);
           })
           ->when($windowFilter, function ($query) use ($windowFilter) {
               return $query->where('window_id', $windowFilter);
           })
           ->when($statusFilter, function ($query) use ($statusFilter) {
               return $query->where('status', $statusFilter);
           })
           ->whereBetween('created_at', [$startDate, $endDate])
           ->get();
   
       // Fetch all services and windows for filtering options
       $services = Service::all();
       $windows = Window::with('services', 'cashier')->get();
   
       // Fetch feedback summary with related window info
       $feedback = Feedback::with('user', 'ticket.window') // Include window info
           ->whereBetween('created_at', [$startDate, $endDate])
           ->when($serviceFilter, function ($query) use ($serviceFilter) {
               return $query->whereHas('ticket', function ($query) use ($serviceFilter) {
                   $query->where('service_id', $serviceFilter);
               });
           })
           ->when($windowFilter, function ($query) use ($windowFilter) {
               return $query->whereHas('ticket', function ($query) use ($windowFilter) {
                   $query->where('window_id', $windowFilter);
               });
           })
           ->get();
   
       return view('admin.reports', compact('tickets', 'services', 'feedback', 'windows', 'dateFilter', 'serviceFilter', 'windowFilter', 'statusFilter'));
    }
    



    // todo Monitor View
    public function monitor()
    {
        $queues = Ticket::all();
        return view('fdcashier.monitor.monitor', compact('queues'));
    }





}
