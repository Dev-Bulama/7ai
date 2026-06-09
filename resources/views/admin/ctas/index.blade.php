<x-admin-layout title="CTAs">
<div class="section-header">
  <span class="section-title">CTA Blocks</span>
  <a href="{{ route('admin.ctas.create') }}" class="btn btn-primary btn-sm">+ Add CTA</a>
</div>
<div class="card" style="padding:0;">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Name</th><th>Title</th><th>Button</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($ctas as $cta)
        <tr>
          <td><strong>{{ $cta->name }}</strong></td>
          <td>{{ $cta->title ?? '—' }}</td>
          <td>{{ $cta->button_label ?? '—' }}</td>
          <td><span class="badge {{ $cta->is_active ? 'badge-green' : 'badge-gray' }}">{{ $cta->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <a href="{{ route('admin.ctas.edit', $cta) }}" class="btn btn-outline btn-sm">Edit</a>
            <form method="POST" action="{{ route('admin.ctas.destroy', $cta) }}" style="display:inline;" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--gray-400);">No CTAs yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="padding:16px;">{{ $ctas->links() }}</div>
</div>
</x-admin-layout>
