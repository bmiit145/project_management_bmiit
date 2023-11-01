<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class allocationController extends Controller
{
    public function ViewAllAllocations()
    {
        return view('admin.viewAllAllocations');
    }
}
