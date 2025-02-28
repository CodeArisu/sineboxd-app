<?php

namespace App\Console\Commands;

class FetchLatestMovies extends FetchFromAPI
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:latest-movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Latest Movies from TMDB and store in Database';

    protected string $endpoint = 'movie/now_playing';
    protected string $category = 'latest';
}