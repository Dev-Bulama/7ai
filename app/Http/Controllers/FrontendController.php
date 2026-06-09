<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

class FrontendController extends Controller
{
    public function home()       { return view('public.index'); }
    public function solutions()  { return view('public.solutions'); }
    public function smartHomes() { return view('public.smart-homes'); }
    public function aiSolutions(){ return view('public.ai-solutions'); }
    public function pricing()    { return view('public.pricing'); }
    public function caseStudies(){ return view('public.case-studies'); }
    public function industries() { return view('public.industries'); }
    public function about()      { return view('public.about'); }
    public function careers()    { return view('public.careers'); }
    public function support()    { return view('public.support'); }
    public function docs()       { return view('public.docs'); }
    public function privacy()    { return view('public.privacy'); }
    public function terms()      { return view('public.terms'); }

    public function contact()
    {
        return view('public.contact');
    }

    public function blog()
    {
        $posts = Post::with('author', 'category')
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->paginate(9);
        $categories = Category::all();
        return view('public.blog', compact('posts', 'categories'));
    }

    public function investors()
    {
        return view('public.investors');
    }
}
