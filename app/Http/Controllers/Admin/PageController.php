<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index() {
        $pages = Page::with('creator')->latest()->paginate(20);
        return view('admin.pages.index', compact('pages'));
    }
    public function create() { return view('admin.pages.create'); }
    public function store(Request $request) {
        $data = $request->validate(['title'=>'required','content'=>'nullable','template'=>'nullable','status'=>'required','meta_title'=>'nullable','meta_description'=>'nullable']);
        $data['slug'] = Str::slug($data['title']);
        $data['created_by'] = auth()->id();
        Page::create($data);
        return redirect()->route('admin.pages.index')->with('success','Page created.');
    }
    public function edit(Page $page) { return view('admin.pages.edit', compact('page')); }
    public function update(Request $request, Page $page) {
        $data = $request->validate(['title'=>'required','content'=>'nullable','template'=>'nullable','status'=>'required','meta_title'=>'nullable','meta_description'=>'nullable']);
        $page->update($data);
        return redirect()->route('admin.pages.index')->with('success','Page updated.');
    }
    public function destroy(Page $page) { $page->delete(); return redirect()->route('admin.pages.index')->with('success','Page deleted.'); }
}
