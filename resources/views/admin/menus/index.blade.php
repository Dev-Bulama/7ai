<x-admin-layout title="Menus">
<div class="section-header">
  <span class="section-title">Navigation Menus</span>
  <a href="{{ route('admin.menus.create') }}" class="btn btn-primary btn-sm">+ Create Menu</a>
</div>
<div class="card" style="padding:0;">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Name</th><th>Location</th><th>Items</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($menus as $menu)
        <tr>
          <td><strong>{{ $menu->name }}</strong></td>
          <td><span class="badge badge-teal">{{ $menu->location }}</span></td>
          <td>{{ $menu->all_items_count }}</td>
          <td>
            <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-primary btn-sm">Edit Menu</a>
            <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}" style="display:inline;" onsubmit="return confirm('Delete menu and all its items?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align:center;padding:32px;color:var(--gray-400);">No menus yet. Create one to start building navigation.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
<div style="margin-top:16px;padding:16px;background:var(--gray-100);border-radius:8px;font-size:13px;color:var(--gray-600);">
  <strong>Locations:</strong> Use <code>header</code> for main navigation, <code>footer</code> for footer links, <code>mobile</code> for mobile drawer.
</div>
</x-admin-layout>
