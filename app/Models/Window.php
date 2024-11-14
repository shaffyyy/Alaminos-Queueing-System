<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Window extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'service_id', 'cashier_id', 'status'];

    // A window belongs to a service
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_window');
    }
    




    // A window can serve many tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }
}
