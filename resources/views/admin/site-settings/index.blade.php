<x-admin-layout title="Site Settings">
<div class="section-header">
  <span class="section-title">Site Settings</span>
</div>

<div class="card" style="margin-bottom:24px;">
  <div style="font-weight:700;font-size:14px;margin-bottom:20px;">General Settings</div>
  <form method="POST" action="{{ route('admin.site-settings.update') }}">
    @csrf @method('PUT')
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Site Name</label><input type="text" name="site_name" class="form-input" value="{{ old('site_name', $settings['site_name']->value ?? '7AI') }}"></div>
      <div class="form-group"><label class="form-label">Site Tagline</label><input type="text" name="site_tagline" class="form-input" value="{{ old('site_tagline', $settings['site_tagline']->value ?? '') }}"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Logo URL</label><input type="text" name="logo" class="form-input" value="{{ old('logo', $settings['logo']->value ?? '') }}" placeholder="/assets/images/logo-white.svg"></div>
      <div class="form-group"><label class="form-label">Favicon URL</label><input type="text" name="favicon" class="form-input" value="{{ old('favicon', $settings['favicon']->value ?? '') }}" placeholder="/favicon.ico"></div>
    </div>
    <div style="border-top:1px solid var(--gray-200);margin:20px 0;"></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Contact Phone</label><input type="text" name="contact_phone" class="form-input" value="{{ old('contact_phone', $settings['contact_phone']->value ?? '') }}"></div>
      <div class="form-group"><label class="form-label">WhatsApp Number</label><input type="text" name="whatsapp_number" class="form-input" value="{{ old('whatsapp_number', $settings['whatsapp_number']->value ?? '') }}"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Contact Email</label><input type="email" name="contact_email" class="form-input" value="{{ old('contact_email', $settings['contact_email']->value ?? '') }}"></div>
      <div class="form-group"><label class="form-label">Address</label><input type="text" name="address" class="form-input" value="{{ old('address', $settings['address']->value ?? '') }}"></div>
    </div>
    <div style="border-top:1px solid var(--gray-200);margin:20px 0;"></div>
    <div class="form-group"><label class="form-label">Footer Text</label><textarea name="footer_text" class="form-input" rows="2">{{ old('footer_text', $settings['footer_text']->value ?? '') }}</textarea></div>
    <div class="form-group"><label class="form-label">Copyright Text</label><input type="text" name="copyright_text" class="form-input" value="{{ old('copyright_text', $settings['copyright_text']->value ?? '© 2025 7AI Technologies. All rights reserved.') }}"></div>
    <div style="border-top:1px solid var(--gray-200);margin:20px 0;"></div>
    <div class="form-group"><label class="form-label">Default SEO Title</label><input type="text" name="default_seo_title" class="form-input" value="{{ old('default_seo_title', $settings['default_seo_title']->value ?? '') }}"></div>
    <div class="form-group"><label class="form-label">Default SEO Description</label><textarea name="default_seo_description" class="form-input" rows="2">{{ old('default_seo_description', $settings['default_seo_description']->value ?? '') }}</textarea></div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Primary Color</label><input type="text" name="primary_color" class="form-input" value="{{ old('primary_color', $settings['primary_color']->value ?? '#0B4F6C') }}" placeholder="#0B4F6C"></div>
      <div class="form-group"><label class="form-label">Secondary Color</label><input type="text" name="secondary_color" class="form-input" value="{{ old('secondary_color', $settings['secondary_color']->value ?? '#3EE07F') }}" placeholder="#3EE07F"></div>
    </div>
    <button type="submit" class="btn btn-primary">Save Settings</button>
  </form>
</div>

<div class="card">
  <div style="font-weight:700;font-size:14px;margin-bottom:16px;">Social Links</div>
  @if($socialLinks->isNotEmpty())
  <div class="table-wrap" style="margin-bottom:20px;">
    <table>
      <thead><tr><th>Platform</th><th>URL</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @foreach($socialLinks as $link)
        <tr>
          <td><strong>{{ ucfirst($link->platform) }}</strong></td>
          <td style="font-size:12px;">{{ $link->url }}</td>
          <td><span class="badge {{ $link->is_active ? 'badge-green' : 'badge-gray' }}">{{ $link->is_active ? 'Active' : 'Off' }}</span></td>
          <td>
            <form method="POST" action="{{ route('admin.site-settings.social.destroy', $link) }}" style="display:inline;" onsubmit="return confirm('Remove?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Remove</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
  <form method="POST" action="{{ route('admin.site-settings.social.store') }}">
    @csrf
    <div style="font-weight:600;font-size:13px;margin-bottom:12px;color:var(--gray-700);">Add Social Link</div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Platform *</label>
        <select name="platform" class="form-input">
          @foreach(['twitter','linkedin','facebook','youtube','instagram','tiktok','github'] as $p)
          <option value="{{ $p }}">{{ ucfirst($p) }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group"><label class="form-label">URL *</label><input type="url" name="url" class="form-input" placeholder="https://twitter.com/7ai"></div>
    </div>
    <button type="submit" class="btn btn-primary btn-sm">Add Social Link</button>
  </form>
</div>
</x-admin-layout>
