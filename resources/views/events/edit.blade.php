@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white p-4 rounded shadow-lg w-96 mx-auto">
        <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" value="{{ $event->title }}" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>{{ $event->description }}</textarea>
            </div>
            <div class="mb-4">
                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="date" id="date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" value="{{ $event->date }}" required>
            </div>
            <div class="mb-4">
                <label for="heur" class="block text-sm font-medium text-gray-700">Time</label>
                <input type="time" name="heur" id="heur" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" value="{{ $event->heur }}" required>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="text" name="price" id="price" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" value="{{ $event->price }}">
            </div>
            <div class="mb-4">
                <label for="major" class="block text-sm font-medium text-gray-700">Major</label>
                <input type="text" name="major" id="major" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" value="{{ $event->major }}" required>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            </div>
            <div class="flex justify-end">
                <a href="{{ route('events.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
