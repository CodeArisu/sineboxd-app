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
use Illuminate\Support\Facades\Validator;

class MoviewController extends Controller
{

    public function index()
    {
        // page for the data lifecycle
    }

    public function create()
    {
        // retrieve form for creating movie
    }

    public function store(Request $request)
    {   
        // validates overall requests
        $validated = Validator::make($request->all(), [
            'title' => 'required|max:50|unique:moviews',
            'description' => 'required|string',
            'genre' => 'required|max:30',
            'director' => 'required|max:30',
            'budget' => 'required|int',
            'box_office' => 'required|int',
            'actor' => 'required|max:30',
            'cast' => 'required|max:30',
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
        $fetch_genre = Genre::firstOrCreate([
            'genre' => $request->genre,
        ]);
        // stores directors
        $fetch_director = Director::firstOrCreate([
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
        $fetch_actor = Actor::firstOrCreate([
            'name' => $request->actor
        ]);
        // stores casts
        $fetch_cast = Cast::firstOrCreate([
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

    public function show(Moviews $moviews)
    {
        return response()->json([
            'status' => 'posted',
            'movies' => $moviews,
        ], 200);
    }

    public function edit(Moviews $moviews)
    {
        // for retrieving uri form update
    }

    public function update(Request $request, Moviews $moviews)
    {   
        $movie = Moviews::findOrFail($moviews);

        // checks if the movie doesn't exists
        if (!$movie) {
            return response()->json(['message' => 'Movie Not Found'], 401);
        }

        // validates all incoming requests
        $validated = Validator::make($request->all(), [
            'title' => 'required|max:50|unique:moviews, title' . $moviews,
            'description' => 'required|string',
            'genre' => 'required|max:30',
            'director' => 'required|max:30',
            'budget' => 'required|int',
            'box_office' => 'required|int',
            'actor' => 'required|max:30',
            'cast' => 'required|max:30',
            'release_year' => 'nullable|date'
        ]);

         // returns an error if validation has issues
         if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Input(s)',
                'errors' => $validated->errors(),
            ], 403);
        }

        // for updating the genre
        $fetch_genre = Genre::firstOrCreate([
            'genre' => $request->genre,
        ]);

        // for updating the director
        $fetch_director = Director::firstOrCreate([
            'name' => $request->director
        ]);

        // for updating the budget budgets
        // It will find the budget id through movies table
        $fetch_budget = Budget::findOrFail($moviews->budget->id);
        // then updates the budget if exists
        $fetch_budget->update([
            'budget' => $request->budget
        ]);

        // for updating the budget box office
        // It will find the revenue id through movies table
        $fetch_box_office = BoxOffice::findOrFail($moviews->revenue->id);
        // then updates the revenue if exists
        $fetch_box_office->update([
            'revenue' => $request->box_office
        ]);

        // updating actors/actresses
        $fetch_actor = Actor::firstOrCreate([
            'name' => $request->actor
        ]);

        // updating casts
        $fetch_cast = Cast::firstOrCreate([
            'actor_id' => $fetch_actor->id
        ]);

        try {
            // fetches the new date input on standard format 'YYYY-MM-DD'
            $fetch_release = $request->release_year ? Carbon::parse($request->release_year)->toDateString() : now()->toDateString();

            // updates and persists data to the database
            $movie->fill([
                'title' => $request['title'],
                'description' => $request['description'],
                'genre_id' => $fetch_genre->id,
                'director_id' => $fetch_director->id,
                'budget_id' => $fetch_budget->id,
                'box_office_id' => $fetch_box_office->id,
                'cast_id' => $fetch_cast->id,
                'release_year' => $fetch_release
            ]);
            // saves the persists data to the database
            $movie->save();

            return response()->json([
                'message' => $request->title . ' was updated successfully',
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 403);
        } 
    }

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