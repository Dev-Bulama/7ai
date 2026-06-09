<x-admin-layout title="Cards">
<div class="section-header">
  <span class="section-title">Feature Cards</span>
  <a href="{{ route('admin.cards.create') }}" class="btn btn-primary btn-sm">+ Add Card</a>
</div>
<div class="card" style="padding:0;">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Title</th><th>Group</th><th>Sort</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($cards as $card)
        <tr>
          <td>
            <div style="font-weight:600;">{{ $card->title }}</div>
            @if($card->subtitle)<div style="font-size:12px;color:var(--gray-400);">{{ $card->subtitle }}</div>@endif
          </td>
          <td>{{ $card->group ?? '—' }}</td>
          <td>{{ $card->sort_order }}</td>
          <td><span class="badge {{ $card->is_active ? 'badge-green' : 'badge-gray' }}">{{ $card->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <a href="{{ route('admin.cards.edit', $card) }}" class="btn btn-outline btn-sm">Edit</a>
            <form method="POST" action="{{ route('admin.cards.destroy', $card) }}" style="display:inline;" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--gray-400);">No cards yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="padding:16px;">{{ $cards->links() }}</div>
</div>
</x-admin-layout>
