<ul class="flex text-center gap-5 size-10 w-96">
    <li><a href="#" class="block text-black font-bold">Home</a></li>
    <li><a href="{{ route('events.index') }}" class="block text-black font-bold">My Events</a></li>
    <li><a href="#" class="block text-black font-bold">My Profile</a></li>
    @if(Auth::check() && Auth::user()->role == 'admin')
        <li><a href="{{ route('users.index') }}" class="block text-black font-bold">Users</a></li>
    @endif
</ul>
