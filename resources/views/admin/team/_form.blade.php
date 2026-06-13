@php $m = $team ?? null; @endphp

{{-- Photo --}}
<div class="form-group" style="margin-bottom:24px;">
  <label class="form-label">Photo</label>
  @if($m?->photo_url)
  <div style="margin-bottom:12px;">
    <img src="{{ $m->photo_url }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:2px solid var(--gray-200);">
  </div>
  @endif
  <input type="file" name="photo" class="form-input" accept="image/*">
  <div style="font-size:12px;color:var(--gray-400);margin-top:4px;">JPG, PNG, WebP — max 4MB. Square photos recommended.</div>
</div>

<div class="form-grid">
  <div class="form-group"><label class="form-label">Full Name *</label><input type="text" name="name" class="form-input" required value="{{ old('name', $m?->name) }}" placeholder="Adaeze Obi"></div>
  <div class="form-group"><label class="form-label">Job Title</label><input type="text" name="job_title" class="form-input" value="{{ old('job_title', $m?->job_title) }}" placeholder="Co-Founder & CEO"></div>
</div>
<div class="form-group"><label class="form-label">Short Subtitle / Tagline</label><input type="text" name="subtitle" class="form-input" value="{{ old('subtitle', $m?->subtitle) }}" placeholder="Lagos, Nigeria · AI Strategist"></div>
<div class="form-group"><label class="form-label">Bio <span style="font-weight:300;color:var(--gray-400);">(optional)</span></label><textarea name="bio" class="form-input" rows="5">{{ old('bio', $m?->bio) }}</textarea></div>

<div style="border-top:1px solid var(--gray-200);margin:20px 0;"></div>
<div style="font-weight:600;font-size:13px;margin-bottom:14px;color:var(--gray-700);">Contact (optional — shown only if provided)</div>
<div class="form-grid">
  <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-input" value="{{ old('email', $m?->email) }}"></div>
  <div class="form-group"><label class="form-label">Phone</label><input type="text" name="phone" class="form-input" value="{{ old('phone', $m?->phone) }}" placeholder="+234..."></div>
</div>

<div style="border-top:1px solid var(--gray-200);margin:20px 0;"></div>
<div style="font-weight:600;font-size:13px;margin-bottom:14px;color:var(--gray-700);">Social Links (optional)</div>
<div class="form-grid">
  <div class="form-group"><label class="form-label">LinkedIn</label><input type="url" name="linkedin" class="form-input" value="{{ old('linkedin', $m?->linkedin) }}" placeholder="https://linkedin.com/in/..."></div>
  <div class="form-group"><label class="form-label">X / Twitter</label><input type="url" name="twitter" class="form-input" value="{{ old('twitter', $m?->twitter) }}" placeholder="https://x.com/..."></div>
</div>
<div class="form-grid">
  <div class="form-group"><label class="form-label">Instagram</label><input type="url" name="instagram" class="form-input" value="{{ old('instagram', $m?->instagram) }}" placeholder="https://instagram.com/..."></div>
  <div class="form-group"><label class="form-label">Facebook</label><input type="url" name="facebook" class="form-input" value="{{ old('facebook', $m?->facebook) }}" placeholder="https://facebook.com/..."></div>
</div>
<div class="form-grid">
  <div class="form-group"><label class="form-label">GitHub</label><input type="url" name="github" class="form-input" value="{{ old('github', $m?->github) }}" placeholder="https://github.com/..."></div>
  <div class="form-group"><label class="form-label">Website</label><input type="url" name="website" class="form-input" value="{{ old('website', $m?->website) }}" placeholder="https://..."></div>
</div>

<div style="border-top:1px solid var(--gray-200);margin:20px 0;"></div>
<div class="form-grid">
  <div class="form-group"><label class="form-label">Sort Order <span style="font-weight:300;color:var(--gray-400);">(lower = first)</span></label><input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $m?->sort_order ?? 0) }}"></div>
  <div class="form-group" style="display:flex;align-items:flex-end;gap:20px;padding-bottom:4px;">
    <label class="form-check"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $m?->is_featured) ? 'checked' : '' }}> Featured</label>
    <label class="form-check"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $m?->is_active ?? true) ? 'checked' : '' }}> Active</label>
  </div>
</div>
<div style="margin-bottom:24px;"></div>
