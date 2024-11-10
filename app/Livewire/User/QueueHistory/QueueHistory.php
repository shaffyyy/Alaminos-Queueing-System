<?php

namespace App\Livewire\User\QueueHistory;

use Livewire\Component;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class QueueHistory extends Component
{
    use WithPagination;

    public $selectedDateFilter = 'all';
    public $startDate;
    public $endDate;
    public $sortColumn = 'created_at';
    public $sortDirection = 'desc';

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
                $this->endDate = Carbon::tomorrow()->subSecond();
                break;
            case 'yesterday':
                $this->startDate = Carbon::yesterday();
                $this->endDate = Carbon::today()->subSecond();
                break;
            case '7days':
                $this->startDate = Carbon::today()->subDays(6);
                $this->endDate = Carbon::tomorrow()->subSecond();
                break;
            default:
                $this->startDate = null;
                $this->endDate = null;
                break;
        }
    }

    public function sortBy($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortColumn = $column;
    }

    public function deleteTicket($ticketId)
    {
        $ticket = Ticket::where('id', $ticketId)->where('user_id', Auth::id())->first();

        if ($ticket) {
            $ticket->delete();
            session()->flash('message', 'Ticket deleted successfully.');
        } else {
            session()->flash('error', 'Failed to delete the ticket.');
        }
    }

    // Add the loadQueueStatus method to handle polling
    public function loadQueueStatus()
    {
        // Optional: Any code to refresh data
    }

    public function render()
    {
        $tickets = Ticket::where('user_id', Auth::id())
            ->when($this->startDate && $this->endDate, fn ($query) => $query->whereBetween('created_at', [$this->startDate, $this->endDate]))
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate(10);

        return view('livewire.user.queue-history.queue-history', [
            'tickets' => $tickets,
        ]);
    }
}
