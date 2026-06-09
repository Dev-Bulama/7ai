<x-admin-layout title="Add FAQ">
<div class="section-header">
  <span class="section-title">Add FAQ</span>
  <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline btn-sm">← Back</a>
</div>
<div class="card" style="max-width:700px;">
  <form method="POST" action="{{ route('admin.faqs.store') }}">
    @csrf
    <div class="form-group"><label class="form-label">Question *</label><input type="text" name="question" class="form-input" value="{{ old('question') }}" required></div>
    <div class="form-group"><label class="form-label">Answer *</label><textarea name="answer" class="form-input" rows="5" required>{{ old('answer') }}</textarea></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Category (optional)</label><input type="text" name="category" class="form-input" value="{{ old('category') }}" placeholder="General, Billing, Technical..."></div>
      <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', 0) }}"></div>
    </div>
    <div style="margin-bottom:16px;"><label class="form-check"><input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}> Active</label></div>
    <button type="submit" class="btn btn-primary">Create FAQ</button>
  </form>
</div>
</x-admin-layout>
