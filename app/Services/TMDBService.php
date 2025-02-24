<?php

namespace App\services;

use Illuminate\Support\Facades\Http;

class TMDBService
{
    protected $baseUrl;
    protected $apiKey;
    protected $en_lang;

    public function __construct()
    {
        $this->baseUrl = config('services.tmdb.base_url');
        $this->apiKey = config('services.tmdb.api_key');
        $this->en_lang = 'en-US';
    }

    // indirect fetching through endpoint and pages
    public function fetchMoviesByPages($endpoint, $page) {
        $apiUrl = "{$this->baseUrl}movie/{$endpoint}";
        $response = Http::get($apiUrl, [
            'api_key' => $this->apiKey,
            'language' => $this->en_lang,
            'page' => $page
        ]);
        return $response;
    }

    public function fetchMoviesByDetails($endpoint, $id) {
        $apiUrl = "{$this->baseUrl}movie/{$id}/{$endpoint}";
        $response = Http::get($apiUrl, [
            'api_key' => $this->apiKey,
        ]);
        return $response;
    }

    public function fetchMoviesById($id) {
        $apiUrl = "{$this->baseUrl}movie/{$id}";
        $response = Http::get($apiUrl, [
            'api_key' => $this->apiKey,
        ]);
        return $response;
    }

    public function fetchLatestMovies() 
    {   
        // API url endpoint
        $apiUrl = "{$this->baseUrl}movie/now_playing";
        // gets latest movies from now_playing endpoint
        $response = Http::get($apiUrl, [
            'api_key' => $this->apiKey,
            'language' => $this->en_lang,
        ]);
        return $response;
    }

    public function fetchPopularMovies()
    {   
        // gets latest movies from popular endpoint
        $response = Http::get("{$this->baseUrl}movie/popular", [
            'api_key' => $this->apiKey,
            'language' => $this->en_lang,
        ]);
        return $response;
    }

}
