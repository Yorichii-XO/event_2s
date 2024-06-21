<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
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
    
    <div class="flex flex-wrap justify-center">
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
                    <span class="text-white bg-blue-800 rounded-lg w-20 h-8 flex items-center justify-center">
                        <button class="btn font-semibold">Register</button>
                    </span>
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
            </div>
        </div>
        @endforeach

    
    </div>
</section>
@endsection

</body>
</html>
