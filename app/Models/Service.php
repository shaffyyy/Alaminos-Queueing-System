<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // A service can have many windows
    public function windows()
    {
        return $this->belongsToMany(Window::class, 'service_window');
    }



    // A service can have many tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
