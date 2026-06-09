<x-admin-layout title="Add Category">
<div class="section-header">
  <span class="section-title">Add Service Category</span>
  <a href="{{ route('admin.service-categories.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card" style="max-width:600px;">
  <form method="POST" action="{{ route('admin.service-categories.store') }}">
    @csrf
    <div class="form-group"><label class="form-label">Name *</label><input type="text" name="name" class="form-input" value="{{ old('name') }}" required></div>
    <div class="form-group"><label class="form-label">Slug (auto-generated)</label><input type="text" name="slug" class="form-input" value="{{ old('slug') }}"></div>
    <div class="form-group"><label class="form-label">Parent Category</label>
      <select name="parent_id" class="form-input"><option value="">— None (top-level) —</option>
        @foreach($parents as $p)<option value="{{ $p->id }}" {{ old('parent_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>@endforeach
      </select></div>
    <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-input" rows="3">{{ old('description') }}</textarea></div>
    <div class="form-group"><label class="form-label">Icon</label><input type="text" name="icon" class="form-input" value="{{ old('icon') }}" placeholder="icon-name or SVG"></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', 0) }}"></div>
      <div class="form-group" style="display:flex;align-items:flex-end;"><label class="form-check"><input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}> Active</label></div>
    </div>
    <button type="submit" class="btn btn-primary">Create Category</button>
  </form>
</div>
</x-admin-layout>
