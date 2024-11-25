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
        // Fetch windows with their tickets and services
        $this->windows = Window::with(['tickets' => function ($query) {
            $query->where('verify', 'verified') // Include only verified tickets
                ->whereIn('status', ['waiting', 'in-service']) // Include only specific statuses
                ->orderBy('created_at', 'asc'); // Oldest tickets first
        }, 'services']) // Eager load services relationship
        ->get()->map(function ($window) {
            return [
                'name' => $window->name,
                'service' => $window->services->pluck('name')->join(', ') ?? 'N/A', // Get services names
                'now_serving' => optional($window->tickets->first())->queue_number, // First ticket in the queue
                'waiting' => $window->tickets->pluck('queue_number')->toArray(), // All remaining tickets
            ];
        })->toArray();

        // Dispatch custom browser event for dynamic updates
        $this->dispatch('windows-updated', ['windows' => $this->windows]);
    }

    public function render()
    {
        return view('livewire.admin.monitor.monitor');
    }
}
