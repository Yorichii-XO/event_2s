<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;


class CalendarController extends Controller
{
    public function index()
    {
        // Fetch all events the user has added to their calendar
        $events = Auth::user()->calendarEvents()->get();

        // Format events for FullCalendar
        $calendarEvents = $events->map(function($event) {
            return [
                'title' => $event->title,
                'start' => $event->date, // Ensure 'date' is a valid field in your events table
                'description' => $event->description
            ];
        });

        return view('calendar.index', compact('calendarEvents'));
    }

    public function addToCalendar(Event $event)
    {
        // Attach event to user's calendar
        Auth::user()->calendarEvents()->attach($event->id);

        // Redirect to the events index page with a success message
        return redirect()->route('events.index')->with('success', 'Event added to calendar.');
    }
}