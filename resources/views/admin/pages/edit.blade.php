<x-admin-layout title="Edit Page">
<div class="section-header">
  <span class="section-title">Edit: {{ $page->title }}</span>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline btn-sm">← Back</a>
    <form method="POST" action="{{ route('admin.pages.toggle-status', $page) }}" style="display:inline;">
      @csrf
      <button class="btn {{ $page->status === 'published' ? 'btn-outline' : 'btn-success' }} btn-sm">
        {{ $page->status === 'published' ? 'Unpublish' : 'Publish' }}
      </button>
    </form>
  </div>
</div>
<div class="card">
  <form method="POST" action="{{ route('admin.pages.update', $page) }}">
    @csrf @method('PUT')
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Page Title *</label><input type="text" name="title" class="form-input" value="{{ old('title', $page->title) }}" required></div>
      <div class="form-group"><label class="form-label">Slug</label><input type="text" name="slug" class="form-input" value="{{ old('slug', $page->slug) }}"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Parent Page</label>
        <select name="parent_id" class="form-input"><option value="">— None —</option>
          @foreach($parents as $p)<option value="{{ $p->id }}" {{ old('parent_id', $page->parent_id) == $p->id ? 'selected' : '' }}>{{ $p->title }}</option>@endforeach
        </select>
      </div>
      <div class="form-group"><label class="form-label">Template</label>
        <select name="template" class="form-input">
          @foreach(['default','home','landing','service','contact','blank'] as $t)
          <option value="{{ $t }}" {{ old('template', $page->template) === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group"><label class="form-label">Featured Image URL</label><input type="text" name="featured_image" class="form-input" value="{{ old('featured_image', $page->featured_image) }}"></div>

    <div style="border-top:1px solid var(--gray-200);margin:20px 0;padding-top:16px;font-weight:700;font-size:13px;color:var(--dark);">Hero Section</div>
    <div class="form-group"><label class="form-label">Hero Title</label><input type="text" name="hero_title" class="form-input" value="{{ old('hero_title', $page->hero_title) }}"></div>
    <div class="form-group"><label class="form-label">Hero Subtitle</label><input type="text" name="hero_subtitle" class="form-input" value="{{ old('hero_subtitle', $page->hero_subtitle) }}"></div>
    <div class="form-group"><label class="form-label">Hero Description</label><textarea name="hero_description" class="form-input" rows="3">{{ old('hero_description', $page->hero_description) }}</textarea></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">CTA Text</label><input type="text" name="cta_text" class="form-input" value="{{ old('cta_text', $page->cta_text) }}"></div>
      <div class="form-group"><label class="form-label">CTA Link</label><input type="text" name="cta_link" class="form-input" value="{{ old('cta_link', $page->cta_link) }}"></div>
    </div>

    <div style="border-top:1px solid var(--gray-200);margin:20px 0;padding-top:16px;font-weight:700;font-size:13px;color:var(--dark);">Page Content</div>
    <div class="form-group"><label class="form-label">Content</label><textarea name="content" class="form-input" rows="10">{{ old('content', $page->content) }}</textarea></div>

    <div style="border-top:1px solid var(--gray-200);margin:20px 0;padding-top:16px;font-weight:700;font-size:13px;color:var(--dark);">SEO</div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">SEO Title</label><input type="text" name="meta_title" class="form-input" value="{{ old('meta_title', $page->meta_title) }}"></div>
      <div class="form-group"><label class="form-label">SEO Keywords</label><input type="text" name="seo_keywords" class="form-input" value="{{ old('seo_keywords', $page->seo_keywords) }}"></div>
    </div>
    <div class="form-group"><label class="form-label">SEO Description</label><textarea name="meta_description" class="form-input" rows="2">{{ old('meta_description', $page->meta_description) }}</textarea></div>
    <div class="form-group"><label class="form-label">OG Image URL</label><input type="text" name="og_image" class="form-input" value="{{ old('og_image', $page->og_image) }}"></div>

    <div style="border-top:1px solid var(--gray-200);margin:20px 0;padding-top:16px;"></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Status *</label>
        <select name="status" class="form-input">
          <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Draft</option>
          <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>Published</option>
        </select>
      </div>
      <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $page->sort_order) }}"></div>
    </div>
    <button type="submit" class="btn btn-primary">Update Page</button>
  </form>
</div>
</x-admin-layout>
