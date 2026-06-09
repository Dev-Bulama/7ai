<x-admin-layout title="Edit Category">
<div class="section-header">
  <span class="section-title">Edit: {{ $serviceCategory->name }}</span>
  <a href="{{ route('admin.service-categories.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card" style="max-width:600px;">
  <form method="POST" action="{{ route('admin.service-categories.update', $serviceCategory) }}">
    @csrf @method('PUT')
    <div class="form-group"><label class="form-label">Name *</label><input type="text" name="name" class="form-input" value="{{ old('name', $serviceCategory->name) }}" required></div>
    <div class="form-group"><label class="form-label">Slug</label><input type="text" name="slug" class="form-input" value="{{ old('slug', $serviceCategory->slug) }}"></div>
    <div class="form-group"><label class="form-label">Parent Category</label>
      <select name="parent_id" class="form-input"><option value="">— None —</option>
        @foreach($parents as $p)<option value="{{ $p->id }}" {{ old('parent_id', $serviceCategory->parent_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>@endforeach
      </select></div>
    <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-input" rows="3">{{ old('description', $serviceCategory->description) }}</textarea></div>
    <div class="form-group"><label class="form-label">Icon</label><input type="text" name="icon" class="form-input" value="{{ old('icon', $serviceCategory->icon) }}"></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $serviceCategory->sort_order) }}"></div>
      <div class="form-group" style="display:flex;align-items:flex-end;"><label class="form-check"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $serviceCategory->is_active) ? 'checked' : '' }}> Active</label></div>
    </div>
    <button type="submit" class="btn btn-primary">Update Category</button>
  </form>
</div>
</x-admin-layout>
