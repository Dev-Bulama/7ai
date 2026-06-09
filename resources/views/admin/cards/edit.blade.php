<x-admin-layout title="Edit Card">
<div class="section-header">
  <span class="section-title">Edit: {{ $card->title }}</span>
  <a href="{{ route('admin.cards.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card" style="max-width:700px;">
  <form method="POST" action="{{ route('admin.cards.update', $card) }}">
    @csrf @method('PUT')
    <div class="form-group"><label class="form-label">Title *</label><input type="text" name="title" class="form-input" value="{{ old('title', $card->title) }}" required></div>
    <div class="form-group"><label class="form-label">Subtitle</label><input type="text" name="subtitle" class="form-input" value="{{ old('subtitle', $card->subtitle) }}"></div>
    <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-input" rows="3">{{ old('description', $card->description) }}</textarea></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Icon</label><input type="text" name="icon" class="form-input" value="{{ old('icon', $card->icon) }}"></div>
      <div class="form-group"><label class="form-label">Image URL</label><input type="text" name="image" class="form-input" value="{{ old('image', $card->image) }}"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Link URL</label><input type="text" name="link" class="form-input" value="{{ old('link', $card->link) }}"></div>
      <div class="form-group"><label class="form-label">Button Text</label><input type="text" name="button_text" class="form-input" value="{{ old('button_text', $card->button_text) }}"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Group</label><input type="text" name="group" class="form-input" value="{{ old('group', $card->group) }}"></div>
      <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $card->sort_order) }}"></div>
    </div>
    <div style="margin-bottom:16px;"><label class="form-check"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $card->is_active) ? 'checked' : '' }}> Active</label></div>
    <button type="submit" class="btn btn-primary">Update Card</button>
  </form>
</div>
</x-admin-layout>
