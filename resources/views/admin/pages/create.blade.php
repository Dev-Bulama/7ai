<x-admin-layout title="Create Page">
<div class="section-header">
  <span class="section-title">Create Page</span>
  <a href="{{ route('admin.pages.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card">
  <form method="POST" action="{{ route('admin.pages.store') }}">
    @csrf
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Page Title *</label><input type="text" name="title" class="form-input" value="{{ old('title') }}" required></div>
      <div class="form-group"><label class="form-label">Slug (auto)</label><input type="text" name="slug" class="form-input" value="{{ old('slug') }}" placeholder="my-page"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Parent Page</label>
        <select name="parent_id" class="form-input"><option value="">— None —</option>
          @foreach($parents as $p)<option value="{{ $p->id }}" {{ old('parent_id') == $p->id ? 'selected' : '' }}>{{ $p->title }}</option>@endforeach
        </select>
      </div>
      <div class="form-group"><label class="form-label">Template</label>
        <select name="template" class="form-input">
          <option value="default">Default</option>
          <option value="home">Home</option>
          <option value="landing">Landing</option>
          <option value="service">Service</option>
          <option value="contact">Contact</option>
          <option value="blank">Blank</option>
        </select>
      </div>
    </div>
    <div class="form-group"><label class="form-label">Featured Image URL</label><input type="text" name="featured_image" class="form-input" value="{{ old('featured_image') }}"></div>

    <div style="border-top:1px solid var(--gray-200);margin:20px 0;padding-top:16px;font-weight:700;font-size:13px;color:var(--dark);">Hero Section</div>
    <div class="form-group"><label class="form-label">Hero Title</label><input type="text" name="hero_title" class="form-input" value="{{ old('hero_title') }}"></div>
    <div class="form-group"><label class="form-label">Hero Subtitle</label><input type="text" name="hero_subtitle" class="form-input" value="{{ old('hero_subtitle') }}"></div>
    <div class="form-group"><label class="form-label">Hero Description</label><textarea name="hero_description" class="form-input" rows="3">{{ old('hero_description') }}</textarea></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">CTA Button Text</label><input type="text" name="cta_text" class="form-input" value="{{ old('cta_text') }}"></div>
      <div class="form-group"><label class="form-label">CTA Button Link</label><input type="text" name="cta_link" class="form-input" value="{{ old('cta_link') }}"></div>
    </div>

    <div style="border-top:1px solid var(--gray-200);margin:20px 0;padding-top:16px;font-weight:700;font-size:13px;color:var(--dark);">Page Content</div>
    <div class="form-group"><label class="form-label">Content (HTML/Markdown)</label><textarea name="content" class="form-input" rows="8">{{ old('content') }}</textarea></div>

    <div style="border-top:1px solid var(--gray-200);margin:20px 0;padding-top:16px;font-weight:700;font-size:13px;color:var(--dark);">SEO</div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">SEO Title</label><input type="text" name="meta_title" class="form-input" value="{{ old('meta_title') }}"></div>
      <div class="form-group"><label class="form-label">SEO Keywords</label><input type="text" name="seo_keywords" class="form-input" value="{{ old('seo_keywords') }}"></div>
    </div>
    <div class="form-group"><label class="form-label">SEO Description</label><textarea name="meta_description" class="form-input" rows="2">{{ old('meta_description') }}</textarea></div>
    <div class="form-group"><label class="form-label">OG Image URL</label><input type="text" name="og_image" class="form-input" value="{{ old('og_image') }}"></div>

    <div style="border-top:1px solid var(--gray-200);margin:20px 0;padding-top:16px;"></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Status *</label>
        <select name="status" class="form-input">
          <option value="draft" {{ old('status','draft') === 'draft' ? 'selected' : '' }}>Draft</option>
          <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
        </select>
      </div>
      <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', 0) }}"></div>
    </div>
    <button type="submit" class="btn btn-primary">Create Page</button>
  </form>
</div>
</x-admin-layout>
