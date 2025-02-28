<?php

namespace App\Console\Commands;

use App\services\FetchCastsService;
use App\Services\FetchGenreService;
use App\Services\FetchMovieService;
use App\services\TMDBService;
use Illuminate\Console\Command;

class FetchMoviesFromTMDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Movies from TMDB and store in Database';

    protected $endpoints = ['now_playing', 'popular', 'credits'];
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

    /**
     * Execute the console command.
     */
    public function handle()
    {   
        $this->info('Fetching number of pages from TMDB API!');
        // checks response from TMDB service
        $response = $this->tmdbService->fetchLatestMovies();

        // returns if there is a problem to the service.
        $this->failedResponse($response, 'latest movies');

        // store files as json
        $movieData = $response->json();
        $totalPages = $movieData['total_pages'] ?? 0;

        // returns if there are no pages fetched
        if ($totalPages === 0) {
            $this->error("No pages found.");
            return Command::FAILURE;
        }

        $this->info("found total of {$totalPages} pages");
        // adds progress bar
        $progressBar = $this->output->createProgressBar($totalPages);
        $progressBar->start();

        // loops through the process of fetching pages
        for ($page = 1; $page <= $totalPages; $page++) {
            $progressBar->advance();
            // collects pages on latest endpoint
            $response = $this->tmdbService->fetchMoviesByPages($this->endpoints[0], $page);
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
                    return Command::FAILURE;
                    break;
                }

                // extracts movie credits
                $movieCreditResponse = $this->tmdbService->fetchMoviesByDetails($this->endpoints[2], $movie['id']);
                $this->failedResponse($movieCreditResponse, 'movie credits');

                // extracts movie details
                $movieDetailResponse = $this->tmdbService->fetchMoviesById($movie['id']);
                $this->failedResponse($movieDetailResponse, 'movie details');

                // extract relevant data
                $movieCredit = $movieCreditResponse->json();
                $movieDetail = $movieDetailResponse->json();

                $crew = $movieCredit['crew'] ?? [];
                $actor = $movieCredit['cast'] ?? [];
                $budget = $movieDetail['budget'] ?? null;
                $revenue = $movieDetail['revenue'] ?? null;
                $genre = $movieDetail['genres'] ?? [];

                // returns added movies
                $newMovie = $this->movieService->storeMovies($movie, $crew, $budget, $revenue);
                // stores genre
                $this->genreService->storeMultipleGenre($newMovie, $genre);
                // stores casts
                $this->castService->storeCast($newMovie, $actor);
            }
            
            $movieProgressBar->finish(); // Finish the movie progress bar
            $this->newLine();
            $this->info("Movies added on {$page} successfully!");
        }

        $progressBar->finish();
        $this->newLine();
        $this->info('Movies added successfully');
        return Command::SUCCESS;
    }

    private function failedResponse($obj, $name) {
        if ($obj->failed()) {
            $this->error("failed to fetch {$name} from TMDB API!.");
            return Command::FAILURE;
        }
    }
}