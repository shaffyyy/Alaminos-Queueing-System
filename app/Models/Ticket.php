<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'window_id',
        'status',
        'verify',
        'queue_number',
        'verified_at',
        'or_number' // Add verified_at here
    ];

    protected $dates = [
        'verified_at', // Ensure it's cast to a date object
    ];


    

    // A ticket belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A ticket belongs to a service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // A ticket belongs to a window
    public function window()
    {
        return $this->belongsTo(Window::class);
    }

    // A ticket has one queue status
    public function queueStatus()
    {
        return $this->hasOne(QueueStatus::class);
    }
}
