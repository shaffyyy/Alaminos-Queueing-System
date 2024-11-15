<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Window;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;

use Illuminate\Support\Facades\Hash;

class FDCashierController extends Controller
{
    // Home Dashboard
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







    // Walk-in Management
    public function walkIn()
    {
        // Fetch users with usertype 0 (User) and 4 (PWD)
        $users = User::whereIn('usertype', [0, 4])->get();

        // Fetch services dynamically
        $services = Service::all();

        return view('fdcashier.walkin.walk-in', compact('users', 'services'));
    }


    
    public function createWalkIn()
    {
        return view('fdcashier.accounts.create-acc');
    }

    public function storeWalkIn(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'service_id' => 'required|exists:services,id',
    ]);

    $user = User::findOrFail($validated['user_id']);
    $isPriority = $user->usertype == 4; // Check if the user is PWD

    // Find the available window for the selected service
    $availableWindow = Window::where('status', 'active')
        ->whereHas('services', function ($query) use ($validated) {
            $query->where('services.id', $validated['service_id']);
        })
        ->withCount(['tickets' => function ($query) {
            $query->whereIn('status', ['waiting', 'in-service']);
        }])
        ->orderBy('tickets_count') // Window with the fewest tickets
        ->first();

    if ($availableWindow) {
        $serviceName = Service::find($validated['service_id'])->name;
        $initials = strtoupper(substr($serviceName, 0, 2));

        // Create the ticket
        $ticket = Ticket::create([
            'user_id' => $validated['user_id'],
            'service_id' => $validated['service_id'],
            'window_id' => $availableWindow->id,
            'status' => 'waiting',
            'queue_number' => null,
            'priority' => $isPriority, // Set priority based on usertype
        ]);

        // Generate queue number
        $queueNumber = $initials . str_pad($ticket->id, 3, '0', STR_PAD_LEFT);
        $ticket->queue_number = $queueNumber;
        $ticket->save();

        return redirect()->route('fdcashier-walkin')
            ->with('success', "Priority: " . ($isPriority ? "Yes" : "No") . ". Ticket #{$queueNumber} has been assigned to {$availableWindow->name}.");
    }

    return redirect()->route('fdcashier-walkin')
        ->with('error', 'No available windows for the selected service.');
}














    // Account Management
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

    // Report Management
    public function showReports()
    {
        return view('fdcashier.reports.reports');
    }

    // Monitor View
    public function monitor()
    {
        $queues = Ticket::all();
        return view('fdcashier.monitor.monitor', compact('queues'));
    }
}
