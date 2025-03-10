<?php

namespace App\Services;

use App\Models\BoxOffice;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Director;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FetchMovieService 
{   
    private $category;
    private $director, $budget, $revenue;

    private function storeCategories($category)
    {   
        return Category::firstOrCreate([
            'category' => $category
        ])->id;
    }

    private function storeDirector($crew)
    {   
        // only gets the directors name
        $director = collect($crew)->firstWhere('job', 'Director');
        return Director::firstOrCreate([
            'name' => $director['name']
        ])->id;
    }
    private function storeBudget($budget)
    {   
        return Budget::create([
            'budget' => $budget
        ])->id;
    }
    private function storeBoxOffice($revenue)
    {   
        return BoxOffice::create([
            'revenue' => $revenue
        ])->id;
    }

    private function distributeId($movieData) {
        // this functions maps out individual functions that returns each
        // corresponding id's
        try {
            // Start database transaction
            DB::beginTransaction();

            $this->director = $this->storeDirector($movieData['director']);
            $this->budget = $this->storeBudget($movieData['budget']);
            $this->revenue = $this->storeBoxOffice($movieData['revenue']);
            $this->category = $this->storeCategories($movieData['category']);

            DB::commit(); // Commit transaction if all succeed
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on failure
            Log::error("Transaction failed: " . $e->getMessage());
            throw new \Exception("Failed to store movie details");
        }
    }

    private function storeMovie($movie)
    {   
        if (empty($movie)) {
            Log::error("No movie is Found!");
            return [];
        }
        // movies are directly stored
        return Movie::firstOrCreate([
            'title' => $movie['title'],
            'description' => $movie['overview'],
            'director_id' => $this->director,
            'budget_id' => $this->budget,
            'box_office_id' => $this->revenue,
            'ratings' => $movie['vote_average'],
            'poster' => $movie['poster_path'],
            'category_id' => $this->category,
            'release_year' => $movie['release_date'],
        ]);
    }

    public function storeMovies($movieData)
    {   
        if (!isset($movieData['movieObj'])) {
            Log::error('No Object Found');
            return [];
        }

        $this->distributeId($movieData);
        return $this->storeMovie($movieData['movieObj']);
    }
}