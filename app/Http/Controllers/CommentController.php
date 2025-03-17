<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index() {

    }

    public function createComment() {

    }

    public function storeComment(Request $request, Movie $movie) 
    {
        $validated = Validator::make($request->all(), [
            'movie_id' => 'required|int|exists:movies,id',
            'content' => 'required|max:255|string',
            'parent_id' => 'nullable|int'
        ]);

        Comments::create([
            'user_id' => 2,
            'movie_id' => $movie->id,
            'parent_id' => $request->parent_id,
            'content' => $request->content
        ]);

        return back()->with('success', 'Comment Added');
    }

    public function show(Movie $movie) {
        
    }

    public function deleteComment(Comments $comments) 
    {
        $comment = Comments::findOrFail($comments->id);
        if (!$comment) {
            return response()->json(
                [   
                  'error' => 'Unauthorized'
                ], 403
            );
        }

        $comment->delete();
        return response()->json(
            [   
              'success' => 'Comment deleted successfully!'
            ], 200
        );
    }

}
