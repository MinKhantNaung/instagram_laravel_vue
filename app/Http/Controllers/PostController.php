<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\FileService;
use Illuminate\Support\Facades\Storage;

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

        $post = (new FileService)->updateFile($post, $request, 'post', 'post_images');

        $post->user_id = auth()->user()->id;
        $post->text = $request->text;
        $post->save();
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if(!empty($post->file)) {
            Storage::delete('public/images/' . $post->file);
        }

        $post->delete();
    }
}
