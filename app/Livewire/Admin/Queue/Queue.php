<?php

namespace App\Livewire\Admin\Queue;

use Livewire\Component;
use App\Models\Ticket;
use Carbon\Carbon;

class Queue extends Component
{
    public $queues;
    public $verificationStatus = 'all';
    public $newUnverifiedCount = 0;
    public $search = ''; // New property for search term

    protected $listeners = ['refreshData' => '$refresh'];

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
            ->when($this->search, function ($query) { // Filter by search term
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

    public function showVerified()
    {
        $this->verificationStatus = 'verified';
        $this->loadQueues();
    }

    public function showUnverified()
    {
        $this->verificationStatus = 'unverified';
        $this->newUnverifiedCount = 0; // Reset count when viewed
        $this->loadQueues();
    }

    public function verifyTicket($ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if ($ticket) {
            $ticket->verify = 'verified';
            $ticket->verified_at = Carbon::now(); // Set verified_at timestamp
            $ticket->save();
            $this->loadQueues();
            $this->countNewUnverified();
            session()->flash('verification_message', 'Ticket has been verified successfully!');
        }
    }

    public function undoVerifyTicket($ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if ($ticket) {
            $ticket->verify = 'unverified';
            $ticket->verified_at = null; // Clear the verified_at timestamp
            $ticket->save();
            $this->loadQueues();
            $this->countNewUnverified();
            session()->flash('verification_message', 'Ticket verification has been undone.');
        }
    }

    public function render()
    {
        $this->countNewUnverified(); // Keep updating count in real-time
        return view('livewire.admin.queue.queue');
    }
}
