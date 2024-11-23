<?php

namespace App\Livewire\Admin\Home;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Window;
use App\Models\Feedback;
use Carbon\Carbon;

class Home extends Component
{
    public $totalQueues;
    public $activeQueues;
    public $pendingQueues;
    public $windows;
    public $monthlyData = [];
    public $feedbackData = [];
    public $averageFeedback = 0;

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

        $this->windows = Window::with('services')->get();

        // Compute Monthly Data
        $this->monthlyData = Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Compute Feedback Data
        $feedbackCounts = Feedback::selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        $totalFeedback = array_sum($feedbackCounts);
        $totalStars = array_sum(array_map(fn($rating, $count) => $rating * $count, array_keys($feedbackCounts), $feedbackCounts));

        $this->feedbackData = $feedbackCounts;
        $this->averageFeedback = $totalFeedback ? round($totalStars / $totalFeedback, 2) : 0;
    }

    public function render()
    {
        return view('livewire.admin.home.home', [
            'windows' => $this->windows,
            'monthlyData' => $this->monthlyData,
            'feedbackData' => $this->feedbackData,
            'averageFeedback' => $this->averageFeedback,
        ]);
    }
}
