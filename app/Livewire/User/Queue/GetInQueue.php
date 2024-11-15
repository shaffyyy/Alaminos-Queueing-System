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

    public function mount()
    {
        $this->loadQueueStatus();
    }

    public function loadQueueStatus()
    {
        $ticket = Ticket::where('user_id', Auth::id())
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

        // Check if the user is PWD (usertype == 4) to assign priority
        $isPriority = Auth::user()->usertype == 4;

        // Find the available window for the selected service
        $availableWindow = Window::where('status', 'active')
            ->whereHas('services', function ($query) {
                $query->where('services.id', $this->service); // Use alias to avoid ambiguity
            })
            ->withCount(['tickets' => function ($query) use ($isPriority) {
                $query->whereIn('status', ['waiting', 'in-service']);
                if ($isPriority) {
                    $query->where('priority', true); // Prioritize for PWD users
                }
            }])
            ->orderBy('tickets_count') // Select the window with the fewest queues
            ->first();

        if ($availableWindow) {
            $serviceName = Service::find($this->service)->name;
            $initials = strtoupper(substr($serviceName, 0, 2));

            // Create a ticket
            $ticket = Ticket::create([
                'user_id' => Auth::id(),
                'service_id' => $this->service,
                'window_id' => $availableWindow->id,
                'status' => 'waiting',
                'queue_number' => null,
                'priority' => $isPriority,
            ]);

            // Generate the queue number
            $queueNumber = $initials . str_pad($ticket->id, 3, '0', STR_PAD_LEFT);
            $ticket->queue_number = $queueNumber;
            $ticket->save();

            $this->queueNumber = $ticket->queue_number;
            $this->pendingVerificationMessage = true;
            $this->assignedWindow = $availableWindow->name;
            $this->currentTicketId = $ticket->id;

            session()->flash('message', 'You have joined the queue!');
            $this->reset('service');
        } else {
            session()->flash('error', 'No available windows for the selected service at the moment.');
        }
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

    public function render()
    {
        $services = Service::all();

        return view('livewire.user.queue.get-in-queue', [
            'services' => $services,
        ]);
    }
}
