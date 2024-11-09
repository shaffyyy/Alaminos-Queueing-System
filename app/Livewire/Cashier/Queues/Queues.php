<?php

namespace App\Livewire\Cashier\Queues;

use Livewire\Component;
use App\Models\Ticket;

class Queues extends Component
{
    public $verificationStatus = 'all';

    public function render()
    {
        $queues = Ticket::when($this->verificationStatus !== 'all', function ($query) {
            $query->where('verify', $this->verificationStatus);
        })->get();

        return view('livewire.cashier.queues.queues', [
            'queues' => $queues,
            'verificationStatus' => $this->verificationStatus,
        ]);
    }
}
