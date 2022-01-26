<?php

namespace App\Http\Controllers;

use App\Station;

class HomeController extends Controller
{/**
 * Show the application dashboard.
 *
 * @return \Illuminate\Contracts\Support\Renderable
 */
    public function index()
    {
        return view('home');
    }

    public function welcome()
    {
        $stations = Station::all();
        return view('welcome', compact('stations'));
    }

    public function adminDashboard()
    {
        return redirect()->route('admin.bookings');
    }
}
