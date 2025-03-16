<?php

namespace App\Console\Commands;

class FetchPopularMovies extends FetchFromAPI
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:popular-movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch popular Movies from TMDB and store in Database';

    protected string $endpoint = 'movie/popular';
    protected string $category = 'popular';
    protected int $page = 3;
}
