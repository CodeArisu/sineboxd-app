<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ReviewCard extends Component
{
    public $username, $review, $rating, $likes, $comments, $profileImage;

    public function __construct($username, $review, $rating, $likes, $comments, $profileImage = null)
    {
        $this->username = $username;
        $this->review = $review;
        $this->rating = $rating;
        $this->likes = $likes;
        $this->comments = $comments;
        $this->profileImage = $profileImage ?? asset('default-profile.png'); // Default profile image
    }

    public function render()
    {
        return view('components.review-card');
    }
}
