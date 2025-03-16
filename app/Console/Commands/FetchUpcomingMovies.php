<?php

namespace App\Console\Commands;

class FetchUpcomingMovies extends FetchFromAPI
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-upcoming-movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching Upcoming movies from TMDB';

    protected string $endpoint = 'movie/upcoming';
    protected string $category = 'upcoming';
    protected int $page = 3;
}
