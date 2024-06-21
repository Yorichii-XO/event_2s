<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
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
        <div  class="image">
            <img src="{{ asset('assets/images/hero.png') }}" alt="hero" class="image max-h-[70vh] object-contain object-center 2xl:max-h-[50vh]">
        </div>
    </div>
</section>

<section id="events" class="wrapper my-8 flex flex-col gap-8 md:gap-12">
    <h2 class="h2-bold">Trusted by <br> Thousands of Events</h2>

    <div class="components flex w-full flex-col gap-5 md:flex-row ">
        <!-- Include your Search component -->
        @include('components.search')
    
        <!-- Include your CategoryFilter component -->
        @include('components.category-filter')
    </div>
    admino
   
    <div>
        <!-- Assuming $events is an array of event objects fetched from your database -->
        @foreach($events as $event)
        <div class="event-item border border-gray-200 rounded-lg overflow-hidden shadow-md relative w-96 mx-4 my-6">
            <div class="absolute top-2 right-2 bg-white p-2 rounded-lg shadow-md">
                <span class="block mb-2 text-green-700">
                    <a href="{{ route('events.edit', $event->id) }}"><i class="fas fa-pen-square"></i></a>
                </span>
                <span class="block text-red-700">
                    <a href="{{ route('events.delete', $event->id) }}"><i class="fas fa-trash"></i></a>
                </span>
                <span class="block text-blue-700">
                    <a href="{{ route('events.comments', $event->id) }}"><i class="fas fa-comments"></i></a>
                </span>
            </div>
            <img src="{{ $event->image }}" alt="" class="w-full h-48 object-cover">
            <div class="p-4">
                <!-- Event Details -->
                <h3 class="title mt-2 text-xl font-semibold">{{ $event->title }}</h3>
                <p class="description mt-1 text-gray-500 truncate">{{ $event->description }}</p>
                <!-- Other details like date, time, etc. -->
                <!-- Registration button -->
                <div class="mt-2 flex justify-between items-center space-x-2">
                    <p class="name-autor-hismajor text-gray-500">{{ $event->user->name }}</p>
                    <span class="text-white bg-blue-800 rounded-lg w-20 h-8 flex items-center justify-center">
                        <button class="btn font-semibold">Register</button>
                    </span>
                </div>
                <!-- Comments -->
                <div class="mt-4 flex space-x-4">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="far fa-comment text-gray-500"></i>
                        </div>
                        <input type="comment" id="comment" class="block w-full h-10 p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="Comment..." required />
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
