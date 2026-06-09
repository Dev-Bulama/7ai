<x-admin-layout title="Edit Banner">
<div class="section-header">
  <span class="section-title">Edit: {{ $banner->name }}</span>
  <a href="{{ route('admin.banners.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card" style="max-width:700px;">
  <form method="POST" action="{{ route('admin.banners.update', $banner) }}">
    @csrf @method('PUT')
    <div class="form-group"><label class="form-label">Internal Name *</label><input type="text" name="name" class="form-input" value="{{ old('name', $banner->name) }}" required></div>
    <div class="form-group"><label class="form-label">Title</label><input type="text" name="title" class="form-input" value="{{ old('title', $banner->title) }}"></div>
    <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-input" rows="2">{{ old('description', $banner->description) }}</textarea></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Image URL</label><input type="text" name="image" class="form-input" value="{{ old('image', $banner->image) }}"></div>
      <div class="form-group"><label class="form-label">Link URL</label><input type="text" name="link" class="form-input" value="{{ old('link', $banner->link) }}"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Button Text</label><input type="text" name="button_text" class="form-input" value="{{ old('button_text', $banner->button_text) }}"></div>
      <div class="form-group"><label class="form-label">Position</label>
        <select name="position" class="form-input">
          @foreach(['home_hero','top_bar','sidebar','contact'] as $pos)
          <option value="{{ $pos }}" {{ old('position', $banner->position) === $pos ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$pos)) }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Start Date</label><input type="date" name="start_date" class="form-input" value="{{ old('start_date', $banner->start_date?->format('Y-m-d')) }}"></div>
      <div class="form-group"><label class="form-label">End Date</label><input type="date" name="end_date" class="form-input" value="{{ old('end_date', $banner->end_date?->format('Y-m-d')) }}"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $banner->sort_order) }}"></div>
      <div class="form-group" style="display:flex;align-items:flex-end;"><label class="form-check"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}> Active</label></div>
    </div>
    <button type="submit" class="btn btn-primary">Update Banner</button>
  </form>
</div>
</x-admin-layout>
