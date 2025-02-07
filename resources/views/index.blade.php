@push('styles')
    <link rel="stylesheet" href="{{ asset('css/static/test.css') }}">

    <style>
        p {
            color: red;
            display: inline;
        }
        .li-txt-0 {
            color: blue;
            background: yellow;
            font-size: 0.75em;
        }
        .li-txt-2 {
            color: orange;
            background: blue;
            font-size: 1em;
        }
        .li-txt-3 {
            color: red;
            background: green;
            font-size: 1.75em;
        }
        .li-txt-4 {
            color: green;
            background: red;
            font-size: 2em;
        }
        .li-txt-5 {
            color: yellow;
            background: orange;
            font-size: 2.75em;
        }

    </style>
@endpush

@extends('layouts.app')

<h1>If nakita ni tama ni, (Example TEST components) e Delete Lang</h1>

<div>
    <h1>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae</h1>
    <h2>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae</h2>
    <h3>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae</h3>
    <h4>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae</h4>
    <h5>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae</h5>
</div>

<div>
    <a href="">test</a>
</div>

<div>
    <button>test</button>
</div>

<div>
    <ul>
        <li>list 1</li>
        <li>list 2</li>
        <li>list 3</li>
    </ul>

    @for ($i = 0; $i <= 5; $i++)
        <p class='li-txt-{{ $i }}'>list {{ $i }}</p>
    @endfor 
</div>



