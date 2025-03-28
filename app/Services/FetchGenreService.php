<?php

namespace App\Services;

use App\Models\Genre;
use Illuminate\Support\Facades\Log;

class FetchGenreService 
{   
    protected $movieGenres = [];
    protected function checkGenreArray($genres) {
        // checks if the genre is an array
        return !empty($genres) 
        || (is_array($genres) 
        && count($genres) > 0) ? true : false;
    }

    protected function storeGenre($genreName) {
        // inserts the data into genre
        return Genre::firstOrCreate([
            'name' => trim($genreName)
        ])->id;
    }

    public function storeMultipleGenre($newMovie, $movieGenre) {
        // filters genre names in movie genre
        $genreNames = collect($movieGenre)->pluck('name')->toArray();
        // checks movie id is array
        if (!$this->checkGenreArray($genreNames))
        {   
            Log::info('No genre were found');
            return [];
        }

        // returns movie genres into arrays
        $genreIds = collect($genreNames)
        ->map(function ($name) {
            return $this->storeGenre($name);
        })->toArray();

        // syncs the genre ids to the movie
        $newMovie->genres()->sync($genreIds);
    }
}