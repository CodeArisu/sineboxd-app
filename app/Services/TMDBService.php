<?php

namespace App\services;

use Illuminate\Support\Facades\Http;

class TMDBService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.tmdb.base_url');
        $this->apiKey = config('services.tmdb.api_key');
    }

    public function fetchLatestMovies() 
    {
        $response = Http::get('{$this->baseUrl}movie/now_playing', [
            'api_key' => $this->apiKey,
            'language' => 'en_US',
            'page' => 1
        ]);

        return $response->json()['results'] ?? [];
    }

}
