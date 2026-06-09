<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index() {
        $banners = Banner::orderBy('sort_order')->orderByDesc('created_at')->paginate(20);
        return view('admin.banners.index', compact('banners'));
    }
    public function create() { return view('admin.banners.create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|max:255',
            'title' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'nullable|max:500',
            'link' => 'nullable|max:500',
            'button_text' => 'nullable|max:100',
            'position' => 'nullable|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        Banner::create($data);
        return redirect()->route('admin.banners.index')->with('success', 'Banner created.');
    }
    public function edit(Banner $banner) { return view('admin.banners.edit', compact('banner')); }
    public function update(Request $request, Banner $banner) {
        $data = $request->validate([
            'name' => 'required|max:255',
            'title' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'nullable|max:500',
            'link' => 'nullable|max:500',
            'button_text' => 'nullable|max:100',
            'position' => 'nullable|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $banner->update($data);
        return redirect()->route('admin.banners.index')->with('success', 'Banner updated.');
    }
    public function destroy(Banner $banner) {
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted.');
    }
}
