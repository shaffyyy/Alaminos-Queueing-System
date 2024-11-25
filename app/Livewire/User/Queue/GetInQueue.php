<?php

namespace App\Livewire\User\Queue;

use App\Models\Window;
use App\Models\Ticket;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GetInQueue extends Component
{
    public $service;
    public $queueNumber;
    public $pendingVerificationMessage = false;
    public $assignedWindow;
    public $currentTicketId;
    public $queuePosition;
    public $queues = []; // For monitoring

    public function mount()
    {
        $this->loadQueueStatus();
        $this->loadQueueMonitoring();
    }

    public function loadQueueStatus()
    {
        $ticket = Ticket::where('user_id', Auth::id())
            ->whereNotIn('status', ['cancelled']) // Exclude cancelled tickets
            ->whereIn('status', ['waiting', 'in-service'])
            ->latest()
            ->first();

        if ($ticket) {
            $this->queueNumber = $ticket->queue_number;
            $this->pendingVerificationMessage = ($ticket->status === 'waiting' && $ticket->verify === 'unverified');
            $this->currentTicketId = $ticket->id;

            if ($ticket->verify === 'verified' && $ticket->window) {
                $this->assignedWindow = $ticket->window->name ?? 'N/A';
            }

            // Calculate queue position
            $this->queuePosition = Ticket::where('service_id', $ticket->service_id)
                ->where('status', 'waiting')
                ->where('created_at', '<=', $ticket->created_at)
                ->count();
        } else {
            $this->queueNumber = null;
            $this->pendingVerificationMessage = false;
            $this->assignedWindow = null;
            $this->currentTicketId = null;
        }
    }

    public function loadQueueMonitoring()
    {
        $currentTicket = Ticket::with(['service', 'window'])
            ->where('user_id', Auth::id())
            ->where('verify', 'verified')
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->latest()
            ->first();

        if ($currentTicket && $currentTicket->window) {
            $this->queues = Ticket::with(['service'])
                ->where('window_id', $currentTicket->window->id)
                ->whereNotIn('status', ['cancelled', 'completed'])
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function ($ticket) {
                    return [
                        'queue_number' => $ticket->queue_number,
                        'service' => $ticket->service->name ?? 'N/A',
                        'status' => ucfirst($ticket->status),
                    ];
                })
                ->toArray();
        } else {
            $this->queues = [];
        }
    }

    public function joinQueue()
{
    if (!Auth::user()->hasVerifiedEmail()) {
        session()->flash('error', 'Please verify your email to join the queue.');
        return;
    }

    $this->validate([
        'service' => 'required|exists:services,id',
    ]);

    // Determine if the user is priority based on usertype
    $isPriority = Auth::user()->usertype == 4;

    // Attempt to find a window matching the priority
    $availableWindow = Window::where('status', 'active')
        ->where('isPriority', $isPriority ? 1 : 0) // Match priority windows
        ->whereHas('services', function ($query) {
            $query->where('services.id', $this->service);
        })
        ->withCount(['tickets as waiting_tickets_count' => function ($query) {
            $query->whereIn('status', ['waiting', 'in-service']);
        }])
        ->orderBy('waiting_tickets_count') // Assign the least busy window
        ->first();

    // Fallback: Assign to any available window if no priority match is found
    if (!$availableWindow) {
        $availableWindow = Window::where('status', 'active')
            ->whereHas('services', function ($query) {
                $query->where('services.id', $this->service);
            })
            ->withCount(['tickets as waiting_tickets_count' => function ($query) {
                $query->whereIn('status', ['waiting', 'in-service']);
            }])
            ->orderBy('waiting_tickets_count')
            ->first();
    }

    // If no window is found, return an error
    if (!$availableWindow) {
        session()->flash('error', 'No available windows for the selected service.');
        return;
    }

    // Generate queue number
    $service = Service::findOrFail($this->service);
    $serviceInitials = strtoupper(substr($service->name, 0, 2));

    $ticket = Ticket::create([
        'user_id' => Auth::id(),
        'service_id' => $this->service,
        'window_id' => $availableWindow->id,
        'status' => 'waiting',
        'priority' => $isPriority,
    ]);

    $queueNumber = $serviceInitials . str_pad($ticket->id, 3, '0', STR_PAD_LEFT);
    $ticket->queue_number = $queueNumber;
    $ticket->save();

    $this->queueNumber = $ticket->queue_number;
    $this->pendingVerificationMessage = true;
    $this->assignedWindow = $availableWindow->name;
    $this->currentTicketId = $ticket->id;

    session()->flash('message', 'You have joined the queue!');
    $this->reset('service');
}


    public function cancelTicket($ticketId)
    {
        $ticket = Ticket::where('user_id', Auth::id())->where('id', $ticketId)->first();
        if ($ticket) {
            $ticket->status = 'cancelled';
            $ticket->save();
            session()->flash('message', 'Your ticket has been cancelled.');
            $this->queueNumber = null;
            $this->assignedWindow = null;
            $this->currentTicketId = null;
        } else {
            session()->flash('error', 'Ticket not found or already cancelled.');
        }
    }

    public function startService($ticketId)
    {
        $ticket = Ticket::find($ticketId);

        if ($ticket && $ticket->status === 'waiting') {
            $ticket->status = 'in-service';
            $ticket->save();

            $this->emit('statusUpdated', $ticket->queue_number, $ticket->status);

            session()->flash('message', 'The ticket has been moved to in-service.');
        } else {
            session()->flash('error', 'Invalid ticket or status.');
        }
    }

    public function render()
    {
        $services = Service::all();

        return view('livewire.user.queue.get-in-queue', [
            'services' => $services,
        ]);
    }
}
