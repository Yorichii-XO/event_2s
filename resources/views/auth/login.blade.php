<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">

</head>
@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    

<body class=" bg-white">
    <!-- Container -->
    <div class="container mx-auto">
        <div class="flex justify-center px-6 my-12">
            <!-- Row -->
            <div class=" w-full xl:w-3/4 lg:w-11/12 flex">
                <!-- Col -->
                <div
                    class=" w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg"
                    style="background-image: url('https://images.unsplash.com/photo-1631086599565-2447499881db?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8bGl2ZSUyMGV2ZW50c3xlbnwwfHwwfHx8MA%3D%3D')"
                ></div>
                <!-- Col -->
                <div class="w-full lg:w-1/2 bg-white p-5 rounded-lg lg:rounded-l-none">
                    <h3 class="pt-4 text-3xl font-bold  text-center mb-10">Login to Your Account!</h3>
                    <a href="https://apis.google.com/js/platform.js" class="flex items-center justify-center mt-4 text-white rounded-lg shadow-md hover:bg-gray-100">
                        <div class="px-4 py-3">
                            <svg class="h-6 w-6" viewBox="0 0 40 40">
                                <path
                                    d="M36.3425 16.7358H35V16.6667H20V23.3333H29.4192C28.045 27.2142 24.3525 30 20 30C14.4775 30 10 25.5225 10 20C10 14.4775 14.4775 9.99999 20 9.99999C22.5492 9.99999 24.8683 10.9617 26.6342 12.5325L31.3483 7.81833C28.3717 5.04416 24.39 3.33333 20 3.33333C10.7958 3.33333 3.33335 10.7958 3.33335 20C3.33335 29.2042 10.7958 36.6667 20 36.6667C29.2042 36.6667 36.6667 29.2042 36.6667 20C36.6667 18.8825 36.5517 17.7917 36.3425 16.7358Z"
                                    fill="#FFC107" />
                                <path
                                    d="M5.25497 12.2425L10.7308 16.2583C12.2125 12.59 15.8008 9.99999 20 9.99999C22.5491 9.99999 24.8683 10.9617 26.6341 12.5325L31.3483 7.81833C28.3716 5.04416 24.39 3.33333 20 3.33333C13.5983 3.33333 8.04663 6.94749 5.25497 12.2425Z"
                                    fill="#FF3D00" />
                                <path
                                    d="M20 36.6667C24.305 36.6667 28.2167 35.0192 31.1742 32.34L26.0159 27.975C24.3425 29.2425 22.2625 30 20 30C15.665 30 11.9842 27.2359 10.5975 23.3784L5.16254 27.5659C7.92087 32.9634 13.5225 36.6667 20 36.6667Z"
                                    fill="#4CAF50" />
                                <path
                                    d="M36.3425 16.7358H35V16.6667H20V23.3333H29.4192C28.7592 25.1975 27.56 26.805 26.0133 27.9758C26.0142 27.975 26.015 27.975 26.0158 27.9742L31.1742 32.3392C30.8092 32.6708 36.6667 28.3333 36.6667 20C36.6667 18.8825 36.5517 17.7917 36.3425 16.7358Z"
                                    fill="#1976D2" />
                            </svg>
                        </div>
                        <h1 class="px-4 py-3 w-5/6 text-center text-gray-600 font-bold">Sign in with Google</h1>
                    </a>
                    <form method="POST" action="{{ route('login') }}" class="px-8 pt-6 pb-8 mb-4 bg-white rounded">
                        @csrf
                        <div class="relative">
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                            <input id="email" type="email" name="email"  required autofocus 
                            class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 mb-6" placeholder="you@example.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-red-500 mt-2">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
        
                        <div class="relative">
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                            <input id="password" type="password" name="password" required 
                            class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 mb-6" placeholder="password">
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
            </div>
        </div>
    </div>
</body>

@endsection

</html>
