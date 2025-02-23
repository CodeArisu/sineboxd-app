<?php

namespace App\Services;

use App\Models\Movie;

class FetchMovieService 
{  

    public function storeMovie(array $movies) 
    {
        return Movie::create($movies);
    }

    public function storeMultipleMovies(array $movies)
    {
        foreach ($movies as $movie)
        {
            $this->storeMovie($movie);
        }
    }

}