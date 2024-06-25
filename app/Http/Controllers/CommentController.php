<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Event;
class CommentController extends Controller
{
    public function store(Request $request, Event $event)
    {
        // Validate the comment data
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // Create a new comment
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->event_id = $event->id;
        $comment->user_id = auth()->id(); // Assuming the user is authenticated
        $comment->save();

        // Redirect back to the homepage with a success message
        return redirect('/')->with('success', 'Comment added successfully!');
    }
    public function showEventComments($eventId)
    {
        $event = Event::with('user', 'comments.user')->findOrFail($eventId);
        $user = Auth::user(); // Get the current authenticated user
    
        return response()->json([
            'event' => $event,
            'comments' => $event->comments,
            'currentUser' => $user ? ['id' => $user->id, 'role' => $user->role] : null // Include current user info
        ]);
    }
    
    public function deleteComment($commentId)
    {
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
