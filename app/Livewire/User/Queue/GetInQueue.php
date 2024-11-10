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

    public function mount()
    {
        $this->loadQueueStatus();
    }

    public function loadQueueStatus()
    {
        $ticket = Ticket::where('user_id', Auth::id())
                        ->whereIn('status', ['waiting', 'in-service', 'completed'])
                        ->latest()
                        ->first();

        if ($ticket) {
            $this->queueNumber = $ticket->queue_number;
            $this->pendingVerificationMessage = ($ticket->status === 'waiting' && $ticket->verify === 'unverified');
            
            // If the ticket is verified, get the assigned window
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

        $availableWindow = Window::where('status', 'active')->first();

        if ($availableWindow) {
            $serviceName = Service::find($this->service)->name;

            // Define prefix based on service
            $queuePrefix = match ($serviceName) {
                'Cedula' => 'C',
                'Business tax' => 'BT',
                'Real Property Tax' => 'RPT',
                'Clearance' => 'CL',
                'Other Fee or Charges' => 'OF',
                default => 'Q'
            };

            // Count tickets for this service to keep numbering unique per service
            $ticketCount = Ticket::where('service_id', $this->service)->count() + 1;
            $queueNumber = $queuePrefix . str_pad($ticketCount, 3, '0', STR_PAD_LEFT);

            // Create ticket with queue_number
            $ticket = Ticket::create([
                'user_id' => Auth::id(),
                'service_id' => $this->service,
                'window_id' => $availableWindow->id,
                'status' => 'waiting',
                'queue_number' => $queueNumber,
            ]);

            $this->queueNumber = $ticket->queue_number;
            $this->pendingVerificationMessage = true;

            session()->flash('message', 'You have joined the queue!');
            $this->reset('service');
        } else {
            session()->flash('error', 'No available windows at the moment.');
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
