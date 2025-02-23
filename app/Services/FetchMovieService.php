<?php

namespace App\Services;

use App\Models\Movie;

class FetchMovieService 
{  

    public function storeMovie(array $movies) 
    {   
        // stores movies at a time
        return Movie::create($movies);
    }

    public function storeMultipleMovies(array $movies)
    {   
        # stores movies simultaneous 
        foreach ($movies as $movie)
        {
            $this->storeMovie($movie);
        }
    }

}