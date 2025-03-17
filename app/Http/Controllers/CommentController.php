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

        if ($validated->fails()) {
            return response()->json(
                [
                    'error' => 'fails to validate comment'
                ], 401
            );
        }

        Comments::create([
            'user_id' => auth()->user()->id,
            'movie_id' => $movie->id,
            'parent_id' => $request->parent_id,
            'content' => $request->content
        ]);

        return response()->json(
            [   
                'user_id' => auth()->user()->id,
                'movie_id' => $movie->id,
                'content' => $request->content
            ], 200
        );
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
