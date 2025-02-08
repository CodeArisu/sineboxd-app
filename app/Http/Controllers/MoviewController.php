<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\BoxOffice;
use App\Models\Budget;
use App\Models\Cast;
use App\Models\Director;
use App\Models\Genre;

use App\Models\Moviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MoviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        // validates only the genre request
        $genre = Validator::make($request->only(['genre']), [
            'genre' => 'required|max:30'
        ]);
        if ($genre->fails()) {
            return response()->json(['error' => $genre->errors()], 402);
        }
        // stores the genre
        $fetch_genre = Genre::create([
            'genre' => $request['genre']
        ]);

        // validates only the director request
        $director = Validator::make($request->only(['director']), [
            'director' => 'required|max:30'
        ]);
        if ($director->fails()) {
            return response()->json(['error' => $director->errors()], 402);
        }
        // stores the director
        $fetch_director = Director::create([
            'name' => $request['director']
        ]);
        
        // validates only the director request
        $budget = Validator::make($request->only(['budget']), [
            'budget' => 'required|max:30'
        ]);
        if ($budget->fails()) {
            return response()->json(['error' => $budget->errors()], 402);
        }
        // stores the budget
        $fetch_budget = Budget::create([
            'budget' => $request['budget']
        ]);
        
        // validates only the director request
        $box_office = Validator::make($request->only(['box_office']), [
            'box_office' => 'required|max:30'
        ]);
        if ($box_office->fails()) {
            return response()->json(['error' => $box_office->errors()], 402);
        }
        // stores the box_office
        $fetch_box_office = BoxOffice::create([
            'revenue' => $request['box_office']
        ]);
        
        // validates only the director request
        $actor = Validator::make($request->only(['actor']), [
            'actor' => 'required|max:30'
        ]);
        if ($actor->fails()) {
            return response()->json(['error' => $actor->errors()], 402);
        }
        // stores the actor
        $fetch_actor = Actor::create([
            'name' => $request['actor']
        ]);
        
        // stores the actor id to casts (1 actor for now)
        $fetch_cast = Cast::create([
            'actor_id' => $fetch_actor->id
        ]);
        
        // fetch overall validation data
        $validated = Validator::make($request->only(['title', 'description', 'release_year']), [
            'title' => 'required|unique:moviews|max:255',
            'description' => 'required',
            'release_year' => 'required|int',
        ]);
        // returns an error message if the request is invalid
        if ($validated->fails()) {
            return response()->json([
                'message' => 'Missing Inputs',
                'errors' => $validated->errors(),
            ], 403);
        }

        try {

            // compiles and creates into one table
            $moviews = Moviews::create([
                'title' => $request['title'],
                'description' => $request['description'],
                'genre_id' => $fetch_genre->id,
                'director_id' => $fetch_director->id,
                'budget_id' => $fetch_budget->id,
                'box_office_id' => $fetch_box_office->id,
                'cast_id' => $fetch_cast->id,
                'release_year' => $request['release_year']
            ]);
    
            return response()->json([
                'Movies' => $moviews,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Moviews $moviews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Moviews $moviews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Moviews $moviews)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Moviews $moviews)
    {
        //
    }
}
