<?php

namespace App\Console\Commands;

use App\services\FetchCastsService;
use App\Services\FetchGenreService;
use App\Services\FetchMovieService;
use App\services\TMDBService;
use Illuminate\Console\Command;

abstract class FetchFromAPI extends Command
{
    protected string $endpoint;
    protected string $category;
    protected int $page;

    protected $description;

    protected $tmdbService;
    protected $movieService, $genreService, $castService;

    public function __construct(TMDBService $tmdbService)
    {
        parent::__construct();
        $this->tmdbService = $tmdbService;
        $this->movieService = new FetchMovieService();
        $this->genreService = new FetchGenreService();
        $this->castService = new FetchCastsService();
    }

    public function handle()
    {
        if (!$this->category || !$this->endpoint) {
            $this->error('Endpoint and Category is required!');
            return;
        }

        $this->info($this->description);
        // checks response from TMDB service
        $response = $this->tmdbService->fetchMovies($this->endpoint);

        $this->failedResponse($response, $this->category);
        // store files as json
        $extractedData = $response->json() ?? [];

        $totalPages = isset($this->page) ? $this->page : $extractedData['total_pages'];

        if ($totalPages === 0) {
            return $this->error("failed to fetch {$this->category} movies from TMDB API!.");
        }

        $this->info("Found total of {$totalPages} pages");
        $progressBar = $this->output->createProgressBar($totalPages);
        $progressBar->start();

        for ($page = 1; $page <= $totalPages; $page++) {
            $progressBar->advance();
            // collects pages on latest endpoint
            $response = $this->tmdbService->fetchMoviesByPages($this->endpoint, $page);
            if ($this->failedResponse($response, $this->category)) {
                return;
            }
            // stores movies results as json
            $movies = $response->json()['results'] ?? [];
            if (empty($movies)) {
                return $this->error("No movies found on page {$page}.");
            }

            $this->processMovies($movies);
            $this->info("Movies added on {$page} successfully!");
        }
        $progressBar->finish();
    }

    private function processMovies(array $movies): void
    {
        $movieProgressBar = $this->output->createProgressBar(count($movies));
        $movieProgressBar->start();

        foreach ($movies as $movie) {
            $movieProgressBar->advance();
            $this->processMovie($movie);
        }

        $movieProgressBar->finish();
        $this->newLine();
    }

    private function processMovie(array $movie): void
    {
        [$movieCredit, $movieDetail] = $this->movieDetails($movie['id']);
        if (!$movieCredit || !$movieDetail) {
            return;
        }

        $movieData = [
            'movieObj' => $movie,
            'director' => $movieCredit['crew'] ?? [],
            'budget' => $movieDetail['budget'] ?? null,
            'revenue' => $movieDetail['revenue'] ?? null,
            'category' => $this->category, // endpoint category
        ];

        // returns added movies
        $storedMovie = $this->movieService->storeMovies($movieData);
        // stores genre
        $this->genreService->storeMultipleGenre($storedMovie, $movieDetail['genres'] ?? []);
        // stores casts
        $this->castService->storeCast($storedMovie, $movieCredit['cast'] ?? []);
    }

    private function movieDetails(int $movieId): array
    {
        // extracts movie credits
        $movieCreditResponse = $this->tmdbService->fetchMoviesByDetails($movieId);
        if ($this->failedResponse($movieCreditResponse, 'movie credits')) {
            return [null, null];
        }

        // extracts movie details
        $movieDetailResponse = $this->tmdbService->fetchMoviesById($movieId);
        if ($this->failedResponse($movieCreditResponse, 'movie details')) {
            return [null, null];
        }

        return [$movieCreditResponse->json(), $movieDetailResponse->json()];
    }

    private function failedResponse($obj, $name) : bool
    {
        if ($obj->failed()) {
            $this->error("failed to fetch {$name} movies from TMDB API!.");
            Command::FAILURE;
            return true;
        }
        return false;
    }
}