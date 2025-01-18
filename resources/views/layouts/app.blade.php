<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Sineboxd')</title>
    
    {{-- default css --}}
    <link rel="stylesheet" href="{{ asset('css/var.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- 
        applies css to a certain blade file without interruptions
        with general style
    --}}
    @stack('styles')

</head>

    <body>
            {{-- 
                Where html contents are being applied
            --}}
        @yield('content')
    </body>

    {{-- 
        applies js to a certain blade file without interruptions
    --}}
    @stack('scripts')
    
</html>