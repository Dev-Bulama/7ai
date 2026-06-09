<x-admin-layout title="Edit Menu">
<div class="section-header">
  <span class="section-title">{{ $menu->name }} <span style="font-size:13px;font-weight:400;color:var(--gray-500);">({{ $menu->location }})</span></span>
  <a href="{{ route('admin.menus.index') }}" class="btn btn-outline btn-sm">← All Menus</a>
</div>

{{-- Current items --}}
<div class="card" style="margin-bottom:24px;">
  <div style="font-weight:700;font-size:14px;color:var(--dark);margin-bottom:16px;">Menu Items ({{ $menu->allItems->count() }})</div>
  @if($menu->items->isNotEmpty())
  <div class="table-wrap">
    <table>
      <thead><tr><th>Label</th><th>Type</th><th>URL / Page</th><th>Parent</th><th>Target</th><th>Sort</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @foreach($menu->items as $item)
        <tr>
          <td style="font-weight:600;">{{ $item->label }}</td>
          <td><span class="badge badge-teal">{{ $item->type }}</span></td>
          <td style="font-size:12px;color:var(--gray-500);">{{ $item->type === 'page' ? ($item->page?->title ?? 'Unknown') : ($item->url ?? '—') }}</td>
          <td>—</td>
          <td>{{ $item->target }}</td>
          <td>{{ $item->order }}</td>
          <td><span class="badge {{ $item->is_active ? 'badge-green' : 'badge-gray' }}">{{ $item->is_active ? 'On' : 'Off' }}</span></td>
          <td>
            @foreach($item->children as $child)
            @endforeach
            <form method="POST" action="{{ route('admin.menus.items.destroy', [$menu, $item]) }}" style="display:inline;" onsubmit="return confirm('Remove item?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Remove</button>
            </form>
          </td>
        </tr>
        @foreach($item->children as $child)
        <tr style="background:var(--gray-50);">
          <td style="padding-left:32px;">↳ {{ $child->label }}</td>
          <td><span class="badge badge-gray">{{ $child->type }}</span></td>
          <td style="font-size:12px;color:var(--gray-500);">{{ $child->type === 'page' ? ($child->page?->title ?? '—') : ($child->url ?? '—') }}</td>
          <td style="font-size:12px;">{{ $item->label }}</td>
          <td>{{ $child->target }}</td>
          <td>{{ $child->order }}</td>
          <td><span class="badge {{ $child->is_active ? 'badge-green' : 'badge-gray' }}">{{ $child->is_active ? 'On' : 'Off' }}</span></td>
          <td>
            <form method="POST" action="{{ route('admin.menus.items.destroy', [$menu, $child]) }}" style="display:inline;" onsubmit="return confirm('Remove?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Remove</button>
            </form>
          </td>
        </tr>
        @endforeach
        @endforeach
      </tbody>
    </table>
  </div>
  @else
  <p style="color:var(--gray-400);font-size:13px;">No items yet. Add some below.</p>
  @endif
</div>

{{-- Add item --}}
<div class="card">
  <div style="font-weight:700;font-size:14px;color:var(--dark);margin-bottom:16px;">Add Menu Item</div>
  <form method="POST" action="{{ route('admin.menus.items.store', $menu) }}">
    @csrf
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Label *</label><input type="text" name="label" class="form-input" required placeholder="Solutions"></div>
      <div class="form-group"><label class="form-label">Type</label>
        <select name="type" class="form-input" id="item-type">
          <option value="custom">Custom URL</option>
          <option value="page">Page</option>
        </select>
      </div>
    </div>
    <div class="form-group" id="url-group"><label class="form-label">URL</label><input type="text" name="url" class="form-input" placeholder="/solutions"></div>
    <div class="form-group" id="page-group" style="display:none;"><label class="form-label">Select Page</label>
      <select name="page_id" class="form-input">
        <option value="">— Choose page —</option>
        @foreach($pages as $p)<option value="{{ $p->id }}">{{ $p->title }}</option>@endforeach
      </select>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Parent Item (for dropdown)</label>
        <select name="parent_id" class="form-input">
          <option value="">— None (top level) —</option>
          @foreach($menu->items as $i)<option value="{{ $i->id }}">{{ $i->label }}</option>@endforeach
        </select>
      </div>
      <div class="form-group"><label class="form-label">Target</label>
        <select name="target" class="form-input">
          <option value="_self">Same Tab</option>
          <option value="_blank">New Tab</option>
        </select>
      </div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="order" class="form-input" value="{{ $menu->allItems->count() * 10 }}"></div>
      <div class="form-group"><label class="form-label">Icon (optional)</label><input type="text" name="icon" class="form-input" placeholder="star"></div>
    </div>
    <button type="submit" class="btn btn-primary">Add Item</button>
  </form>
</div>

<script>
document.getElementById('item-type').addEventListener('change', function(){
  document.getElementById('url-group').style.display = this.value === 'custom' ? 'block' : 'none';
  document.getElementById('page-group').style.display = this.value === 'page' ? 'block' : 'none';
});
</script>
</x-admin-layout>
