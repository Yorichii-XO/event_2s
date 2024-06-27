<ul class="flex text-center gap-5 size-10 w-full mr-20">
    <li><a href="#" class="block text-black font-bold">Home</a></li>
    <li><a href="{{ route('events.index') }}" class="block text-black font-bold w-24">My Events</a></li>
    <li><a href="{{ route('calendar') }}" class="block text-black font-bold w-24">My Calendar</a></li> <!-- Add this line -->

    <li><a href="#" class="block text-black font-bold w-24">My Profile</a></li>

    @if(Auth::check() && Auth::user()->role == 'admin')
        <li><a href="{{ route('users.index') }}" class="block text-black font-bold">Users</a></li>
    @endif
</ul>
