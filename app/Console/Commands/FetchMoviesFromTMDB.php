<?php

namespace App\Console\Commands;

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
        $movies = $this->tmdbService->fetchLatestMovies();
        $movieService = new FetchMovieService();

        $movieService->storeMultipleMovies($movies);
    }
}
