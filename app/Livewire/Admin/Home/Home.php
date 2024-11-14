<?php

namespace App\Livewire\Admin\Home;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Window;  // Import Window model
use Carbon\Carbon;

class Home extends Component
{
    public $totalQueues;
    public $activeQueues;
    public $pendingQueues;
    public $windows;  // Define windows property

    protected $listeners = ['refreshData' => '$refresh'];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->totalQueues = Ticket::count();
        $this->activeQueues = Ticket::where('status', 'in-service')->count();
        $this->pendingQueues = Ticket::where('status', 'waiting')->count();
        
        // Fetch all windows with their service relationships
        $this->windows = Window::with('services')->get();

    }

    public function render()
    {
        $this->loadData();

        return view('livewire.admin.home.home', [
            'windows' => $this->windows  // Pass windows to the view
        ]);
    }
}
