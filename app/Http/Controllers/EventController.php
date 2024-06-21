<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Rank;
use App\Models\Register;

use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('user', 'comments')->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
       
            $validatedData = $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
                'date' => 'required|date',
                'time' => 'required',
                'price' => 'nullable|numeric',
                'major' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size as needed
            ]);
    
            // If an image was uploaded, store it
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('assets/storage/');
                $validatedData['image'] = $imagePath;
            }
    
            // Create the event using the validated data
            $event = Event::create($validatedData);
    
            // Redirect back with success message
            return redirect()->back()->with('success', 'Event created successfully.');
        
    }
    
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'heur' => 'required',
            'price' => 'nullable',
            'major' => 'nullable',
            'image' => 'nullable|image',
        ]);

        $event->title = $request->get('title');
        $event->description = $request->get('description');
        $event->date = $request->get('date');
        $event->heur = $request->get('heur');
        $event->price = $request->get('price');
        $event->major = $request->get('major');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $event->image = $imagePath;
        }

        $event->save();

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
    public function rate(Request $request, Event $event)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
        ]);

        // Create a new rank
        Rank::create([
            'note' => $request->input('note'),
            'date' => now(),
            'id_utilisateur' => Auth::id(),
            'id_evenement' => $event->id,
        ]);

        return back()->with('success', 'Event rated successfully.');
    }
    public function register(Event $event)
{
    $register = new Register();
    $register->user_id = Auth::id();
    $register->event_id = $event->id;
    $register->save();

    return redirect()->back()->with('success', 'You have successfully registered for the event.');
}

public function unregister(Event $event)
{
    $user = Auth::user();
    $register = Register::where('user_id', $user->id)->where('event_id', $event->id)->first();
    if ($register) {
        $register->delete();
    }

    return redirect()->back()->with('success', 'You have successfully unregistered from the event.');
}
}
