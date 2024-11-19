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
        $this->queues = Ticket::with(['service', 'window'])
            ->where('user_id', Auth::id()) // Only show tickets related to the authenticated user
            ->where('verify', 'verified') // Only include verified tickets
            ->whereNotIn('status', ['cancelled', 'completed']) // Exclude cancelled and completed tickets
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($ticket) {
                return [
                    'queue_number' => $ticket->queue_number,
                    'service' => $ticket->service->name ?? 'N/A',
                    'status' => ucfirst($ticket->status),
                    'assigned_window' => $ticket->window->name ?? null,
                ];
            })
            ->toArray();
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

        $isPriority = Auth::user()->usertype == 4;

        $availableWindow = Window::where('status', 'active')
            ->whereHas('services', function ($query) {
                $query->where('services.id', $this->service);
            })
            ->withCount(['tickets as priority_ticket_count' => function ($query) {
                $query->where('priority', true)->whereIn('status', ['waiting', 'in-service']);
            }])
            ->withCount(['tickets as regular_ticket_count' => function ($query) {
                $query->where('priority', false)->whereIn('status', ['waiting', 'in-service']);
            }])
            ->orderBy($isPriority ? 'priority_ticket_count' : 'regular_ticket_count')
            ->first();

        if ($availableWindow) {
            $serviceName = Service::find($this->service)->name;
            $initials = strtoupper(substr($serviceName, 0, 2));

            $ticket = Ticket::create([
                'user_id' => Auth::id(),
                'service_id' => $this->service,
                'window_id' => $availableWindow->id,
                'status' => 'waiting',
                'queue_number' => null,
                'priority' => $isPriority,
            ]);

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
