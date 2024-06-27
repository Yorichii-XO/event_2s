<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Rank;
use App\Models\Register;
use App\Models\Comment;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated user's ID
        $userId = Auth::id();

        // Retrieve the events for the authenticated user
        $events = Event::with('user', 'comments')->where('user_id', $userId)->get();

        // Return the view with the events
        return view('events.index', compact('events'));
    }
    public function create()
    {
        return view('events.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'heur' => 'required',
            'price' => 'nullable|string',
            'major' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $event = new Event();
            $event->title = $request->title;
            $event->description = $request->description;
            $event->date = $request->date;
            $event->heur = $request->heur;
            $event->price = $request->price;
            $event->major = $request->major;
            $event->user_id = Auth::id();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $imagePath = public_path('assets/storage/');
                $image->move($imagePath, $imageName);
                $event->image = 'assets/storage/' . $imageName;
            }

            $event->save();

            return redirect()->route('events.index')->with('success', 'Event creted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('events.index')->with('success', 'Event creted successfully.');
        }
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
    public function comments($eventId)
    {
        $event = Event::with(['comments.user', 'user'])->findOrFail($eventId);
        return response()->json(['event' => $event, 'comments' => $event->comments]);
    }
    public function showEventComments($eventId)
    {
        $event = Event::with('user', 'comments.user')->findOrFail($eventId);
        $user = Auth::user(); // Get the current authenticated user
    
        // Check if the current user is authenticated and has the admin role
        $currentUser = $user ? ['id' => $user->id, 'role' => $user->role] : null;
        
        return response()->json([
            'event' => $event,
            'comments' => $event->comments,
            'currentUser' => $currentUser
        ]);
    }
    
    public function deleteComment($commentId)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $comment = Comment::findOrFail($commentId);
        $user = Auth::user();

        // Check if the user is authorized to delete the comment
        if ($user->id == $comment->user_id) {
            $comment->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
    }
}
