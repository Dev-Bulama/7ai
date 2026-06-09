<x-admin-layout title="Edit Service">
<div class="section-header">
  <span class="section-title">Edit: {{ $service->title }}</span>
  <a href="{{ route('admin.services.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card">
  <form method="POST" action="{{ route('admin.services.update', $service) }}">
    @csrf @method('PUT')
    <div class="form-grid">
      <div class="form-group">
        <label class="form-label">Title *</label>
        <input type="text" name="title" class="form-input" value="{{ old('title', $service->title) }}" required>
      </div>
      <div class="form-group">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" class="form-input" value="{{ old('slug', $service->slug) }}">
      </div>
    </div>
    <div class="form-grid">
      <div class="form-group">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-input">
          <option value="">— None —</option>
          @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ old('category_id', $service->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="status" class="form-input">
          <option value="published" {{ old('status', $service->status) === 'published' ? 'selected' : '' }}>Published</option>
          <option value="draft" {{ old('status', $service->status) === 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Short Description</label>
      <textarea name="short_description" class="form-input" rows="2">{{ old('short_description', $service->short_description) }}</textarea>
    </div>
    <div class="form-group">
      <label class="form-label">Full Description</label>
      <textarea name="full_description" class="form-input" rows="6">{{ old('full_description', $service->full_description) }}</textarea>
    </div>
    <div class="form-grid">
      <div class="form-group">
        <label class="form-label">Featured Image URL</label>
        <input type="text" name="featured_image" class="form-input" value="{{ old('featured_image', $service->featured_image) }}">
      </div>
      <div class="form-group">
        <label class="form-label">Icon</label>
        <input type="text" name="icon" class="form-input" value="{{ old('icon', $service->icon) }}">
      </div>
    </div>
    <div class="form-grid">
      <div class="form-group">
        <label class="form-label">Price</label>
        <input type="text" name="price" class="form-input" value="{{ old('price', $service->price) }}">
      </div>
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $service->sort_order) }}">
      </div>
    </div>
    <div class="form-grid">
      <div class="form-group">
        <label class="form-label">CTA Text</label>
        <input type="text" name="cta_text" class="form-input" value="{{ old('cta_text', $service->cta_text) }}">
      </div>
      <div class="form-group">
        <label class="form-label">CTA Link</label>
        <input type="text" name="cta_link" class="form-input" value="{{ old('cta_link', $service->cta_link) }}">
      </div>
    </div>
    <div class="form-grid">
      <div class="form-group">
        <label class="form-label">SEO Title</label>
        <input type="text" name="meta_title" class="form-input" value="{{ old('meta_title', $service->meta_title) }}">
      </div>
      <div class="form-group">
        <label class="form-label">SEO Description</label>
        <input type="text" name="meta_description" class="form-input" value="{{ old('meta_description', $service->meta_description) }}">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Update Service</button>
  </form>
</div>
</x-admin-layout>
