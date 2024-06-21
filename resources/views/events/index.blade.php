<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
</head>
<style>
   
    
</style>

<body>
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-end mb-4">
        <button onclick="showCreateEventDrawer()" class="bg-blue-500 text-white px-4 py-2 rounded">Add Event</button>
    </div>
    @foreach ($events as $event)
    <div class="event-item border border-gray-200 rounded-lg overflow-hidden shadow-md relative w-96 mb-4">
        <div class="absolute top-2 right-2 bg-white p-2 rounded-lg shadow-md">
            <span class="block mb-3 text-green-700">
                <i class="fa-regular fa-pen-to-square" onclick="showEditEventDrawer({{ $event->id }})"></i>
            </span>
            <span class="block text-red-700 mb-3">
                <form action="{{ route('events.delete', $event) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </form>
            </span>
            <button class="block text-blue-700 relative " onclick="showCommentsDrawer({{ $event->id }})">
                <i class="far fa-comments"></i>
                <span class="absolute bottom-4 right-2 inline-block w-4 h-4 bg-red-500 text-white text-xs font-bold rounded-full text-center leading-tight">
                    {{ $event->comments->count() }}
                </span>
            </button>
            
        </div>
        <img src="{{ $event->image ? asset('assets/storage/' . $event->image) : 'https://www.shutterstock.com/image-photo/panoramic-aerial-view-casablanca-grand-600nw-2460494113.jpg' }}" alt="" class="w-full h-48 object-cover">
        <div class="p-4">
            <div class="mt-4 flex space-x-4">
                <span class="bg-green-200 text-black w-20 h-7 flex items-center justify-center rounded font-semibold">{{ $event->price ?? 'Free' }}</span>
                <span class="bg-gray-200 text-black w-20 h-7 flex items-center justify-center rounded font-semibold">Next.js</span>
            </div>
            <div class="mt-4 flex justify-between items-center">
                <p class="date text-gray-500">{{ $event->date}}</p>
                <p class="date text-gray-500">{{ $event->heur }}</p>
            </div>
            <h3 class="title mt-2 text-xl font-semibold">{{ $event->title }}</h3>
            <p class="description mt-1 text-gray-500 truncate">{{ $event->description }}</p>
            <div class="mt-2 flex justify-between items-center space-x-2">
                <p class="name-autor-hismajor text-gray-500">{{ $event->user->name }} | {{ $event->major }}</p>
                @if (!Auth::user()->registeredForEvent($event))
                <form action="{{ route('events.register', $event) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn font-semibold">Register</button>
                </form>
            @else
                <form action="{{ route('events.unregister', $event) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn font-semibold">Cancel</button>
                </form>
            @endif
            
            </div>
            <div class="mt-4 flex space-x-4">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fa-regular fa-comment text-gray-500"></i>
                    </div>
                    <form action="{{ route('comments.store', $event) }}" method="POST">
                        @csrf
                        <input type="text" name="content" id="comment" class="block w-full h-10 p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" 
                        placeholder="Comment..." required />
                        <button type="submit" class="hidden">Submit</button>
                    </form>
                </div>
            </div>
            <div class="mt-4 flex space-x-4">
                <!-- Star Rating -->
                <div class="star-rating flex items-center space-x-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa{{ $i <= $event->ranks->avg('note') ? 's' : 'r' }} fa-star text-gold"></i>
                    @endfor
                </div>
              
            </div>
            <!-- Rating Form -->
            <form action="{{ route('events.rate', $event) }}" method="POST">
                @csrf
                <div class="star-rating mt-4 flex space-x-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <label>
                            <input type="radio" name="note" value="{{ $i }}" class="hidden" />
                            <i class="fa fa-star text-gold cursor-pointer"></i>
                        </label>
                    @endfor
                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Rate</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>

<div id="createEventDrawer" class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center hidden">
    <!-- Event Create/Edit Drawer Content -->
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    /* Styles for the comments drawer */
    .comments-drawer {
        position: fixed;
        bottom: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background-color: white;
        border: 1px solid #ccc;
        overflow-y: scroll;
    }
    .comment {
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }
</style>

<div id="commentsDrawer" class="comments-drawer hidden">
    <!-- Comments will be displayed here -->
</div>

<script>
    function showCommentsDrawer(eventId) {
        // Fetch comments for the event asynchronously
        $.get(`/events/${eventId}/comments`, function(data) {
            // Display comments in the comments drawer
            var commentsDrawer = document.getElementById('commentsDrawer');
            commentsDrawer.innerHTML = ''; // Clear previous comments
            data.forEach(function(comment) {
                var commentElement = document.createElement('div');
                commentElement.classList.add('comment');
                commentElement.textContent = comment.content; // Make sure to use the correct property for the comment content
                commentsDrawer.appendChild(commentElement);
            });
            // Show the comments drawer
            commentsDrawer.classList.remove('hidden');
        });
    }

    function showCreateEventDrawer() {
        document.getElementById('createEventDrawer').classList.remove('hidden');
    }

    function showEditEventDrawer(eventId) {
        // Populate and show edit drawer
        document.getElementById('createEventDrawer').classList.remove('hidden');
    }

    function closeEventDrawer() {
        document.getElementById('createEventDrawer').classList.add('hidden');
    }
</script>

@endsection

</body>
</html>
