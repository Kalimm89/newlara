<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    public function index() {
        $posts = Post::with('category')->orderBy('id', 'desc')->simplePaginate(2);
        return view('homes.index', compact('posts'));
    }

    public function show($slug) {
        $post = Post::where('slug' ,$slug)->firstOrFail();
        $post->views += 1;
        $post->update();
        return view('homes.show', compact('post'));
    }
}
