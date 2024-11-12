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
            $this->currentTicketId = $ticket->id; // Store the ticket ID
            
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

        // Find the window with the fewest queues for the selected service
        $availableWindow = Window::where('status', 'active')
            ->whereHas('service', function ($query) {
                $query->where('id', $this->service);
            })
            ->withCount(['tickets' => function ($query) {
                $query->whereIn('status', ['waiting', 'in-service']);
            }])
            ->orderBy('tickets_count') // Select the window with the fewest queues
            ->first();

        if ($availableWindow) {
            $serviceName = Service::find($this->service)->name;
            $initials = strtoupper(substr($serviceName, 0, 2));

            // Create a ticket without a queue number to retrieve the ticket ID
            $ticket = Ticket::create([
                'user_id' => Auth::id(),
                'service_id' => $this->service,
                'window_id' => $availableWindow->id,
                'status' => 'waiting',
                'queue_number' => null,
            ]);

            // Generate queue number using initials and ticket ID
            $queueNumber = $initials . str_pad($ticket->id, 3, '0', STR_PAD_LEFT);

            // Update the ticket with the generated queue number
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
            $this->queueNumber = null; // Reset the queue number
            $this->assignedWindow = null; // Reset the assigned window
            $this->currentTicketId = null; // Reset the ticket ID
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
