<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index() {
        $pages = Page::with('creator', 'parent')->orderBy('sort_order')->orderBy('title')->paginate(20);
        return view('admin.pages.index', compact('pages'));
    }
    public function create() {
        $parents = Page::whereNull('parent_id')->orderBy('title')->get();
        return view('admin.pages.create', compact('parents'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|unique:pages,slug',
            'parent_id' => 'nullable|exists:pages,id',
            'page_type' => 'nullable|max:50',
            'template' => 'nullable|max:50',
            'featured_image' => 'nullable|max:500',
            'hero_title' => 'nullable|max:255',
            'hero_subtitle' => 'nullable|max:255',
            'hero_description' => 'nullable',
            'cta_text' => 'nullable|max:100',
            'cta_link' => 'nullable|max:500',
            'content' => 'nullable',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
            'seo_keywords' => 'nullable|max:255',
            'og_image' => 'nullable|max:500',
            'status' => 'required|in:draft,published,scheduled',
            'sort_order' => 'nullable|integer',
        ]);
        if (empty($data['slug'])) $data['slug'] = Str::slug($data['title']);
        $data['created_by'] = auth()->id();
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        Page::create($data);
        return redirect()->route('admin.pages.index')->with('success', 'Page created.');
    }
    public function show(Page $page) {
        return redirect()->route('admin.pages.edit', $page);
    }
    public function edit(Page $page) {
        $parents = Page::whereNull('parent_id')->where('id', '!=', $page->id)->orderBy('title')->get();
        return view('admin.pages.edit', compact('page', 'parents'));
    }
    public function update(Request $request, Page $page) {
        $data = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|unique:pages,slug,' . $page->id,
            'parent_id' => 'nullable|exists:pages,id',
            'page_type' => 'nullable|max:50',
            'template' => 'nullable|max:50',
            'featured_image' => 'nullable|max:500',
            'hero_title' => 'nullable|max:255',
            'hero_subtitle' => 'nullable|max:255',
            'hero_description' => 'nullable',
            'cta_text' => 'nullable|max:100',
            'cta_link' => 'nullable|max:500',
            'content' => 'nullable',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
            'seo_keywords' => 'nullable|max:255',
            'og_image' => 'nullable|max:500',
            'status' => 'required|in:draft,published,scheduled',
            'sort_order' => 'nullable|integer',
        ]);
        if (empty($data['slug'])) $data['slug'] = Str::slug($data['title']);
        if ($data['status'] === 'published' && !$page->published_at) {
            $data['published_at'] = now();
        }
        $page->update($data);
        return redirect()->route('admin.pages.index')->with('success', 'Page updated.');
    }
    public function destroy(Page $page) {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted.');
    }

    public function toggleStatus(Page $page) {
        $page->update(['status' => $page->status === 'published' ? 'draft' : 'published']);
        return back()->with('success', 'Status updated.');
    }
}
