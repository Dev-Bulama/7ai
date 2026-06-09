<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index() {
        $menus = Menu::withCount('allItems')->get();
        return view('admin.menus.index', compact('menus'));
    }
    public function create() { return view('admin.menus.create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|max:255',
            'location' => 'required|max:100|unique:menus,location',
        ]);
        $menu = Menu::create($data);
        return redirect()->route('admin.menus.edit', $menu)->with('success', 'Menu created. Now add items.');
    }
    public function edit(Menu $menu) {
        $menu->load(['items.children']);
        $pages = Page::where('status', 'published')->orderBy('title')->get();
        return view('admin.menus.edit', compact('menu', 'pages'));
    }
    public function update(Request $request, Menu $menu) {
        $data = $request->validate(['name' => 'required|max:255']);
        $menu->update($data);
        return redirect()->route('admin.menus.edit', $menu)->with('success', 'Menu updated.');
    }
    public function destroy(Menu $menu) {
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted.');
    }

    public function storeItem(Request $request, Menu $menu) {
        $data = $request->validate([
            'label' => 'required|max:255',
            'type' => 'required|in:page,custom',
            'url' => 'nullable|max:500',
            'page_id' => 'nullable|exists:pages,id',
            'parent_id' => 'nullable|exists:menu_items,id',
            'target' => 'nullable|in:_self,_blank',
            'icon' => 'nullable|max:100',
            'order' => 'nullable|integer',
        ]);
        $data['menu_id'] = $menu->id;
        $data['is_active'] = true;
        $data['target'] = $data['target'] ?? '_self';
        MenuItem::create($data);
        return redirect()->route('admin.menus.edit', $menu)->with('success', 'Menu item added.');
    }
    public function updateItem(Request $request, Menu $menu, MenuItem $item) {
        $data = $request->validate([
            'label' => 'required|max:255',
            'type' => 'required|in:page,custom',
            'url' => 'nullable|max:500',
            'page_id' => 'nullable|exists:pages,id',
            'parent_id' => 'nullable|exists:menu_items,id',
            'target' => 'nullable|in:_self,_blank',
            'icon' => 'nullable|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $item->update($data);
        return redirect()->route('admin.menus.edit', $menu)->with('success', 'Item updated.');
    }
    public function destroyItem(Menu $menu, MenuItem $item) {
        $item->delete();
        return redirect()->route('admin.menus.edit', $menu)->with('success', 'Item deleted.');
    }
}
