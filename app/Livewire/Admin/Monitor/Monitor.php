<?php

namespace App\Livewire\Admin\Monitor;

use Livewire\Component;
use App\Models\Ticket;

class Monitor extends Component
{
    public $tickets;
    public $showUnverified = false;

    public function mount()
    {
        $this->loadTickets();
    }

    public function loadTickets()
    {
        $this->tickets = Ticket::where('status', '!=', 'completed')
            ->where('verify', $this->showUnverified ? 'unverified' : 'verified')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function toggleUnverified()
    {
        $this->showUnverified = !$this->showUnverified;
        $this->loadTickets();
    }

    public function render()
    {
        return view('livewire.admin.monitor.monitor', [
            'tickets' => $this->tickets,
        ]);
    }

    public function refreshTickets()
    {
        $this->loadTickets();
    }
}
