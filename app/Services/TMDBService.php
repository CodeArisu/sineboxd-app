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
        // movie with endpoint
        $apiUrl = "{$this->baseUrl}" . $endpoint;
        $response = Http::get($apiUrl, [
            'api_key' => $this->apiKey,
            'language' => $this->en_lang,
            'page' => $page
        ]);
        return $response;
    }

    public function fetchMoviesByDetails($id) {
        // movie id with endpoint
        $apiUrl = "{$this->baseUrl}movie/{$id}/credits";
        $response = Http::get($apiUrl, [
            'api_key' => $this->apiKey,
        ]);
        return $response;
    }

    public function fetchMoviesById($id) {
        // movie id endpoint
        $apiUrl = "{$this->baseUrl}movie/{$id}";
        $response = Http::get($apiUrl, [
            'api_key' => $this->apiKey,
        ]);
        return $response;
    }

    public function fetchMovieByPerson($id) {
        // movie id with actor endpoint
        $apiUrl = "{$this->baseUrl}person/{$id}";
        $response = Http::get($apiUrl, [
            'api_key' => $this->apiKey,
        ]);
        return $response;
    }

    public function fetchMovies($endpoint)
    {
        $response = Http::get("{$this->baseUrl}{$endpoint}", [
            'api_key' => $this->apiKey,
            'language' => $this->en_lang,
        ]);
        return $response;
    }
}
