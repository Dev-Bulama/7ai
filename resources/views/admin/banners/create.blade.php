<x-admin-layout title="Add Banner">
<div class="section-header">
  <span class="section-title">Add Banner</span>
  <a href="{{ route('admin.banners.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card" style="max-width:700px;">
  <form method="POST" action="{{ route('admin.banners.store') }}">
    @csrf
    <div class="form-group"><label class="form-label">Internal Name *</label><input type="text" name="name" class="form-input" value="{{ old('name') }}" required placeholder="Summer Promo Banner"></div>
    <div class="form-group"><label class="form-label">Title</label><input type="text" name="title" class="form-input" value="{{ old('title') }}"></div>
    <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-input" rows="2">{{ old('description') }}</textarea></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Image URL</label><input type="text" name="image" class="form-input" value="{{ old('image') }}"></div>
      <div class="form-group"><label class="form-label">Link URL</label><input type="text" name="link" class="form-input" value="{{ old('link') }}"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Button Text</label><input type="text" name="button_text" class="form-input" value="{{ old('button_text') }}"></div>
      <div class="form-group"><label class="form-label">Position</label>
        <select name="position" class="form-input">
          <option value="home_hero">Home Hero</option>
          <option value="top_bar">Top Bar</option>
          <option value="sidebar">Sidebar</option>
          <option value="contact">Contact Page</option>
        </select>
      </div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Start Date</label><input type="date" name="start_date" class="form-input" value="{{ old('start_date') }}"></div>
      <div class="form-group"><label class="form-label">End Date</label><input type="date" name="end_date" class="form-input" value="{{ old('end_date') }}"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', 0) }}"></div>
      <div class="form-group" style="display:flex;align-items:flex-end;"><label class="form-check"><input type="checkbox" name="is_active" value="1" checked> Active</label></div>
    </div>
    <button type="submit" class="btn btn-primary">Create Banner</button>
  </form>
</div>
</x-admin-layout>
