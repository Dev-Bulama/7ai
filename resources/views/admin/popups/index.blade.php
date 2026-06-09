<x-admin-layout title="Popup Flyers">
<div class="section-header">
  <span class="section-title">Popup Flyers</span>
</div>

@if(session('success'))
<div class="alert alert-success" style="margin-bottom:16px;">{{ session('success') }}</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1.3fr;gap:32px;align-items:start;">

  {{-- CREATE FORM --}}
  <div class="card" style="padding:28px;">
    <h3 style="font-size:16px;font-weight:700;color:var(--dark);margin-bottom:20px;">Upload New Flyer</h3>
    <form method="POST" action="{{ route('admin.popups.store') }}" enctype="multipart/form-data">
      @csrf
      <div style="display:flex;flex-direction:column;gap:14px;">
        <div>
          <label class="form-label">Name / Label</label>
          <input type="text" name="name" class="form-input" placeholder="e.g. Abuja Event Flyer" required>
        </div>
        <div>
          <label class="form-label">Flyer Image <span style="color:var(--gray-400);font-weight:400;">(JPG/PNG, max 3MB)</span></label>
          <input type="file" name="image" accept="image/*" class="form-input" style="padding:8px;">
        </div>
        <div>
          <label class="form-label">Link URL <span style="color:var(--gray-400);font-weight:400;">(optional)</span></label>
          <input type="text" name="link_url" class="form-input" placeholder="/abuja">
        </div>
        <div>
          <label class="form-label">Button Text</label>
          <input type="text" name="link_text" class="form-input" value="Register Now">
        </div>
        <div>
          <label class="form-label">Show <span style="font-weight:700;">X</span> times per visitor</label>
          <input type="number" name="show_times" class="form-input" value="2" min="1" max="99" required>
          <p style="font-size:12px;color:var(--gray-400);margin-top:4px;">Tracks via browser localStorage. 0 = unlimited.</p>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <div>
            <label class="form-label">Start Date <span style="color:var(--gray-400);font-weight:400;">(optional)</span></label>
            <input type="date" name="start_date" class="form-input">
          </div>
          <div>
            <label class="form-label">End Date <span style="color:var(--gray-400);font-weight:400;">(optional)</span></label>
            <input type="date" name="end_date" class="form-input">
          </div>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;margin-top:8px;">Upload Flyer</button>
      </div>
    </form>
  </div>

  {{-- POPUPS LIST --}}
  <div>
    @forelse($popups as $popup)
    <div class="card" style="padding:20px;margin-bottom:16px;border-left:3px solid {{ $popup->is_active ? 'var(--green)' : 'var(--gray-200)' }};">
      <div style="display:flex;gap:16px;align-items:flex-start;">
        @if($popup->image_path)
        <img src="{{ asset('storage/'.$popup->image_path) }}" alt="{{ $popup->name }}" style="width:80px;height:80px;object-fit:cover;border-radius:8px;flex-shrink:0;">
        @else
        <div style="width:80px;height:80px;background:var(--gray-100);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--gray-400);">
          <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        </div>
        @endif
        <div style="flex:1;min-width:0;">
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
            <span style="font-weight:700;color:var(--dark);">{{ $popup->name }}</span>
            <span class="badge {{ $popup->is_active ? 'badge-green' : 'badge-gray' }}">{{ $popup->is_active ? 'Active' : 'Inactive' }}</span>
          </div>
          <div style="font-size:13px;color:var(--gray-500);display:flex;flex-direction:column;gap:3px;">
            <span>Shows: <strong>{{ $popup->show_times }}x</strong> per visitor</span>
            @if($popup->link_url)<span>Link: <a href="{{ $popup->link_url }}" style="color:var(--teal);">{{ $popup->link_url }}</a></span>@endif
            @if($popup->start_date || $popup->end_date)<span>Period: {{ $popup->start_date?->format('M j') ?? '∞' }} → {{ $popup->end_date?->format('M j, Y') ?? '∞' }}</span>@endif
          </div>
        </div>
      </div>

      {{-- EDIT FORM --}}
      <details style="margin-top:16px;">
        <summary style="cursor:pointer;font-size:13px;color:var(--teal);font-weight:600;list-style:none;">Edit Settings ▾</summary>
        <form method="POST" action="{{ route('admin.popups.update', $popup) }}" enctype="multipart/form-data" style="margin-top:16px;display:flex;flex-direction:column;gap:12px;">
          @csrf @method('PUT')
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div>
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-input" value="{{ $popup->name }}" required>
            </div>
            <div>
              <label class="form-label">Show times</label>
              <input type="number" name="show_times" class="form-input" value="{{ $popup->show_times }}" min="1" max="99" required>
            </div>
            <div>
              <label class="form-label">Link URL</label>
              <input type="text" name="link_url" class="form-input" value="{{ $popup->link_url }}">
            </div>
            <div>
              <label class="form-label">Button Text</label>
              <input type="text" name="link_text" class="form-input" value="{{ $popup->link_text }}">
            </div>
            <div>
              <label class="form-label">Start Date</label>
              <input type="date" name="start_date" class="form-input" value="{{ $popup->start_date?->format('Y-m-d') }}">
            </div>
            <div>
              <label class="form-label">End Date</label>
              <input type="date" name="end_date" class="form-input" value="{{ $popup->end_date?->format('Y-m-d') }}">
            </div>
          </div>
          <div>
            <label class="form-label">Replace Image</label>
            <input type="file" name="image" accept="image/*" class="form-input" style="padding:8px;">
          </div>
          <button type="submit" class="btn btn-outline btn-sm">Save Changes</button>
        </form>
      </details>

      <div style="display:flex;gap:10px;margin-top:12px;padding-top:12px;border-top:1px solid var(--gray-100);">
        <form method="POST" action="{{ route('admin.popups.toggle', $popup) }}" style="display:inline;">
          @csrf
          <button class="btn btn-sm {{ $popup->is_active ? 'btn-outline' : 'btn-success' }}">
            {{ $popup->is_active ? 'Deactivate' : 'Activate' }}
          </button>
        </form>
        <form method="POST" action="{{ route('admin.popups.destroy', $popup) }}" style="display:inline;" onsubmit="return confirm('Delete this popup?')">
          @csrf @method('DELETE')
          <button class="btn btn-danger btn-sm">Delete</button>
        </form>
      </div>
    </div>
    @empty
    <div class="card" style="padding:40px;text-align:center;color:var(--gray-400);">
      No popup flyers yet. Upload one using the form on the left.
    </div>
    @endforelse
  </div>
</div>

<div class="card" style="padding:20px;margin-top:8px;background:var(--gray-50);">
  <p style="font-size:13px;color:var(--gray-500);margin:0;"><strong>How it works:</strong> When a visitor lands on the site, the active popup flyer shows as a full-screen overlay. The <code>show_times</code> setting limits how many times it appears per browser (tracked via localStorage). Activating a new popup automatically replaces the previous one.</p>
</div>

</x-admin-layout>
