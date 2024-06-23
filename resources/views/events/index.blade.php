<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Events</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container mx-auto p-4">
        <div class="flex justify-end mb-4">
           <a href="{{ route('events.create') }}"> <span  class="bg-blue-500 text-white px-4 py-2 rounded">Add Event</span></a>
        </div>
        <div class="flex flex-wrap justify-center gap-6">
            @foreach ($events as $event)
                <div class="event-item border border-gray-200 rounded-lg overflow-hidden shadow-md relative w-96 mb-4">
                    <div class="absolute top-2 right-2 bg-white p-2 rounded-lg shadow-md">
                        @if ($event->user_id == Auth::id() || Auth::user()->role == 'admin')
                        <a href="{{ route('events.edit', $event) }}"> 
                            <span class="block mb-3 text-green-700">

                                <i class="fa-regular fa-pen-to-square"></i>
                            </span></a>
                            <span class="block text-red-700 mb-3">
                                <form action="{{ route('events.delete', $event) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </span>
                        @endif
                        <a href="javascript:void(0);" onclick="showComments({{ $event->id }})" class="block text-blue-700 relative">
                            <i class="far fa-comments"></i>
                            <span class="absolute bottom-4 right-2 inline-block w-4 h-4 bg-red-500 text-white text-xs font-bold rounded-full text-center leading-tight">
                                {{ $event->comments->count() }}
                            </span>
                        </a>
                    </div>
                    <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <div class="mt-4 flex space-x-4">
                            <span class="bg-green-200 text-black w-20 h-7 flex items-center justify-center rounded font-semibold">{{ $event->price ?? 'Free' }}</span>
                            <span class="bg-gray-200 text-black w-20 h-7 flex items-center justify-center rounded font-semibold">Next.js</span>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <p class="date text-gray-500">{{ $event->date }}</p>
                            <p class="date text-gray-500">{{ $event->heur }}</p>
                        </div>
                        <h3 class="title mt-2 text-xl font-semibold">{{ $event->title }}</h3>
                        <p class="description mt-1 text-gray-500 truncate">{{ $event->description }}</p>
                        <div class="mt-2 flex justify-between items-center space-x-2">
                            <p class="name-autor-hismajor text-gray-500">{{ $event->user->name }} | {{ $event->major }}</p>
                            @auth
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
                            @endauth
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
                                @php
                                    $avgRating = $event->ranks->avg('note');
                                @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa{{ $i <= $avgRating ? 's' : 'r' }} fa-star text-gold"></i>
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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showComments(eventId) {
            $.ajax({
                url: `/events/${eventId}/comments`,
                method: 'GET',
                success: function(data) {
                    console.log('Event Data:', data.event); // Debugging: Log the event data
                    let commentsHtml = '<div class="flex bg-black p-4 rounded-lg">';
    
                    // Display the event image on the left side
                    commentsHtml += `<div class="mr-4">`;
                    commentsHtml += `<img src="${data.event.image}" alt="${data.event.title}" class="w-96 h-96 mb-4">`;
                    commentsHtml += `</div>`;
    
                    // Create a container for the creator's info and comments
                    commentsHtml += '<div class="flex flex-col w-full">';
    
                    // Display the name of the event creator if it exists
                    if (data.event.user) {
                        commentsHtml += `<div class="flex items-center mb-2">`;
                        commentsHtml += `<div class="avatar avatar-sm bg-red-200 rounded-full h-10 w-10 flex items-center justify-center text-white font-bold" style="background-color: #${data.event.user.name.substring(0, 6)};">
                                        <span class="avatar-initial">${data.event.user.name.charAt(0).toUpperCase()}</span>
                                    </div>`;
                        commentsHtml += `<div class="ml-4">`;
                        commentsHtml += `<p class="text-lg text-white font-semibold">${data.event.user.name}</p>`;
                        commentsHtml += `<p class="text-sm text-white text-gray-500">${data.event.major}</p>`;
                        commentsHtml += `</div>`;
                        commentsHtml += `</div>`; // End of creator info div
                        commentsHtml += `<hr class="my-4">`; // Add a horizontal line
                    } else {
                        console.log('User data not found in event data'); // Debugging: Log if user data is missing
                    }
    
                    // Create a container for comments with a white background
                    commentsHtml += '<div class="bg-black p-4 rounded-lg w-full">';
                    
                    data.comments.forEach(comment => {
                        commentsHtml += '<div class="flex items-start mb-4 gap-2">';
                        
                        // Display avatar
                        commentsHtml += `<div class="avatar avatar-sm me-3 bg-blue-700 rounded-full h-10 w-10 flex items-center justify-center text-white font-bold" style="background-color: #${comment.user.name.substring(0, 6)}; ">
                                    <span class="avatar-initial">${comment.user.name.charAt(0).toUpperCase()}</span>
                                </div>`;
                        
                        // Display comment content
                        commentsHtml += `<div class="mt-2">`;
                        commentsHtml += `<p class="text-white"><strong>${comment.user.name}:</strong> ${comment.content}</p>`;
                        
                        // Add delete button for authorized users
                        commentsHtml += `<button class="delete-comment-btn text-sm text-red-500" data-comment-id="${comment.id}" onclick="deleteComment(${eventId}, ${comment.id})">Delete</button>`;
                        
                        commentsHtml += `</div>`;
                        
                        commentsHtml += '</div>'; // End of comment container div
                    });
    
                    commentsHtml += '</div>'; // End of comments container div
                    commentsHtml += '</div>'; // End of flex container div
    
                    commentsHtml += '</div>'; // End of main flex container
    
                    Swal.fire({
                        title: 'Comments',
                        html: commentsHtml,
                        width: '800px',
                        padding: '3em',
                        background: 'none',
                        backdrop: `
                            rgba(0,0,123,0.4)
                            url("/images/nyan-cat.gif")
                            left top
                            no-repeat
                        `
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Unable to fetch comments.', 'error');
                }
            });
        }
    
        document.addEventListener('DOMContentLoaded', function() {
            window.deleteComment = function(eventId, commentId) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                $.ajax({
                    url: `/comments/${commentId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success', 'Comment deleted successfully.', 'success');
                            // Refresh comments after successful deletion
                            showComments(eventId);  // Make sure to pass the correct eventId
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Unable to delete comment.', 'error');
                    }
                });
            }
        });
    </script>
    @endsection
</body>
</html>
