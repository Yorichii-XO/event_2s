<!-- resources/views/events/drawer.blade.php -->

<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-4 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Add/Edit Event</h2>
        <form action="{{ isset($event) ? route('events.update', $event) : route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($event))
                @method('PUT')
            @endif
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Title</label>
                <input type="text" name="title" id="title" class="block w-full mt-2 p-2 border border-gray-300 rounded" value="{{ $event->title ?? old('title') }}" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea name="description" id="description" class="block w-full mt-2 p-2 border border-gray-300 rounded" required>{{ $event->description ?? old('description') }}</textarea>
            </div>
            <div class="mb-4">
                <label for="date" class="block text-gray-700">Date</label>
                <input type="date" name="date" id="date" class="block w-full mt-2 p-2 border border-gray-300 rounded" value="{{ $event->date ?? old('date') }}" required>
            </div>
            <div class="mb-4">
                <label for="heur" class="block text-gray-700">Time</label>
                <input type="time" name="heur" id="heur" class="block w-full mt-2 p-2 border border-gray-300 rounded" value="{{ $event->heur ?? old('heur') }}" required>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-gray-700">Price</label>
                <input type="text" name="price" id="price" class="block w-full mt-2 p-2 border border-gray-300 rounded" value="{{ $event->price ?? old('price') }}">
            </div>
            <div class="mb-4">
                <label for="major" class="block text-gray-700">Major</label>
                <input type="text" name="major" id="major" class="block w-full mt-2 p-2 border border-gray-300 rounded" value="{{ $event->major ?? old('major') }}">
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700">Image</label>
                <input type="file" name="image" id="image" class="block w-full mt-2 p-2 border border-gray-300 rounded">
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeEventDrawer()" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>
</div>
