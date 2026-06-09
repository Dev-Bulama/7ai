<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index() {
        $services = Service::with('category')->orderBy('sort_order')->orderBy('title')->paginate(20);
        return view('admin.services.index', compact('services'));
    }
    public function create() {
        $categories = ServiceCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.services.create', compact('categories'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|unique:services,slug',
            'short_description' => 'nullable',
            'full_description' => 'nullable',
            'category_id' => 'nullable|exists:service_categories,id',
            'featured_image' => 'nullable|max:255',
            'icon' => 'nullable|max:255',
            'price' => 'nullable|max:100',
            'cta_text' => 'nullable|max:255',
            'cta_link' => 'nullable|max:255',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
            'status' => 'required|in:draft,published',
            'sort_order' => 'nullable|integer',
        ]);
        if (empty($data['slug'])) $data['slug'] = Str::slug($data['title']);
        Service::create($data);
        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }
    public function edit(Service $service) {
        $categories = ServiceCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.services.edit', compact('service', 'categories'));
    }
    public function update(Request $request, Service $service) {
        $data = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|unique:services,slug,' . $service->id,
            'short_description' => 'nullable',
            'full_description' => 'nullable',
            'category_id' => 'nullable|exists:service_categories,id',
            'featured_image' => 'nullable|max:255',
            'icon' => 'nullable|max:255',
            'price' => 'nullable|max:100',
            'cta_text' => 'nullable|max:255',
            'cta_link' => 'nullable|max:255',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
            'status' => 'required|in:draft,published',
            'sort_order' => 'nullable|integer',
        ]);
        if (empty($data['slug'])) $data['slug'] = Str::slug($data['title']);
        $service->update($data);
        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }
    public function destroy(Service $service) {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }
}
