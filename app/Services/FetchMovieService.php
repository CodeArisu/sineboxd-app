<?php

namespace App\Services;

use App\Models\BoxOffice;
use App\Models\Budget;
use App\Models\Director;
use App\Models\Movie;

class FetchMovieService 
{   
    protected $director;
    protected $budget;
    protected $boxOffice;

    public function storeDirector($crew)
    {   
        // only gets the directors name
        $director = collect($crew)->firstWhere('job', 'Director');
        $this->director = Director::updateOrCreate([
            'name' => $director['name']
        ]);
    }
    public function storeBudget($budget)
    {   
        $this->budget = Budget::create([
            'budget' => $budget
        ]);
    }
    public function storeBoxOffice($revenue)
    {   
        $this->boxOffice = BoxOffice::create([
            'revenue' => $revenue
        ]);
    }

    public function storeMovie($movie) 
    {   
        return Movie::updateOrCreate([
            'title' => $movie['title'],
            'description' => $movie['overview'],
            'director_id' => $this->director->id,
            'budget_id' => $this->budget->id,
            'box_office_id' => $this->boxOffice->id,
            'release_year' => $movie['release_date'],
        ]);
    }

    public function storeMultipleMovies($movies)
    {   
        # stores movies simultaneous 
        foreach ($movies as $movie)
        {   
            
            $this->storeMovie($movie);
        }
    }

}