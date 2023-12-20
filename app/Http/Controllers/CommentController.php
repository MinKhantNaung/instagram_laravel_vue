<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'post_id' => 'required|integer',
            'text' => 'required|string'
        ]);

        Comment::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'text' => $request->text,
        ]);
    }

    public function destroy($id)
    {
        Comment::find($id)->delete();
    }
}
