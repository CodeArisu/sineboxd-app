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

        dd($this->endpoint, $this->category);

        $this->info("Fetching {$this->category} from TMDB API!");
        // checks response from TMDB service
        $response = $this->tmdbService->fetchMovies($this->endpoint);

        $this->failedResponse($response, $this->category);
        // store files as json
        $extractedData = $response->json()['results'] ?? [];
        $totalPages = $extractedData['total_pages'] ?? 0;

        if ($totalPages === 0) {
            $this->error("failed to fetch {$this->category} movies from TMDB API!.");
            return;
        }

        $this->info("Found total of {$totalPages} pages");
        $progressBar = $this->output->createProgressBar($totalPages);
        $progressBar->start();

        for ($page = 1; $page <= $totalPages; $page++) {
            $progressBar->advance();
            // collects pages on latest endpoint
            $response = $this->tmdbService->fetchMoviesByPages($this->endpoint, $page);
            $this->failedResponse($response, 'latest movies');
            // stores movies results as json
            $movies = $response->json()['results'] ?? [];

            $this->newLine();
            $movieProgressBar = $this->output->createProgressBar(count($movies));
            $movieProgressBar->start();

            foreach ($movies as $movie) {
                $movieProgressBar->advance(); // Track movie progress
                // checks if there is movie to be found
                if(!$movie) {
                    $this->error("No movies found.");
                    return;
                }

                // extracts movie credits
                $movieCreditResponse = $this->tmdbService->fetchMoviesByDetails($this->endpoint, $movie['id']);
                $this->failedResponse($movieCreditResponse, 'movie credits');

                // extracts movie details
                $movieDetailResponse = $this->tmdbService->fetchMoviesById($movie['id']);
                $this->failedResponse($movieDetailResponse, 'movie details');

                // extract relevant data
                $movieCredit = $movieCreditResponse->json();
                $movieDetail = $movieDetailResponse->json();

                $actor = $movieCredit['cast'] ?? [];
                $genre = $movieDetail['genres'] ?? [];
                
                $movieData = [
                    'movieObj' => $movie,
                    'director' => $movieCredit['crew'] ?? [],
                    'budget' => $movieDetail['budget'] ?? null,
                    'revenue' => $movieDetail['revenue'] ?? null,
                    'category' => $this->category // endpoint
                ];

                // returns added movies
                $newMovie = $this->movieService->storeMovies($movieData);
                // stores genre
                $this->genreService->storeMultipleGenre($newMovie, $genre);
                // stores casts
                $this->castService->storeCast($newMovie, $actor);
            }
            
            $movieProgressBar->finish(); // Finish the movie progress bar
            $this->newLine();
            $this->info("Movies added on {$page} successfully!");
        }
    }

    private function failedResponse($obj, $name) {
        if ($obj->failed()) {
            $this->error("failed to fetch {$name} movies from TMDB API!.");
            return Command::FAILURE;
        }
    }
}
