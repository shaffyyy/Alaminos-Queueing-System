<?php

namespace App\Livewire\Cashier\VisitQueue;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Window;

class VisitPage extends Component
{
    public $windows;
    public $selectedWindowId = null;
    public $tickets = [];

    public function mount()
    {
        // Load all windows
        $this->windows = Window::all();
    }

    public function updatedSelectedWindowId()
    {
        // Load tickets for the selected window
        if ($this->selectedWindowId) {
            $this->tickets = Ticket::with(['user', 'service', 'window'])
                ->where('window_id', $this->selectedWindowId)
                ->where('verify', 'verified')
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            $this->tickets = [];
        }
    }

    public function render()
    {
        return view('livewire.cashier.visit-queue.visit-page', [
            'tickets' => $this->tickets,
        ]);
    }
}
