<?php

namespace App\Livewire\User\QueueHistory;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class QueueHistory extends Component
{
    public $selectedDateFilter = 'all';
    public $startDate;
    public $endDate;

    public function filterByDate($range)
    {
        $this->selectedDateFilter = $range;

        switch ($range) {
            case 'all':
                $this->startDate = null;
                $this->endDate = null;
                break;
            case 'today':
                $this->startDate = Carbon::today();
                $this->endDate = Carbon::today();
                break;
            case 'yesterday':
                $this->startDate = Carbon::yesterday();
                $this->endDate = Carbon::yesterday();
                break;
            case '7days':
                $this->startDate = Carbon::today()->subDays(7);
                $this->endDate = Carbon::today();
                break;
            default:
                $this->startDate = null;
                $this->endDate = null;
                break;
        }
    }

    public function render()
    {
        $tickets = Ticket::where('user_id', Auth::id())
            ->when($this->startDate && $this->endDate, fn ($query) => $query->whereBetween('created_at', [$this->startDate, $this->endDate]))
            ->paginate(10);

        return view('livewire.user.queue-history.queue-history', [
            'tickets' => $tickets,
        ]);
    }
}
