<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

@extends('layouts.app')

@section('content')
<section class="bg-primary-50 bg-dotted-pattern bg-contain py-5 md:py-10">
    <div class="wrapper grid grid-cols-1 gap-5 md:grid-cols-2 2xl:gap-0">
        <div class="expretion flex flex-col justify-center gap-8">
            <h1 class="h1-bold">Host, Connect, Celebrate: Your Events, Our Platform!</h1>
            <p class="p-regular-20 md:p-regular-24">Book and learn helpful tips from 3,168+ mentors in world-class companies with our global community.</p>
            <a href="#events" class="button w-full sm:w-fit">
                <button class="btn btn-lg">
                    Explore Now
                </button>
            </a>
        </div>
        <div class="image">
            <img src="{{ asset('assets/images/hero.png') }}" alt="hero" class="image max-h-[70vh] object-contain object-center 2xl:max-h-[50vh]">
        </div>
    </div>
</section>

<section id="events" class="wrapper my-8 flex flex-col gap-8 md:gap-12">
    <h2 class="h2-bold">Trusted by <br> Thousands of Events</h2>

    <div class="components flex w-full flex-col gap-5 md:flex-row">
        <!-- Include your Search component -->
        @include('components.search')
    
        <!-- Include your CategoryFilter component -->
        @include('components.category-filter')
    </div>
    
    <div class="container mx-auto p-4">
      
        <div class="flex flex-wrap justify-center gap-6">
            @foreach ($events as $event)
                <div class="event-item border border-gray-200 rounded-lg overflow-hidden shadow-md relative w-96 mb-4">
                    <div class="absolute top-2 right-2 bg-white p-2 rounded-lg shadow-md">
                        @if (Auth::check() && ($event->user_id == Auth::id() || Auth::user()->role == 'admin'))
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
                            <p class="date text-gray-500">{{ $event->time }}</p>
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

        <script src="{{ asset('js/comments.js') }}"></script>

</section>
@endsection

</body>
</html>
