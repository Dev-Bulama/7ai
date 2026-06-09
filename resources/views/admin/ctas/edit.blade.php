<x-admin-layout title="Edit CTA">
<div class="section-header">
  <span class="section-title">Edit: {{ $cta->name }}</span>
  <a href="{{ route('admin.ctas.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card" style="max-width:700px;">
  <form method="POST" action="{{ route('admin.ctas.update', $cta) }}">
    @csrf @method('PUT')
    <div class="form-group"><label class="form-label">Internal Name *</label><input type="text" name="name" class="form-input" value="{{ old('name', $cta->name) }}" required></div>
    <div class="form-group"><label class="form-label">Title</label><input type="text" name="title" class="form-input" value="{{ old('title', $cta->title) }}"></div>
    <div class="form-group"><label class="form-label">Text</label><textarea name="text" class="form-input" rows="3">{{ old('text', $cta->text) }}</textarea></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Primary Button Label</label><input type="text" name="button_label" class="form-input" value="{{ old('button_label', $cta->button_label) }}"></div>
      <div class="form-group"><label class="form-label">Primary Button URL</label><input type="text" name="button_url" class="form-input" value="{{ old('button_url', $cta->button_url) }}"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Secondary Button Label</label><input type="text" name="button2_label" class="form-input" value="{{ old('button2_label', $cta->button2_label) }}"></div>
      <div class="form-group"><label class="form-label">Secondary Button URL</label><input type="text" name="button2_url" class="form-input" value="{{ old('button2_url', $cta->button2_url) }}"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Background Color</label><input type="text" name="background_color" class="form-input" value="{{ old('background_color', $cta->background_color) }}"></div>
      <div class="form-group"><label class="form-label">Background Image URL</label><input type="text" name="background_image" class="form-input" value="{{ old('background_image', $cta->background_image) }}"></div>
    </div>
    <div style="margin-bottom:16px;"><label class="form-check"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $cta->is_active) ? 'checked' : '' }}> Active</label></div>
    <button type="submit" class="btn btn-primary">Update CTA</button>
  </form>
</div>
</x-admin-layout>
