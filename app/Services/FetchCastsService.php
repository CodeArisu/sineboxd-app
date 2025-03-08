<?php

namespace App\services;

use App\Models\Actor;
use App\Models\Cast;
use App\Models\Gender;
use Illuminate\Support\Facades\Log;

class FetchCastsService
{   
    private $storedActors;

    private function checkActorArray($actors)
    {
        // checks if the actors is an array
        return !empty($actors) || (is_array($actors) && count($actors) > 0) ? true : false;
    }

    private function storeMultipleActors($actor)
    {    
        $genderId = $this->storeGenders($actor['gender']); // locate gender not as id's
        // stores to database
        return Actor::firstOrCreate([
            'name' => $actor['name'],
            'nationality' => $actor['nationality'] ?? 'Unknown',
            'gender_id' => $genderId,
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

    private function storeMultipleCasts($actorData) {
        foreach ($actorData['actorObj'] as $index => $actors) {
            Cast::firstOrCreate([
                'movie_id' => $actorData['movieObj']['id'],
                'actor_id' => $actorData['storedActor'][$index]['id'], 
                'character_name' => $actors['character'] ?? 'Unknown',
                'known_for' => $actors['known_for_department'] ?? 'Unknown',
            ]);
        }
    }

    private function storeGenders($gender)
    {   
        $genderMapping = [
            1 => 'Female',
            2 => 'Male',
            3 => 'Non-binary'
        ];

        if (!isset($gender)) {
            Log::info('No gender Found!');
            return null;
        }

        $genderLabel = $genderMapping[$gender] ?? 'Not Specified';

        return Gender::firstOrCreate([
            'gender' => $genderLabel
        ])->id;
    }

    public function storeCast($movie, $actor)
    {
        // checks if the actor is null
        if (!isset($movie) && !isset($actor)) {
            Log::info('No movies and actors were found');
            return [];
        }

        $actorData = [
            'actorObj' => $actor, # raw data of actors
            'movieObj' => $movie, # stored movie data with new id's
            'storedActor' => $this->storeActor($actor), # stored data with new id's
        ];

        $this->storeMultipleCasts($actorData);
    }
}
