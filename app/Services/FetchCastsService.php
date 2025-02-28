<?php

namespace App\services;

use App\Models\Actor;
use App\Models\Cast;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FetchCastsService
{
    private function checkActorArray($actors)
    {
        // checks if the actors is an array
        return !empty($actors) || (is_array($actors) && count($actors) > 0) ? true : false;
    }

    private function storeMultipleActors($movieActors)
    {
        // stores to database
        return Actor::firstOrCreate([
            'name' => $movieActors['name'],
            'nationality' => $movieActors['nationality'] ?? 'Unknown',
        ]);
    }

    private function storeActor($actor)
    {
        // checks if the actors is array
        if (!$this->checkActorArray($actor)) {
            Log::info('No actors were found');
            return [];
        }
        // stores the actor
        $storeActors = collect();

        // loops through the actors then stores them each
        foreach ($actor as $movieActors) {
            $storeActors->push($this->storeMultipleActors($movieActors));
        }

        return $storeActors;
    }

    private function storeMultipleCasts($movie, $storedActors, $actorData) {
        foreach ($storedActors as $index => $actors) {
            Cast::firstOrCreate([
                'movie_id' => $movie['id'],
                'actor_id' => $actors['id'],
                'character_name' => $actorData[$index]['character'] ?? 'Unknown',
                'known_for' => $actorData['known_for'] ?? 'Unknown',
            ]);
        }
    }

    public function storeCast($movie, $actor)
    {
        // checks if the actor is null
        if (!isset($movie) && !isset($actor)) {
            Log::info('No movies and actors were found');
            return [];
        }

        $storedActors = $this->storeActor($actor);

        $this->storeMultipleCasts($movie, $storedActors, $actor);
    }
}
