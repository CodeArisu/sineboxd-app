<?php

namespace App\Services;

use App\Models\BoxOffice;
use App\Models\Budget;
use App\Models\Director;
use App\Models\Movie;
use Illuminate\Support\Facades\Log;

class FetchMovieService 
{   

    public function storeDirector($crew)
    {   
        // only gets the directors name
        $director = collect($crew)->firstWhere('job', 'Director');
        return Director::firstOrCreate([
            'name' => $director['name']
        ])->id;
    }
    public function storeBudget($budget)
    {   
        return Budget::create([
            'budget' => $budget
        ])->id;
    }
    public function storeBoxOffice($revenue)
    {   
        return BoxOffice::create([
            'revenue' => $revenue
        ])->id;
    }

    private function storeMovie($movie, $director, $budget, $revenue)
    {   
        return Movie::firstOrCreate([
            'title' => $movie['title'],
            'description' => $movie['overview'],
            'director_id' => $director,
            'budget_id' => $budget,
            'box_office_id' => $revenue,
            'release_year' => $movie['release_date'],
        ]);
    }

    public function storeMovies($movie, $director, $budget, $revenue)
    {   
        if (!isset($movie)) {
            Log::info('No movie were found');
            return [];
        }

        $director = $this->storeDirector($director);
        $budget = $this->storeBudget($budget);
        $revenue = $this->storeBoxOffice($revenue);

        # stores movies simultaneous 
        return $this->storeMovie($movie, $director, $budget, $revenue);
    }

}