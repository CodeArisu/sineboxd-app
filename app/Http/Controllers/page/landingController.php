<?php

namespace App\Http\Controllers\page;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class landingController extends Controller
{
    public function index()
    {   
        return view('page.landing');
    }

    /**
     * Retrieve most popular
     * 
     * "" most view
     * 
     * "" recommended
     */
}
