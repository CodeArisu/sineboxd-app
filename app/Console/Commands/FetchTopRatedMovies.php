<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchTopRatedMovies extends FetchFromAPI
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-top-rated-movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Top Rated Movies from TMDB and store in Database';

    protected string $endpoint = 'movie/top_rated';
    protected string $category = 'rated';
    protected int $page = 3;
}
