<?php

namespace App\Livewire\Fdcashier\Queue;

use Livewire\Component;
use App\Models\Ticket;

class Queue extends Component
{
    public $queues;
    public $verificationStatus = 'all';
    public $searchTerm = '';

    protected $listeners = ['verifyTicket', 'undoVerifyTicket', 'cancelTicket'];

    public function mount()
    {
        $this->loadQueues();
    }

    public function loadQueues()
    {
        $this->queues = Ticket::with(['user', 'service', 'window'])
            ->when($this->verificationStatus !== 'all', function ($query) {
                $query->where('verify', $this->verificationStatus);
            })
            ->when($this->searchTerm, function ($query) {
                $query->where('id', $this->searchTerm);
            })
            ->where('status', '!=', 'completed')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function verifyTicket($ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if ($ticket) {
            $ticket->verify = 'verified';
            $ticket->save();
            $this->loadQueues();
            $this->dispatchBrowserEvent('statusMessage', 'Ticket verified successfully!');
        }
    }

    public function undoVerifyTicket($ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if ($ticket) {
            $ticket->verify = 'unverified';
            $ticket->save();
            $this->loadQueues();
            $this->dispatchBrowserEvent('statusMessage', 'Ticket verification undone.');
        }
    }

    public function cancelTicket($ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if ($ticket) {
            $ticket->status = 'cancelled';
            $ticket->save();
            $this->loadQueues();
            $this->dispatchBrowserEvent('statusMessage', 'Ticket cancelled successfully!');
        }
    }

    public function render()
    {
        return view('livewire.fdcashier.queue.queue');
    }
}
