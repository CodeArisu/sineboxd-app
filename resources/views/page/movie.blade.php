@extends('layouts.app')

@section('title', 'Movie Detail')
@section('content')

<div class="relative left-1/2 -translate-x-1/2 w-[90vw] h-[80vh] flex items-center justify-center -mt-16 -z-10">
    <img src="https://www.themoviedb.org/t/p/original{{ $movie->backdrop }}" alt="Background Image" class="absolute inset-0 w-full h-full object-cover object-center pointer-events-none">

    <!-- Soft, Extended, and More Noticeable Fade Effect -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Top Fade -->
        <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-[#222222] via-[#222222]/20 to-transparent"></div>
        <!-- Bottom Fade -->
        <div class="absolute bottom-0 left-0 w-full h-64 bg-gradient-to-t from-[#222222] via-[#222222]/20 to-transparent"></div>
        <!-- Left Fade -->
        <div class="absolute left-0 top-0 h-full w-64 bg-gradient-to-r from-[#222222] via-[#222222]/20 to-transparent"></div>
        <!-- Right Fade -->
        <div class="absolute right-0 top-0 h-full w-64 bg-gradient-to-l from-[#222222] via-[#222222]/20 to-transparent"></div>
    </div>
</div>


<!-- Movie Details Section with Overlapping Effect -->
<div class="container relative -mt-32 z-10">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="shadow-lg rounded-lg overflow-hidden">
            <x-movie-card poster="https://www.themoviedb.org/t/p/w220_and_h330_face{{ $movie->poster }}" alt="Poster" />
        </div>
        <div class="md:w-2/3">
            <div class="flex items-center mb-4">
                <h1 class="text-4xl font-bold mr-4">{{ $movie->title ?? 'No Title'}}</h1>
                <p class="text-gray-300 mr-4">{{ $year }}</p>
                <p class="text-gray-300 mr-4">{{ $movie->director->name ?? 'unknown' }}</p>
            </div>
            <p class="text-gray-300 mb-4">Duration: 2h 30m</p>
                <div class="flex items-center text-gray-300 mb-4">
                    <span class="font-semibold mr-2">Genre:</span>
                    <ul class="flex flex-wrap space-x-2">
                        @foreach($movie->genres as $genre)
                            <li class="flex items-center">
                                {{ $genre->name }}
                                @if (!$loop->last)
                                    <span class="mx-2">•</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            <p class="text-gray-300 mb-4">Description: {{ $movie->description ?? "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."}} </p>
        </div>
    </div>
</div>

<div class="mt-20 ">
    <h1 class="text-2xl font-bold">Where to watch</h1>
    <div class="flex flex-col md:flex-row justify-center items-center gap-6 mt-6">
        <!-- Streaming Services -->
        <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8 dark:bg-[#222222] dark:border-[#3D3C3C]">
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Streaming Services</h5>
            </div>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-[#3D3C3C]">
                    <li class="py-3 sm:py-4">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <img class="w-8 h-8 rounded-full" src="assets/netflix.png" alt="Netflix logo">
                            </div>
                            <div class="flex-1 min-w-0 ms-4">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    Netflix
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="py-3 sm:py-4">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <img class="w-8 h-8 rounded-full" src="assets/youtube.png" alt="YouTube logo">
                            </div>
                            <div class="flex-1 min-w-0 ms-4">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    YouTube
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- In Theaters -->
        <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8 dark:bg-[#222222] dark:border-[#3D3C3C] mb-20">
            <div class="flex items-center justify-between align-top mb-4">
                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">In Theaters</h5>
            </div>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-[#3D3C3C]">
                    <li class="py-3 sm:py-4">
                        <div class="flex items-center">
                            <div class="flex-1 min-w-0 ms-4">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    Not Available
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>







</div>

<div class="mt-20">
    <h1 class="text-2xl font-bold">Ratings</h1>

    <div class="container mx-auto relative mt-4 flex items-center gap-2">
        <!-- Stars -->
        <div class="flex gap-1 text-yellow-400">
            @php
                $rating = floor($movie->ratings / 2);
            @endphp
            @for ($i = 0; $i < 5; $i++)
                @if ($i < $rating)
                    <img src="{{ asset('assets/star.png') }}" alt="Star" class="w-10 h-10">
                @else
                    <img src="{{ asset('assets/star-gray.png') }}" alt="Gray Star" class="w-10 h-10">
                @endif
            @endfor
        </div>
        <!-- Rating Number -->
        <h1 class="text-2xl font-bold">{{ $rating }}</h1>
    </div>
</div>

<div class="mt-20 ">
    <h1 class="text-2xl font-bold mr-4">Reviews</h1>
    <div class="container mx-auto relative mt-4">
        <x-review-editor :movie="$movie" />

        <x-review-card
            username="prim"
            review="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et"
            rating="4"
            likes="125"
            comments="5"
            profileImage="{{ asset('storage/profile.jpg') }}" 
        />

        {{-- <x-review-card
            username="prim"
            review="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et"
            rating="4"
            likes="125"
            comments="5"
            profileImage="{{ asset('storage/profile.jpg') }}" 
        /> --}}

    </div>
</div>






@endsection