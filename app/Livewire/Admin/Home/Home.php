<?php
namespace App\Livewire\Admin\Home;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Window;

class Home extends Component
{
    public $totalQueues;
    public $activeQueues;
    public $pendingQueues;
    public $windows;

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

        // Fetch all windows with their services relationship
        $this->windows = Window::with('services')->get();
    }

    public function render()
    {
        return view('livewire.admin.home.home', [
            'windows' => $this->windows
        ]);
    }
}

