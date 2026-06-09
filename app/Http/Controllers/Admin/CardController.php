<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index() {
        $cards = Card::orderBy('group')->orderBy('sort_order')->paginate(30);
        return view('admin.cards.index', compact('cards'));
    }
    public function create() { return view('admin.cards.create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'nullable|max:255',
            'description' => 'nullable',
            'icon' => 'nullable|max:500',
            'image' => 'nullable|max:500',
            'link' => 'nullable|max:500',
            'button_text' => 'nullable|max:100',
            'group' => 'nullable|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        Card::create($data);
        return redirect()->route('admin.cards.index')->with('success', 'Card created.');
    }
    public function edit(Card $card) { return view('admin.cards.edit', compact('card')); }
    public function update(Request $request, Card $card) {
        $data = $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'nullable|max:255',
            'description' => 'nullable',
            'icon' => 'nullable|max:500',
            'image' => 'nullable|max:500',
            'link' => 'nullable|max:500',
            'button_text' => 'nullable|max:100',
            'group' => 'nullable|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $card->update($data);
        return redirect()->route('admin.cards.index')->with('success', 'Card updated.');
    }
    public function destroy(Card $card) {
        $card->delete();
        return redirect()->route('admin.cards.index')->with('success', 'Card deleted.');
    }
}
