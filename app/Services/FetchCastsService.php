<?php

namespace App\services;

use App\Models\Actor;
use App\Models\Cast;
use App\Models\Gender;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FetchCastsService
{   
    private function checkActorArray($actors)
    {
        // checks if the actors is an array
        return !empty($actors) || (is_array($actors) && count($actors) > 0) ? true : false;
    }

    private function storeMultipleActors($actor)
    {    
        // locate gender not as id's
        $genderId = $this->storeGenders($actor['gender']); 
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
            Log::error('No actors were found');
            return collect();
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
        if (empty($actorData)) {
            Log::error('No gender Found!');
            return [];
        }
        // the casts is stored here indexing each movies
        // that has actors with character and known for department
        // attributes, for every loop the data from actor object
        // is distributed with index for actor id array saving
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
        // maps in accordance with the id as index
        $genderMapping = [
            1 => 'Female',
            2 => 'Male',
            3 => 'Non-binary'
        ];

        if (!isset($gender)) {
            Log::error('No gender Found!');
            return null;
        }

        // making sure that the gender id is mapped with constraint
        // of "Not Specified" to allow more than 2 id's
        $genderLabel = $genderMapping[$gender] ?? 'Not Specified';

        return Gender::firstOrCreate([
            'gender' => $genderLabel
        ])->id;
    }

    public function storeCast($movie, $actor)
    {
        // checks if the actor is null
        if (!isset($movie) && !isset($actor)) {
            Log::error('No movies and actors were found');
            return [];
        }

        try {
            DB::beginTransaction();

            $actorData = [
                'actorObj' => $actor, # raw data of actors
                'movieObj' => $movie, # stored movie data with new id's
                'storedActor' => $this->storeActor($actor), # stored data with new id's
            ];

            $this->storeMultipleCasts($actorData);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Transaction failed: " . $e->getMessage());
            throw new \Exception("Failed to store cast data");
        }
    }
}
