<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SitePopup;
use Illuminate\Http\Request;

class PopupController extends Controller
{
    public function index()
    {
        $popups = SitePopup::orderByDesc('created_at')->get();
        return view('admin.popups.index', compact('popups'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'link_url'   => 'nullable|string|max:255',
            'link_text'  => 'nullable|string|max:100',
            'show_times' => 'required|integer|min:1|max:99',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'image'      => 'nullable|image|max:3072',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('popups', 'public');
        }
        unset($data['image']);
        $data['is_active'] = false;

        SitePopup::create($data);
        return back()->with('success', 'Popup created.');
    }

    public function update(Request $request, SitePopup $popup)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'link_url'   => 'nullable|string|max:255',
            'link_text'  => 'nullable|string|max:100',
            'show_times' => 'required|integer|min:1|max:99',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date',
            'image'      => 'nullable|image|max:3072',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('popups', 'public');
        }
        unset($data['image']);

        $popup->update($data);
        return back()->with('success', 'Popup updated.');
    }

    public function destroy(SitePopup $popup)
    {
        if ($popup->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($popup->image_path);
        }
        $popup->delete();
        return back()->with('success', 'Popup deleted.');
    }

    public function toggle(SitePopup $popup)
    {
        $popup->update(['is_active' => !$popup->is_active]);
        return back()->with('success', $popup->is_active ? 'Popup activated.' : 'Popup deactivated.');
    }
}
