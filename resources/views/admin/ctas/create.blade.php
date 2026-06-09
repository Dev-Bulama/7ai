<x-admin-layout title="Add CTA">
<div class="section-header">
  <span class="section-title">Add CTA Block</span>
  <a href="{{ route('admin.ctas.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card" style="max-width:700px;">
  <form method="POST" action="{{ route('admin.ctas.store') }}">
    @csrf
    <div class="form-group"><label class="form-label">Internal Name *</label><input type="text" name="name" class="form-input" value="{{ old('name') }}" required placeholder="Home Hero CTA"></div>
    <div class="form-group"><label class="form-label">Title</label><input type="text" name="title" class="form-input" value="{{ old('title') }}"></div>
    <div class="form-group"><label class="form-label">Text / Description</label><textarea name="text" class="form-input" rows="3">{{ old('text') }}</textarea></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Primary Button Label</label><input type="text" name="button_label" class="form-input" value="{{ old('button_label') }}" placeholder="Get Started"></div>
      <div class="form-group"><label class="form-label">Primary Button URL</label><input type="text" name="button_url" class="form-input" value="{{ old('button_url') }}" placeholder="/contact"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Secondary Button Label</label><input type="text" name="button2_label" class="form-input" value="{{ old('button2_label') }}"></div>
      <div class="form-group"><label class="form-label">Secondary Button URL</label><input type="text" name="button2_url" class="form-input" value="{{ old('button2_url') }}"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Background Color</label><input type="text" name="background_color" class="form-input" value="{{ old('background_color') }}" placeholder="#0B4F6C"></div>
      <div class="form-group"><label class="form-label">Background Image URL</label><input type="text" name="background_image" class="form-input" value="{{ old('background_image') }}"></div>
    </div>
    <div style="margin-bottom:16px;"><label class="form-check"><input type="checkbox" name="is_active" value="1" checked> Active</label></div>
    <button type="submit" class="btn btn-primary">Create CTA</button>
  </form>
</div>
</x-admin-layout>
