<!-- component -->
@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12">
    <div class="border-4 border-purple-500 p-8 bg-white shadow-md rounded-lg flex items-center animate-slide-up">
        <div class="max-w-lg w-full mr-12">
            <h2 class="text-3xl font-bold mb-6">Login to Your Account</h2>
            <form method="POST" action="{{ route('login') }}" class="px-8 pt-6 pb-8 mb-4 bg-white rounded">
                @csrf
                <div class="relative">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                    class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="you@example.com">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong class="text-red-500 mt-2">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required 
                    class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="password">
                    @error('password')
                        <span class="invalid-feedback text-red-500" role="alert">
                            <strong class="text-danger mt-2">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="flex items-center justify-between relative">
                    <button type="submit"
                        class="bg-purple-500 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline circular-reveal">
                        Login
                    </button>
                    @if (Route::has('password.request'))
                        <a class="text-sm text-purple-500 hover:text-purple-700 circular-reveal" href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                    @endif
                </div>
            </form>
        </div>
        <div class="w-100 h-80">
            <img src="https://www.eventbookings.com/wp-content/uploads/2018/03/cool-event-ideas-for-you-eventbookings-au.jpg" 
                class="object-cover w-full h-full rounded-md">
        </div>
    </div>
</div>

<style>
@keyframes slideUp {
    0% {
        transform: translateY(20px);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes circularReveal {
    0% {
        clip-path: circle(0% at 50% 50%);
        opacity: 0;
    }
    100% {
        clip-path: circle(150% at 50% 50%);
        opacity: 1;
    }
}

.animate-slide-up {
    animation: slideUp 1s ease-out;
}

.circular-reveal {
    animation: circularReveal 1s ease-out forwards;
    animation-delay: 0.3s;
}

.circular-reveal:nth-child(1) {
    animation-delay: 0.3s;
}
.circular-reveal:nth-child(2) {
    animation-delay: 0.4s;
}
.circular-reveal:nth-child(3) {
    animation-delay: 0.5s;
}
.circular-reveal:nth-child(4) {
    animation-delay: 0.6s;
}
</style>
@endsection
