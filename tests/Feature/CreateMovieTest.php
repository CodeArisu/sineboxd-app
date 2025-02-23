<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateMovieTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_new_movie() 
    {   
        $data = [
            'title' => 'Interstellar',
            'description' => 'Lorem Ipsum',
            'director' => 'Christopher Nolan',

            'genres' => [ 
                ['genre' => 'Sci-Fi'],
                ['genre' => 'Action'],
                ['genre' => 'Adventure']
            ],

            'actors' => [
                ['actor_name' => 'Matthew McConaughey'],
                ['actor_name' => 'Jessica Chastain'],
                ['actor_name' => 'Anne Hathaway'],
                ['actor_name' => 'Timothee Chalamet']
            ],

            'casts' => [
                ['role' => 'Main Character', 'character_name' => 'Cooper'],
                ['role' => 'Main Character', 'character_name' => 'Murphy'],
                ['role' => 'Supporting', 'character_name' => 'Brand'],
                ['role' => 'Supporting', 'character_name' => 'Tom']
            ],
            
            'budget' => 165,
            'box_office' => 730,
            'release_year' => '2014-6-11',
        ];

        $response = $this->postJson('/api/movie/create', $data);

        $response->assertStatus(201)
                 ->assertJson([
                    'message' => 'Movie created successfully'
        ]);
    }

}