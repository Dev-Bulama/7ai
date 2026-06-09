<x-admin-layout title="FAQs">
<div class="section-header">
  <span class="section-title">FAQs</span>
  <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary btn-sm">+ Add FAQ</a>
</div>
<div class="card" style="padding:0;">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Question</th><th>Category</th><th>Sort</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($faqs as $faq)
        <tr>
          <td style="max-width:400px;">{{ Str::limit($faq->question, 80) }}</td>
          <td>{{ $faq->category ?? '—' }}</td>
          <td>{{ $faq->sort_order }}</td>
          <td><span class="badge {{ $faq->is_active ? 'badge-green' : 'badge-gray' }}">{{ $faq->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-outline btn-sm">Edit</a>
            <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" style="display:inline;" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--gray-400);">No FAQs yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="padding:16px;">{{ $faqs->links() }}</div>
</div>
</x-admin-layout>
