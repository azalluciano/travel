<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page with all destinations.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $destinations = Destination::all();
        return view('home', compact('destinations'));
    }
}