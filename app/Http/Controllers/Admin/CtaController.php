<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Cta;
use Illuminate\Http\Request;

class CtaController extends Controller
{
    public function index() {
        $ctas = Cta::orderByDesc('created_at')->paginate(20);
        return view('admin.ctas.index', compact('ctas'));
    }
    public function create() { return view('admin.ctas.create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|max:255',
            'title' => 'nullable|max:255',
            'text' => 'nullable',
            'button_label' => 'nullable|max:100',
            'button_url' => 'nullable|max:500',
            'button2_label' => 'nullable|max:100',
            'button2_url' => 'nullable|max:500',
            'background_image' => 'nullable|max:500',
            'background_color' => 'nullable|max:50',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        Cta::create($data);
        return redirect()->route('admin.ctas.index')->with('success', 'CTA created.');
    }
    public function edit(Cta $cta) { return view('admin.ctas.edit', compact('cta')); }
    public function update(Request $request, Cta $cta) {
        $data = $request->validate([
            'name' => 'required|max:255',
            'title' => 'nullable|max:255',
            'text' => 'nullable',
            'button_label' => 'nullable|max:100',
            'button_url' => 'nullable|max:500',
            'button2_label' => 'nullable|max:100',
            'button2_url' => 'nullable|max:500',
            'background_image' => 'nullable|max:500',
            'background_color' => 'nullable|max:50',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $cta->update($data);
        return redirect()->route('admin.ctas.index')->with('success', 'CTA updated.');
    }
    public function destroy(Cta $cta) {
        $cta->delete();
        return redirect()->route('admin.ctas.index')->with('success', 'CTA deleted.');
    }
}
