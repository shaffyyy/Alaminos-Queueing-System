<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function  index()
    {
        return view('cashier.home.home');
    }

    public function showQueue()
    {
        return view('cashier.queues.queues-index');
    }
}
