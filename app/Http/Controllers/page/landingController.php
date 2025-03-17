<?php

namespace App\Http\Controllers\page;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;

class landingController extends Controller
{
    public function index()
    {   
        $movies = Movie::all();
        $genres = Genre::all();

        return view('index', compact('movies', 'genres'));
    }

    /**
     * Retrieve most popular
     * 
     * "" most view
     * 
     * "" recommended
     */
}
