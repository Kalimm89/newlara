<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request) {
        $request->validate([
            's' => 'required'
        ]);

        $s = $request->s;
        $posts = Post::like($s)->with('category')->simplePaginate(2);
        return view('homes.search', compact('posts', 's'));
    }
}
