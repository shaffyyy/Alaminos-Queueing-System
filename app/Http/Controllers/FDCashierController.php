<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FDCashierController extends Controller
{
    public function  index()
    {
        return view('fdcashier.home.home');
    }

    public function showQueue()
    {
        return view('fdcashier.queue.queue');
    }

    public function showReports()
    {
        return view('fdcashier.reports.reports');
    }
}
