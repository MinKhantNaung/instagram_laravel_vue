<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\PostsResource;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')
            ->get();

        return Inertia::render('Home', [
            'posts' => new PostsResource($posts),
            'allUsers' => User::all()
        ]);
    }
}
