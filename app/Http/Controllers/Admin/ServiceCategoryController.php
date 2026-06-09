<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    public function index() {
        $categories = ServiceCategory::with('parent')->orderBy('sort_order')->orderBy('name')->get();
        return view('admin.service-categories.index', compact('categories'));
    }
    public function create() {
        $parents = ServiceCategory::whereNull('parent_id')->orderBy('name')->get();
        return view('admin.service-categories.create', compact('parents'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|unique:service_categories,slug',
            'description' => 'nullable',
            'icon' => 'nullable|max:255',
            'parent_id' => 'nullable|exists:service_categories,id',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        if (empty($data['slug'])) $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);
        ServiceCategory::create($data);
        return redirect()->route('admin.service-categories.index')->with('success', 'Category created.');
    }
    public function edit(ServiceCategory $serviceCategory) {
        $parents = ServiceCategory::whereNull('parent_id')->where('id', '!=', $serviceCategory->id)->orderBy('name')->get();
        return view('admin.service-categories.edit', compact('serviceCategory', 'parents'));
    }
    public function update(Request $request, ServiceCategory $serviceCategory) {
        $data = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|unique:service_categories,slug,' . $serviceCategory->id,
            'description' => 'nullable',
            'icon' => 'nullable|max:255',
            'parent_id' => 'nullable|exists:service_categories,id',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        if (empty($data['slug'])) $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);
        $serviceCategory->update($data);
        return redirect()->route('admin.service-categories.index')->with('success', 'Category updated.');
    }
    public function destroy(ServiceCategory $serviceCategory) {
        $serviceCategory->delete();
        return redirect()->route('admin.service-categories.index')->with('success', 'Category deleted.');
    }
}
