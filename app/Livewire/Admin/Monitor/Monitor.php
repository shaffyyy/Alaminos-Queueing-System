<?php

namespace App\Livewire\Admin\Monitor;

use Livewire\Component;
use App\Models\Window;

class Monitor extends Component
{
    public $windows = [];

    public function mount()
    {
        $this->loadWindows();
    }

    public function loadWindows()
    {
        $this->windows = Window::with(['tickets' => function ($query) {
            $query->where('status', '!=', 'completed')
                ->orderBy('created_at', 'asc');
        }, 'services']) // Eager load services relationship
        ->get()->map(function ($window) {
            return [
                'name' => $window->name,
                'service' => $window->services->pluck('name')->join(', ') ?? 'N/A', // Get services names
                'now_serving' => optional($window->tickets->first())->queue_number,
                'waiting' => $window->tickets->slice(1, 3)->pluck('queue_number')->toArray(),
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.admin.monitor.monitor');
    }
}
