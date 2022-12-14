<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;


class PostController extends Controller
{
   
    public function index()
    {
        $posts = Post::with('category', 'tags')->simplePaginate(4);
        return view('admin.posts.index', compact('posts'));
    }

   
    public function create()
    {
        $categories = Category::pluck('title', 'id')->all();
        $tags = Tag::pluck('title', 'id')->all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image'
        ]);
        
        $data = $request->all();
        $data['thumbnail'] = Post::uploadImage($request);

        $post = Post::create($data);
        $post->tags()->sync($request->tags);
        return redirect()->route('posts.index')->with('success', 'Статья добавлена');
    }

  
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::pluck('title', 'id')->all();
        $tags = Tag::pluck('title', 'id')->all();
        return view('admin.posts.edit', compact('tags', 'categories', 'post'));
    }

 
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image'
        ]);
        $post = Post::find($id);

        $data = $request->all();

            if($file = Post::uploadImage($request, $post->thumbnail)) {
                $data['thumbnail'] = $file;
            }

        $post->update($data);
        $post->tags()->sync($request->tags);
        return redirect()->route('posts.index')->with('success', 'Изменения сохранены');
    }

  
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->tags()->sync([]);
        Storage::delete($post->thumbnail);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Статья удалена');
    }
}
