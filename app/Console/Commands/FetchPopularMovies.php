<?php

namespace App\Console\Commands;

class FetchPopularMovies extends FetchFromAPI
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:popular-movies {--pages=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Popular Movies from TMDB and store in Database';

    protected string $endpoint = 'movie/popular';
    protected string $category = 'popular';
}
