<?php

namespace App\View\Components;

use App\Models\Movie;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReviewEditor extends Component
{
    public $movie;

    public function __construct(Movie $movie)
    {
        $this->$movie = $movie;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.review-editor');
    }
}
