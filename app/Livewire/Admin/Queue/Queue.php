<?php

namespace App\Livewire\Admin\Queue;

use Livewire\Component;
use App\Models\Ticket;
use Carbon\Carbon;

class Queue extends Component
{
    public $queues;
    public $verificationStatus = 'all'; // Dynamic status filter
    public $newUnverifiedCount = 0; // Unverified ticket count
    public $search = ''; // Search filter

    protected $listeners = ['refreshData' => '$refresh', 'verifyTicket', 'undoVerifyTicket', 'cancelTicket'];

    public function mount()
    {
        $this->loadQueues();
        $this->countNewUnverified();
    }

    public function loadQueues()
    {
        $this->queues = Ticket::with(['user', 'service', 'window'])
            ->when($this->verificationStatus !== 'all', function ($query) {
                $query->where('verify', $this->verificationStatus);
            })
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->when($this->search, function ($query) {
                $query->where('queue_number', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function countNewUnverified()
    {
        $this->newUnverifiedCount = Ticket::where('verify', 'unverified')
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->count();
    }

    public function verifyTicket($queueNumber)
    {
        $ticket = Ticket::where('queue_number', $queueNumber)->first();
        if ($ticket) {
            $ticket->verify = 'verified';
            $ticket->verified_at = Carbon::now();
            $ticket->save();
            $this->loadQueues();
            $this->countNewUnverified();
            $this->dispatch('statusMessage', ['message' => 'Ticket has been verified successfully!']);
        }
    }

    public function undoVerifyTicket($queueNumber)
    {
        $ticket = Ticket::where('queue_number', $queueNumber)->first();
        if ($ticket) {
            $ticket->verify = 'unverified';
            $ticket->verified_at = null;
            $ticket->save();
            $this->loadQueues();
            $this->countNewUnverified();
            $this->dispatch('statusMessage', ['message' => 'Ticket verification has been undone.']);
        }
    }

    public function cancelTicket($queueNumber)
    {
        $ticket = Ticket::where('queue_number', $queueNumber)->first();
        if ($ticket) {
            $ticket->status = 'cancelled';
            $ticket->save();
            $this->loadQueues();
            $this->dispatch('statusMessage', ['message' => 'Ticket has been cancelled.']);
        }
    }

    public function render()
    {
        $this->countNewUnverified();
        return view('livewire.admin.queue.queue');
    }
}
