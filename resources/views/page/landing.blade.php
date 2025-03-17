@extends('layouts.app')

@section('title', 'Landing Page')

@section('content')
@include('layouts.navbar') <!-- Include the navbar -->
<x-movie-card title="Inception" poster="https://image.tmdb.org/t/p/w500/your-image.jpg" />
<x-movie-card title="Interstellar" poster="https://image.tmdb.org/t/p/w500/your-image.jpg" />


@endsection
