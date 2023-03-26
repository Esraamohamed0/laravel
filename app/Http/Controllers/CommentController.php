<?php

namespace App\Http\Controllers;
use App\Models\Comment;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        Comment::create([
            'user_id' => $request->user_id,
            'body' => $request->body,
            'commentable_id' => $request->commentable_id,
            'commentable_type' => $request->commentable_type,
        ]);

        return back();
    }
}
