<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{   
    private function validateComment(Request $request) {
        return Validator::make($request->all(), [
            'movie_id' => 'required|int|exists:movies,id',
            'content' => 'required|max:255|string',
            'parent_id' => 'nullable|int'
        ]);
    }

    public function showComment(Movie $movie, Comments $comment) {
        $year = Carbon::parse($movie->release_year)->year;
        return view('page.movie', [
            'movie' => $movie,
            'comments' => $movie->comments()
            ->whereNull('parent_id')
            ->with('replies.user', 'user')
            ->latest()
            ->get(),
            'year' => $year
        ]);
    }

    public function storeComment(Request $request, Movie $movie) 
    {
        $this->validateComment($request);

        Comments::create([
            'user_id' => 2,
            'movie_id' => $movie->id,
            'parent_id' => $request->parent_id,
            'content' => $request->content
        ]);

        return back()->with('success', 'Comment Added');
    }

    public function updateComment(Request $request, Movie $movie, Comments $comment) 
    {
        $this->validateComment($request);

        Comments::where('id', $comment->id)->update([
            'user_id' => 2,
            'movie_id' => $movie->id,
            'parent_id' => $request->parent_id,
            'content' => $request->content
        ]);

        return back()->with('success', 'Comment Updated');
    }

    public function deleteComment(Comments $comment) 
    {
        if (!$comment) {
            return back()->with('error', 'An Error Has Occurred');
        }

        if ($comment->parent_id === null) {
            $comment->replies()->delete();
        }

        $comment->delete();
        return back()->with('success', 'Comment Deleted');
    }
}