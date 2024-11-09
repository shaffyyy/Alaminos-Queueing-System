<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueStatus extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'status', 'updated_at'];

    // Queue status belongs to a ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
