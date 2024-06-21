<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with('user', 'comments')->get();

        return view('home', [
            'events' => $events,
        ]);
    }
}
