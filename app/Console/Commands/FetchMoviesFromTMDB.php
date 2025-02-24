<?php

namespace App\Console\Commands;

use App\Models\Movie;
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


    public function __construct(TMDBService $tmdbService)
    {
        parent::__construct();
        $this->tmdbService = $tmdbService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {   
        $movieService = new FetchMovieService();
        $this->info('Fetching number of pages from TMDB API!');
        // checks response from TMDB service
        $response = $this->tmdbService->fetchLatestMovies();

        // returns if there is a problem to the service.
        if ($response->failed()) {
            $this->error("failed to fetch latest movies from TMDB API.");
            return Command::FAILURE;
        }

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
            $response = $this->tmdbService->fetchMoviesByPages($this->endpoints[0], $page);
            
            if ($response->failed()) {
                $this->error("failed to fetch data from TMDB API on page->{$page}.");
                return Command::FAILURE;
            }

            $movies = $response->json()['results'] ?? [];

            foreach ($movies as $movie) {
                $progressBar->advance();
                // checks if there is movie to be found
                if(!$movie) {
                    $this->error("No movies found.");
                    return Command::FAILURE;
                    break;
                }

                $movieCreditResponse = $this->tmdbService->fetchMoviesByDetails($this->endpoints[2], $movie['id']);
                if ($movieCreditResponse->failed()) {
                    $this->error("failed to fetch crew on {$movies->title} from TMDB API at page->{$page}.");
                    return Command::FAILURE;
                }

                $movieDetailResponse = $this->tmdbService->fetchMoviesById($movie['id']);
                if ($movieDetailResponse->failed()) {
                    $this->error("failed to fetch crew on {$movies->title} from TMDB API at page->{$page}.");
                    return Command::FAILURE;
                }

                // only filters crew column
                $movieCredit = $movieCreditResponse->json();
                $movieDetail = $movieDetailResponse->json();

                // extract relevant data
                $crew = $movieCredit['crew'] ?? [];
                $budget = $movieDetail['budget'] ?? null;
                $revenue = $movieDetail['revenue'] ?? null;

                // stores each data individually
                $movieService->storeDirector($crew);
                $movieService->storeBudget($budget);
                $movieService->storeBoxOffice($revenue);
                
                $movieService->storeMovie($movie);
            }
        }

        $progressBar->finish();
        $this->newLine();
        $this->info('Movies added successfully');
        return Command::SUCCESS;
    }
}
