<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsResource;
use App\Models\Post;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);

        if($user == null) {
            return redirect()->route('home.index');
        }

        $posts = Post::where('user_id', $user->id)
        ->orderBy('id', 'desc')
        ->get();

        return Inertia::render('User', [
            'user' => $user,
            'postsByUser' => new PostsResource($posts)
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:png,jpg,jpeg,svg,webp',
        ]);

        $user = (new FileService)->updateFile(auth()->user(), $request, 'post', 'user_images');

        $user->save();

        return redirect()->route('users.show', ['id' => auth()->user()->id]);
    }
}
