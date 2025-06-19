<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings()->with('vehicle')->orderBy('created_at', 'desc')->get();
        return view('user.dashboard', compact('bookings'));
    }
}
