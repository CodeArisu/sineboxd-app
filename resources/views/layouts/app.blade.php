<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Sineboxd')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- ... --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- {{-- default css --}}
    <link rel="stylesheet" href="{{ asset('css/var.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->



    {{--
        applies css to a certain blade file without interruptions
        with general style
    --}}
    @stack('styles')

</head>

<body class="bg-[#222222] text-white mx-40 mt-4">
    {{--
        -- Where the navbar is being included
        --}}
    @include('layouts.navbar') <!-- Include the navbar -->

    {{--
        -- Where html contents are being applied
        --}}

    @yield('content')


    <script src="//unpkg.com/alpinejs" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>


{{--
        applies js to a certain blade file without interruptions
    --}}

@stack('scripts')





</html>