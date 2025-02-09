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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        // validates overall requests
        $validated = Validator::make($request->all(), [
            'title' => 'required|max:50|unique:moviews',
            'description' => 'required|string',
            'genre' => 'required|unique:genres|max:30',
            'director' => 'required|unique:directors,name|max:30',
            'budget' => 'required|int',
            'box_office' => 'required|int',
            'actor' => 'required|unique:actors,name|max:30',
            'cast' => 'required|unique:casts,actor_id|max:30',
            'release_year' => 'nullable|date'
        ]);
        
        // returns an error if validation has issues
        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Input(s)',
                'errors' => $validated->errors(),
            ], 403);
        }

        // validates date or return default format
        $fetch_release = $request->release_year ? Carbon::parse($request->release_year)->toDateString() : now()->toDateString();

        // using db transactions for mass inserts
        DB::beginTransaction();

        // stores genres
        $fetch_genre = Genre::create([
            'genre' => $request->genre,
        ]);
        // stores directors
        $fetch_director = Director::create([
            'name' => $request->director
        ]);
        // stores budgets
        $fetch_budget = Budget::create([
            'budget' => $request->budget
        ]);
        // stores revenue
        $fetch_box_office = BoxOffice::create([
            'revenue' => $request->box_office
        ]);
        // stores actors/actresses
        $fetch_actor = Actor::create([
            'name' => $request->actor
        ]);
        // stores casts
        $fetch_cast = Cast::create([
            'actor_id' => $fetch_actor->id
        ]);

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
                'release_year' => $fetch_release
            ]);

            // commit transactions
            DB::commit();
    
            return response()->json([
                'message' => $request->title . ' was added successfully',
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
        return response()->json([
            'status' => 'posted',
            'movies' => $moviews,
        ], 200);
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
        // finds and check the movie with the id as paramet- /er
        $movie = Moviews::findOrFail($moviews->id);
        // checks if the movie doesn't exists
        if (!$movie) {
            return response()->json(['message' => 'Movie Not Found'], 401);
        }
        // deletes the movie
        $movie->delete();
        return response()->json(['message' => 'Movie deleted successfully'], 200);
    }
}
