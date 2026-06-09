<x-admin-layout title="Add Card">
<div class="section-header">
  <span class="section-title">Add Feature Card</span>
  <a href="{{ route('admin.cards.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card" style="max-width:700px;">
  <form method="POST" action="{{ route('admin.cards.store') }}">
    @csrf
    <div class="form-group"><label class="form-label">Title *</label><input type="text" name="title" class="form-input" value="{{ old('title') }}" required></div>
    <div class="form-group"><label class="form-label">Subtitle</label><input type="text" name="subtitle" class="form-input" value="{{ old('subtitle') }}"></div>
    <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-input" rows="3">{{ old('description') }}</textarea></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Icon (SVG or text)</label><input type="text" name="icon" class="form-input" value="{{ old('icon') }}"></div>
      <div class="form-group"><label class="form-label">Image URL</label><input type="text" name="image" class="form-input" value="{{ old('image') }}"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Link URL</label><input type="text" name="link" class="form-input" value="{{ old('link') }}"></div>
      <div class="form-group"><label class="form-label">Button Text</label><input type="text" name="button_text" class="form-input" value="{{ old('button_text') }}"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Group (e.g. smart-home, ai)</label><input type="text" name="group" class="form-input" value="{{ old('group') }}"></div>
      <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', 0) }}"></div>
    </div>
    <div style="margin-bottom:16px;"><label class="form-check"><input type="checkbox" name="is_active" value="1" checked> Active</label></div>
    <button type="submit" class="btn btn-primary">Create Card</button>
  </form>
</div>
</x-admin-layout>
