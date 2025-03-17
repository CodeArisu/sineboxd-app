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
    @vite('resources/js/app.js')

    <!-- {{-- default css --}}
    <link rel="stylesheet" href="{{ asset('css/var.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->

    {{--
        applies css to a certain blade file without interruptions
        with general style
    --}}
    @stack('styles')

</head>


<body class="bg-[#222222] text-white mx-40  ">
   
        {{--
        -- Where html contents are being applied
        --}}

        @yield('content')



</body>


{{--
        applies js to a certain blade file without interruptions
    --}}

@stack('scripts')

<script src="//unpkg.com/alpinejs" defer></script>


</html>