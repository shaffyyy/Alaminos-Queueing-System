<?php
namespace App\Livewire\Admin\Home;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Window;
use Carbon\Carbon;

class Home extends Component
{
    public $totalQueues;
    public $activeQueues;
    public $pendingQueues;
    public $windows;
    public $monthlyData = [];
    public $yearlyData = [];

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

        // Compute Monthly Data
        $this->monthlyData = Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Compute Yearly Data
        $this->yearlyData = Ticket::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('count', 'year')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.home.home', [
            'windows' => $this->windows,
            'monthlyData' => $this->monthlyData,
            'yearlyData' => $this->yearlyData,
        ]);
    }
}
