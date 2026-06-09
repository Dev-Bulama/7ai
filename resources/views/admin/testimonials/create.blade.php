<x-admin-layout title="Add Testimonial">
<div class="section-header">
  <span class="section-title">Add Testimonial</span>
  <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card" style="max-width:700px;">
  <form method="POST" action="{{ route('admin.testimonials.store') }}">
    @csrf
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Author Name *</label><input type="text" name="author_name" class="form-input" value="{{ old('author_name') }}" required></div>
      <div class="form-group"><label class="form-label">Author Role / Title</label><input type="text" name="author_role" class="form-input" value="{{ old('author_role') }}" placeholder="CEO, Director..."></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Company</label><input type="text" name="author_company" class="form-input" value="{{ old('author_company') }}"></div>
      <div class="form-group"><label class="form-label">Avatar URL</label><input type="text" name="author_avatar" class="form-input" value="{{ old('author_avatar') }}" placeholder="/storage/..."></div>
    </div>
    <div class="form-group"><label class="form-label">Testimonial Content *</label><textarea name="content" class="form-input" rows="4" required>{{ old('content') }}</textarea></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Rating (1-5)</label><input type="number" name="rating" class="form-input" value="{{ old('rating', 5) }}" min="1" max="5"></div>
      <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', 0) }}"></div>
    </div>
    <div style="display:flex;gap:24px;margin-bottom:16px;">
      <label class="form-check"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}> Featured</label>
      <label class="form-check"><input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}> Active</label>
    </div>
    <button type="submit" class="btn btn-primary">Create Testimonial</button>
  </form>
</div>
</x-admin-layout>
