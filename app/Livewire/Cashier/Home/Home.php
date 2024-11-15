<?php

namespace App\Livewire\Cashier\Home;

use Livewire\Component;
use App\Models\Window;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    public $assignedWindow;
    public $totalQueues;
    public $activeQueues;
    public $pendingQueues;

    public function mount()
    {
        $this->loadAssignedWindowData();
    }

    public function loadAssignedWindowData()
    {
        // Fetch the assigned window based on the cashier's ID
        $this->assignedWindow = Window::where('cashier_id', Auth::id())->first();

        if ($this->assignedWindow) {
            $this->totalQueues = Ticket::where('window_id', $this->assignedWindow->id)->count();
            $this->activeQueues = Ticket::where('window_id', $this->assignedWindow->id)
                                        ->where('status', 'in-service')
                                        ->count();
            $this->pendingQueues = Ticket::where('window_id', $this->assignedWindow->id)
                                         ->where('status', 'waiting')
                                         ->count();
        } else {
            $this->totalQueues = 0;
            $this->activeQueues = 0;
            $this->pendingQueues = 0;
        }
    }

    public function render()
    {
        // Retrieve the assigned window with services and ticket counts
        $windows = $this->assignedWindow ? 
            Window::with(['services', 'tickets' => function ($query) {
                $query->whereIn('status', ['waiting', 'in-service']);
            }])
            ->withCount(['tickets'])
            ->where('id', $this->assignedWindow->id)
            ->get() 
            : collect();

        return view('livewire.cashier.home.home', [
            'windows' => $windows,
            'totalQueues' => $this->totalQueues,
            'activeQueues' => $this->activeQueues,
            'pendingQueues' => $this->pendingQueues,
        ]);
    }

}
