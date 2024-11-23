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
    public $showOrModal = false;
    public $orNumber;
    public $currentTicketId;

    protected $listeners = ['refreshData' => '$refresh'];

    public function mount()
    {
        $this->loadAssignedWindow();
        $this->loadQueues();
    }

    public function loadAssignedWindow()
    {
        $this->assignedWindow = Window::where('cashier_id', Auth::id())->first();
    }

    public function loadQueues()
    {
        if ($this->assignedWindow) {
            $this->queues = Ticket::with(['user', 'service', 'window'])
                ->where('window_id', $this->assignedWindow->id)
                ->where('verify', 'verified')
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            $this->queues = collect();
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

    public function openOrModal($ticketId)
    {
        $this->currentTicketId = $ticketId;
        $this->showOrModal = true;
    }

    public function closeOrModal()
    {
        $this->showOrModal = false;
        $this->orNumber = null;
    }

    public function submitOrNumber()
    {
        $this->validate([
            'orNumber' => 'required|string|max:255',
        ]);

        $ticket = Ticket::find($this->currentTicketId);
        if ($ticket && $ticket->status === 'in-service') {
            $ticket->or_number = $this->orNumber;
            $ticket->status = 'completed';
            $ticket->save();
            $this->loadQueues();
            $this->closeOrModal();
            session()->flash('message', 'Service completed and OR Number added.');
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
