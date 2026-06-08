<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request) {
        $posts = Post::with('author','category')->latest()->paginate(20);
        return view('admin.posts.index', compact('posts'));
    }

    public function create() {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories','tags'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'title'=>'required','content'=>'required','category_id'=>'nullable|exists:categories,id',
            'status'=>'required','excerpt'=>'nullable','featured'=>'boolean',
            'meta_title'=>'nullable','meta_description'=>'nullable',
        ]);
        $data['slug'] = Str::slug($data['title']);
        $data['author_id'] = auth()->id();
        if ($data['status'] === 'published') $data['published_at'] = now();
        $post = Post::create($data);
        if ($request->tags) $post->tags()->sync($request->tags);
        return redirect()->route('admin.posts.index')->with('success','Post created.');
    }

    public function edit(Post $post) {
        $categories = Category::all(); $tags = Tag::all();
        return view('admin.posts.edit', compact('post','categories','tags'));
    }

    public function update(Request $request, Post $post) {
        $data = $request->validate(['title'=>'required','content'=>'required','category_id'=>'nullable','status'=>'required','excerpt'=>'nullable','featured'=>'boolean']);
        if ($data['status'] === 'published' && !$post->published_at) $data['published_at'] = now();
        $post->update($data);
        if ($request->tags) $post->tags()->sync($request->tags);
        return redirect()->route('admin.posts.index')->with('success','Post updated.');
    }

    public function destroy(Post $post) {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success','Post deleted.');
    }
}
