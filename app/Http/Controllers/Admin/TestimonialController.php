<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index() {
        $testimonials = Testimonial::orderBy('sort_order')->orderByDesc('created_at')->paginate(20);
        return view('admin.testimonials.index', compact('testimonials'));
    }
    public function create() { return view('admin.testimonials.create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'author_name' => 'required|max:255',
            'author_role' => 'nullable|max:255',
            'author_company' => 'nullable|max:255',
            'author_avatar' => 'nullable|max:255',
            'content' => 'required',
            'rating' => 'nullable|integer|min:1|max:5',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active', true);
        Testimonial::create($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created.');
    }
    public function edit(Testimonial $testimonial) {
        return view('admin.testimonials.edit', compact('testimonial'));
    }
    public function update(Request $request, Testimonial $testimonial) {
        $data = $request->validate([
            'author_name' => 'required|max:255',
            'author_role' => 'nullable|max:255',
            'author_company' => 'nullable|max:255',
            'author_avatar' => 'nullable|max:255',
            'content' => 'required',
            'rating' => 'nullable|integer|min:1|max:5',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active', true);
        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated.');
    }
    public function destroy(Testimonial $testimonial) {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted.');
    }
}
