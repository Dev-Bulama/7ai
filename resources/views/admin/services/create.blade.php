<x-admin-layout title="Add Service">
<div class="section-header">
  <span class="section-title">Add Service</span>
  <a href="{{ route('admin.services.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card">
  <form method="POST" action="{{ route('admin.services.store') }}">
    @csrf
    <div class="form-grid">
      <div class="form-group">
        <label class="form-label">Title *</label>
        <input type="text" name="title" class="form-input" value="{{ old('title') }}" required>
      </div>
      <div class="form-group">
        <label class="form-label">Slug (auto-generated if empty)</label>
        <input type="text" name="slug" class="form-input" value="{{ old('slug') }}" placeholder="my-service">
      </div>
    </div>
    <div class="form-grid">
      <div class="form-group">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-input">
          <option value="">— None —</option>
          @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="status" class="form-input">
          <option value="published" {{ old('status','published') === 'published' ? 'selected' : '' }}>Published</option>
          <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Short Description</label>
      <textarea name="short_description" class="form-input" rows="2">{{ old('short_description') }}</textarea>
    </div>
    <div class="form-group">
      <label class="form-label">Full Description</label>
      <textarea name="full_description" class="form-input" rows="6">{{ old('full_description') }}</textarea>
    </div>
    <div class="form-grid">
      <div class="form-group">
        <label class="form-label">Featured Image URL</label>
        <input type="text" name="featured_image" class="form-input" value="{{ old('featured_image') }}" placeholder="/storage/...">
      </div>
      <div class="form-group">
        <label class="form-label">Icon (SVG or class)</label>
        <input type="text" name="icon" class="form-input" value="{{ old('icon') }}">
      </div>
    </div>
    <div class="form-grid">
      <div class="form-group">
        <label class="form-label">Price (optional)</label>
        <input type="text" name="price" class="form-input" value="{{ old('price') }}" placeholder="From $999">
      </div>
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', 0) }}">
      </div>
    </div>
    <div class="form-grid">
      <div class="form-group">
        <label class="form-label">CTA Button Text</label>
        <input type="text" name="cta_text" class="form-input" value="{{ old('cta_text') }}" placeholder="Get Started">
      </div>
      <div class="form-group">
        <label class="form-label">CTA Button Link</label>
        <input type="text" name="cta_link" class="form-input" value="{{ old('cta_link') }}" placeholder="/contact">
      </div>
    </div>
    <div class="form-grid">
      <div class="form-group">
        <label class="form-label">SEO Title</label>
        <input type="text" name="meta_title" class="form-input" value="{{ old('meta_title') }}">
      </div>
      <div class="form-group">
        <label class="form-label">SEO Description</label>
        <input type="text" name="meta_description" class="form-input" value="{{ old('meta_description') }}">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Create Service</button>
  </form>
</div>
</x-admin-layout>
