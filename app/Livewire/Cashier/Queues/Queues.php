<?php

namespace App\Livewire\Cashier\Queues;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Window;
use Illuminate\Support\Facades\Auth;

class Queues extends Component
{
    public $queues;
    public $assignedWindow;

    protected $listeners = ['refreshData' => '$refresh'];

    public function mount()
    {
        $this->loadAssignedWindow();
        $this->loadQueues();
    }

    public function loadAssignedWindow()
    {
        // Fetch the window assigned to the logged-in cashier
        $this->assignedWindow = Window::where('cashier_id', Auth::id())->first();
    }

    public function loadQueues()
    {
        if ($this->assignedWindow) {
            $this->queues = Ticket::with(['user', 'service', 'window'])
                ->where('window_id', $this->assignedWindow->id) // Filter by assigned window
                ->where('verify', 'verified') // Only include verified tickets
                ->whereNotIn('status', ['completed', 'cancelled']) // Exclude completed and cancelled tickets
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            $this->queues = collect(); // Empty collection if no window assigned
        }
    }

    public function startService($ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if ($ticket && $ticket->status === 'waiting') {
            $ticket->status = 'in-service';
            $ticket->save();
            $this->loadQueues();
            session()->flash('message', 'Service started for ticket.');
        }
    }

    public function completeService($ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if ($ticket && $ticket->status === 'in-service') {
            $ticket->status = 'completed';
            $ticket->save();
            $this->loadQueues();
            session()->flash('message', 'Service completed for ticket.');
        }
    }

    public function cancelQueue($ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if ($ticket && in_array($ticket->status, ['waiting', 'in-service'])) {
            $ticket->status = 'cancelled';
            $ticket->save();
            $this->loadQueues();
            session()->flash('message', 'The ticket has been successfully cancelled.');
        }
    }

    public function render()
    {
        return view('livewire.cashier.queues.queues', [
            'assignedWindow' => $this->assignedWindow,
        ]);
    }



}
