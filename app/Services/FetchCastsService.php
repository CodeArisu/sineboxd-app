<?php

namespace App\services;

use App\Models\Actor;
use App\Models\Cast;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FetchCastsService
{
    protected function checkActorArray($actors)
    {
        // checks if the actors is an array
        return !empty($actors) || (is_array($actors) && count($actors) > 0) ? true : false;
    }

    private function storeActor($movieActors)
    {
        // stores to database
        return Actor::firstOrCreate([
            'name' => $movieActors['name'],
            'nationality' => $movieActors['nationality'] ?? 'Unknown',
        ]);
    }

    public function storeMultipleActors($actor)
    {
        // checks if the actors is array
        if (!$this->checkActorArray($actor)) {
            Log::info('No actors were found');
            return [];
        }
        // stores the actor
        $storeActors = collect();

        foreach ($actor as $movieActors) {
            $storeActors->push($this->storeActor($movieActors));
        }

        return $storeActors;
    }

    public function storeCast($movie, $actor)
    {
        // checks if the actor is null
        if (!isset($movie) && !isset($actor)) {
            Log::info('No movies and actors were found');
            return [];
        }

        $storedActors = $this->storeMultipleActors($actor);

        // limits the character
        foreach ($storedActors as $index => $actors) {

            Cast::create([
                'movie_id' => $movie->id,
                'actor_id' => $actors->id,
                'character_name' => $actor[$index]['character'] ?? 'Unknown',
                'role' => $actors->role ?? 'Actor',
            ]);
        }
        
    }
}
