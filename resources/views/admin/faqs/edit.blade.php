<x-admin-layout title="Edit FAQ">
<div class="section-header">
  <span class="section-title">Edit FAQ</span>
  <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card" style="max-width:700px;">
  <form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
    @csrf @method('PUT')
    <div class="form-group"><label class="form-label">Question *</label><input type="text" name="question" class="form-input" value="{{ old('question', $faq->question) }}" required></div>
    <div class="form-group"><label class="form-label">Answer *</label><textarea name="answer" class="form-input" rows="5" required>{{ old('answer', $faq->answer) }}</textarea></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Category</label><input type="text" name="category" class="form-input" value="{{ old('category', $faq->category) }}"></div>
      <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $faq->sort_order) }}"></div>
    </div>
    <div style="margin-bottom:16px;"><label class="form-check"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}> Active</label></div>
    <button type="submit" class="btn btn-primary">Update FAQ</button>
  </form>
</div>
</x-admin-layout>
