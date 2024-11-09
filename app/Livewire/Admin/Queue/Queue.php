<?php

namespace App\Livewire\Admin\Queue;

use Livewire\Component;
use App\Models\Ticket;

class Queue extends Component
{
    public $queues;
    public $verificationStatus = 'all';

    protected $listeners = ['refreshData' => '$refresh'];

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
            session()->flash('verification_message', 'Ticket has been verified successfully!');
        }
    }

    public function undoVerifyTicket($ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if ($ticket) {
            $ticket->verify = 'unverified';
            $ticket->save();
            $this->loadQueues();
            session()->flash('verification_message', 'Ticket verification has been undone.');
        }
    }

    public function render()
    {
        return view('livewire.admin.queue.queue');
    }
}
