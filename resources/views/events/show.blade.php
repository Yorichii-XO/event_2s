@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="event-item border border-gray-200 rounded-lg overflow-hidden shadow-md relative w-96 mb-4 mx-auto">
        <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" class="w-full h-64 object-cover">
        <div class="p-4">
            <h3 class="title mt-2 text-xl font-semibold">{{ $event->title }}</h3>
            <p class="description mt-1 text-gray-500">{{ $event->description }}</p>
            <p class="date mt-1 text-gray-500">{{ $event->date }}</p>
            <p class="time mt-1 text-gray-500">{{ $event->heur }}</p>
            <p class="price mt-1 text-gray-500">{{ $event->price ?? 'Free' }}</p>
            <p class="major mt-1 text-gray-500">{{ $event->major }}</p>
            <a href="{{ route('events.edit', $event) }}" class="bg-green-500 text-white px-4 py-2 rounded mt-4 block text-center">Edit</a>
        </div>
    </div>
</div>
@endsection
