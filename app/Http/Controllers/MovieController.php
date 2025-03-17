<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\BoxOffice;
use App\Models\Budget;
use App\Models\Cast;
use App\Models\Director;
use App\Models\Genre;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        // retrieve form for creating movie
    }

    // validates incoming request data
    protected function request_validation(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required|max:50|unique:movies',
            'description' => 'required|string',
            'director' => 'required|max:255',

            // resolves array genres
            'genres.*.genre' => 'required|string',

            // resolves actors
            'actors.*.actor_name' => 'required|string|max:255',

            // multiple actors array
            'casts.*.character_name' => 'required|string|max:255',
            'casts.*.role' => 'nullable|string|max:255',

            'budget' => 'required|int',
            'box_office' => 'required|int',
            'release_year' => 'nullable|date',
        ]);

        // returns an error if validation has issues
        if ($validated->fails()) {
            return response()->json(
                [
                    'message' => 'Invalid Input(s)',
                    'errors' => $validated->errors(),
                ],
                403,
            );
        }

        return $validated;
    }

    // checks genre request array
    protected function check_genre_array($request)
    {
        return !empty($request->genres) 
        || (is_array($request->genres) 
        && count($request->genres) > 0) ? true : false;
    }
    // checks actor request array
    protected function check_actor_array($request)
    {
        return !empty($request->actors) 
        || (is_array($request->actors) 
        && count($request->actors) > 0) ? true : false;
    }

    // queries genres
    protected function insert_genre($request, $movie)
    {
        if ($this->check_genre_array($request)) {
            $genreNames = collect($request['genres'])->pluck('genre')->toArray();
            // name of genres
            $genreIds = collect($genreNames)
                ->map(function ($name) {
                    return Genre::firstOrCreate(['genre' => trim($name)])->id;
                })
                ->toArray();
            // stores genres

            $movie->genre()->sync($genreIds);
        }
    }

    // queries actors
    protected function insert_actor($request)
    {
        # checks if the requests actors are present
        if ($this->check_actor_array($request)) {
            $actors = collect();
            foreach ($request->actors as $actorData) {
                $actor = Actor::firstOrCreate(
                    ['name' => $actorData['actor_name']], // Ensure uniqueness
                    ['nationality' => $actorData['nationality'] ?? 'Unknown']
                );
            $actors->push($actor); // Store all inserted/found actors
        }

        return $actors; // Return a collection of actors
        } else {
            return Actor::firstOrCreate([
                'name' => $request->actor_name,
                'nationality' => $request->nationality ?? 'Unknown',
            ]);
        }
    }

    // queries movies
    public function insert_movie($request)
    {
        // validates date or return default format
        $fetch_release = $request->release_year 
        ? Carbon::parse($request->release_year)->toDateString() 
        : now()->toDateString();
        // stores directors
        $fetch_director = Director::firstOrCreate([
            'name' => $request->director,
        ]);
        // stores budgets
        $fetch_budget = Budget::create([
            'budget' => $request->budget,
        ]);
        // stores revenue
        $fetch_box_office = BoxOffice::create([
            'revenue' => $request->box_office,
        ]);

        $movie = Movie::create([
            'title' => $request->title,
            'description' => $request->description,
            'director_id' => $fetch_director->id,
            'budget_id' => $fetch_budget->id,
            'box_office_id' => $fetch_box_office->id,
            'release_year' => $fetch_release,
        ]);
        
        return $movie;
    }

    // queries casts
    protected function insert_cast($request, $movie, $actor)
    {
        foreach ($request['casts'] as $index => $cast) {
            if (isset($actor[$index])) { // Ensure actor exists for this role
                Cast::firstOrCreate([
                    'movie_id' => $movie->id,
                    'actor_id' => $actor[$index]->id, // Correctly assign actor
                    'character_name' => $cast['character_name'],
                    'role' => $cast['role'] ?? 'Support',
                ]);
            } else {
                Cast::firstOrCreate([
                    'movie_id' => $movie->id,
                    'actor_id' => $actor->id,
                    'character_name' => $request->character_name,
                    'role' => $request->role ?? "Support"
                ]);
            }
        }
    }

    public function store(Request $request)
    {
        // validates overall requests
        $this->request_validation($request);
        try {
            // using db transactions for mass inserts
            DB::beginTransaction();

            $actor = $this->insert_actor($request);
            $movie = $this->insert_movie($request);
            $this->insert_genre($request, $movie);
            $this->insert_cast($request, $movie, $actor);
            // commit transactions
            DB::commit();

            return response()->json(
                [
                    'message' => $request->title . ' was added successfully',
                ],
                201,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'An error occurred',
                    'error' => $e->getMessage(),
                ],
                403,
            );
        }
    }

    public function show(Movie $movie)
    {   
        $year = Carbon::parse($movie->release_year)->year;
        return view('page.movie', [
            'movie' => $movie,
            'comments' => $movie->comments()
            ->whereNull('parent_id')
            ->with('replies.user', 'user')
            ->latest()
            ->get(),
            'year' => $year
        ]);
    }

    public function edit(Movie $movie)
    {
        // for retrieving uri form update
    }

    protected function update_actors($request) {
         # checks if the requests actors are present
         if ($this->check_actor_array($request)) {
            $actors = collect();
            foreach ($request->actors as $actorData) {
                $actor = Actor::updateOrCreate(
                    ['name' => $actorData['actor_name']], // Ensure uniqueness
                    ['nationality' => $actorData['nationality'] ?? 'Unknown']
                );

            $actors->push($actor); // Store all inserted/found actors
        }

        return $actors; // Return a collection of actors
        } else {
            return Actor::updateOrCreate([
                'name' => $request->actor_name,
                'nationality' => $request->nationality ?? 'Unknown',
            ]);
        }
    }

    protected function update_casts($request, $movie, $actor) {
        // updating casts
        foreach ($request['casts'] as $index => $cast) {
            if (isset($actor[$index])) { // Ensure actor exists for this role
                Cast::firstOrCreate([
                    'movie_id' => $movie->id,
                    'actor_id' => $actor[$index]->id, // Correctly assign actor
                    'character_name' => $cast['character_name'],
                    'role' => $cast['role'] ?? 'Support',
                ]);
            } else {
                Cast::firstOrCreate([
                    'movie_id' => $movie->id,
                    'actor_id' => $actor->id,
                    'character_name' => $request->character_name,
                    'role' => $request->role ?? "Support"
                ]);
            }
        }
    }

    public function update(Request $request, Movie $movie)
    {
        // finds the row from the movies table
        $movie = Movie::findOrFail($movie->id) ?? Movie::firstOrFail($movie->id);
        // checks if the movie doesn't exists
        if (!$movie) {
            return response()->json(['message' => 'Movie Not Found'], 401);
        }
        // validates incoming requests
        $this->request_validation($request);

        // fetches the new date input on standard format 'YYYY-MM-DD'
        $fetch_release = $request->release_year ? Carbon::parse($request->release_year)->toDateString() : now()->toDateString();

        // for updating the budget budgets
        // It will find the budget id through movies table
        $fetch_budget = Budget::findOrFail($movie->id) ? Budget::where('id', $movie->id)->firstOrFail() : response()->json(['error' => 'Budget not found'], 404);

        // for updating the budget box office
        // It will find the revenue id through movies table
        $fetch_box_office = BoxOffice::findOrFail($movie->id) ? BoxOffice::where('id', $movie->id)->firstOrFail() : response()->json(['error' => 'Box Office not found'], 404);

        try {
            // for updating the director
            $fetch_director = Director::updateOrCreate([
                'name' => $request->director,
            ]);
            // then updates the budget if exists
            $fetch_budget->update([
                'budget' => $request->budget,
            ]);
            // then updates the revenue if exists
            $fetch_box_office->update([
                'revenue' => $request->box_office,
            ]);
            // updating actors/actresses
            $actors = $this->update_actors($request);
            // updates and persists data to the database
            $movie->fill([
                'title' => $request->title,
                'description' => $request->description,
                'director_id' => $fetch_director->id,
                'budget_id' => $fetch_budget->id,
                'box_office_id' => $fetch_box_office->id,
                'release_year' => $fetch_release,
                'updated_at' => now(),
            ]);

            // updates casts
            $this->update_casts($request, $movie, $actors);
            // saves the persists data to the database
            $movie->save();

            // for updating multiple genre
            $fetch_genre = $movie->genres()->pluck('id')->toArray();
            if (!empty($fetch_genre)) {
                $movie->genres()->sync($request->genres);
            }

            return response()->json(
                [
                    'message' => $request->title . ' was updated successfully',
                ],
                201,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'An error occurred',
                    'error' => $e->getMessage(),
                ],
                403,
            );
        }
    }

    public function destroy(Movie $movie)
    {
        // finds and check the movie with the id as parameter
        $movie = Movie::findOrFail($movie->id);
        // checks if the movie doesn't exists
        if (!$movie) {
            return response()->json(['message' => 'Movie Not Found'], 401);
        }
        // deletes the movie
        $movie->delete();
        return response()->json(['message' => 'Movie deleted successfully'], 200);
    }
}
