<?php

namespace App\Services;

use App\Models\Genre;

class FetchGenreService 
{   
    protected $movieGenres = [];
    protected function checkGenreArray($genres) {
        // checks if the genre is an array
        return !empty($genres) 
        || (is_array($genres) 
        && count($genres) > 0) ? true : false;
    }

    public function storeGenre($genreName) {
        // inserts the data into genre
        return Genre::firstOrCreate([
            'genre' => trim($genreName)
        ])->id;
    }

    public function storeMultipleGenre($movieGenre) {
        // checks movie id is array
        $genreNames = collect($movieGenre)->pluck('name')->toArray();

        if (!$this->checkGenreArray($genreNames))
        {   
            return [];
        }

        $genreIds = collect($genreNames)
        ->map(function ($name) {
            return $this->storeGenre($name);
        })
        ->toArray();

        return $genreIds;
    }
}