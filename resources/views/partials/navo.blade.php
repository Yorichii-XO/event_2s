<!-- resources/views/partials/header.blade.php -->

<header class="w-full border-b mt-2">
    <div class="wrapper flex items-center justify-between">
        <a href="/" class="w-36 ml-12">
            <img src="{{ asset('assets/images/logo.svg') }}" width="128" height="38" alt="Evently logo">
        </a>

        @auth
            <nav class="d-flex md:flex-between  max-w-xs">
                @include('partials.nav-items')
            </nav>
            <div class="flex w-90 justify-end gap-4 mr-6 mb-4">
                <span class="text-purple-600 font-bold mt-2 ">
                    {{ Auth::user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}" class="rounded-full bg-purple-600 px-6 py-3 text-white text-center mb-2y">
                    @csrf

                    <button type="btn btn-lg " class="btn btn-lg border border-purple-600 rounded-full font-bold ">Logout</button>
                </form>
            </div>
        @else
        <div class="flex justify-center gap-3 right-20 pt-2 mb-4">
            <!-- Login Button -->
            <a href="{{ route('login') }}" class="rounded-full bg-purple-600 px-6 py-3 text-white font-bold text-center ">
                <button class="btn btn-lg border border-purple-600 rounded-full font-bold  ">
                    Login
                </button>
            </a>
        
            <!-- Register Button -->
            <a href="{{ route('register') }}" class="rounded-full bg-purple-600 px-6 py-3 text-white font-bold text-center">
                <button class="btn btn-lg border border-purple-600 rounded-full font-bold ">
                    Register
                </button>
            </a>
        </div>
        
        
        @endauth
    </div>
</header>
