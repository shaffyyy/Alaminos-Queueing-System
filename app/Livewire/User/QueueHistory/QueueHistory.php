<?php

namespace App\Livewire\User\QueueHistory;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class QueueHistory extends Component
{
    use WithPagination;

    public $selectedDateFilter = 'today';
    public $startDate;
    public $endDate;
    public $sortColumn = 'created_at';
    public $sortDirection = 'desc';

    public $showFeedbackModal = false;
    public $selectedTicketId;
    public $feedback;
    public $rating; // Star rating

    public function filterByDate($range)
    {
        $this->selectedDateFilter = $range;

        switch ($range) {
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
                $this->startDate = Carbon::today();
                $this->endDate = Carbon::tomorrow()->subSecond();
                break;
        }
    }

    public function openFeedbackModal($ticketId)
    {
        $this->selectedTicketId = $ticketId;
        $this->showFeedbackModal = true;
    }

    public function closeFeedbackModal()
    {
        $this->showFeedbackModal = false;
        $this->feedback = '';
        $this->rating = null;
    }

    public function submitFeedback()
    {
        $this->validate([
            'feedback' => 'required|min:5|max:500',
            'rating' => 'required|integer|between:1,5',
        ]);

        Feedback::create([
            'ticket_id' => $this->selectedTicketId,
            'user_id' => Auth::id(),
            'feedback' => $this->feedback,
            'rating' => $this->rating,
        ]);

        session()->flash('message', 'Thank you for your feedback!');
        $this->closeFeedbackModal();
    }

    public function deleteTicket($ticketId)
    {
        $ticket = Ticket::where('id', $ticketId)->where('user_id', Auth::id())->first();

        if ($ticket) {
            $ticket->delete();

            session()->flash('message', 'Ticket has been deleted successfully!');
        } else {
            session()->flash('error', 'You are not authorized to delete this ticket.');
        }
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
