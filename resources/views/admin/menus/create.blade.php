<x-admin-layout title="Create Menu">
<div class="section-header">
  <span class="section-title">Create Menu</span>
  <a href="{{ route('admin.menus.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card" style="max-width:500px;">
  <form method="POST" action="{{ route('admin.menus.store') }}">
    @csrf
    <div class="form-group"><label class="form-label">Menu Name *</label><input type="text" name="name" class="form-input" value="{{ old('name') }}" required placeholder="Main Navigation"></div>
    <div class="form-group"><label class="form-label">Location *</label><input type="text" name="location" class="form-input" value="{{ old('location') }}" required placeholder="header">
      <div style="font-size:12px;color:var(--gray-500);margin-top:4px;">Use: header, footer, mobile (must be unique)</div>
    </div>
    <button type="submit" class="btn btn-primary">Create Menu →</button>
  </form>
</div>
</x-admin-layout>
