<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\FileService;

class PostController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $post = new Post;

        $request->validate([
            'text' => 'required',
            'file' => 'required|image|mimes:png,jpg,jpeg,svg,webp'
        ]);

        $post = (new FileService)->updateFile($post, $request, 'post');

        $post->user_id = auth()->user()->id;
        $post->text = $request->text;
        $post->save();
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if(!empty($post->file)) {
            $current_file = public_path() . $post->file;

            if(file_exists($current_file)) {
                unlink($current_file); // delete
            }
        }

        $post->delete();
    }
}
