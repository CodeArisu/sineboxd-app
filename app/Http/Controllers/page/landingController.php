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
        $popular = Movie::where('category_id', 1)->get();
        $latest = Movie::where('category_id', 2)->get();
        $upcoming = Movie::where('category_id', 3)->get();

        return view('index', compact('popular', 'latest', 'upcoming'));
    }

    /**
     * Retrieve most popular
     * 
     * "" most view
     * 
     * "" recommended
     */
}
