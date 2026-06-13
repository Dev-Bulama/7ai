<x-admin-layout title="Settings">
@php
  $s = fn($k,$d='') => \App\Models\Setting::get($k,$d);
  $tab = request('tab','general');
@endphp

<div class="section-header">
  <span class="section-title">Site Settings</span>
</div>

{{-- Tab nav --}}
<div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:28px;border-bottom:1px solid var(--gray-200);padding-bottom:0;">
  @foreach([
    'general'  => 'General',
    'brand'    => 'Brand',
    'contact'  => 'Contact',
    'smtp'     => 'Email / SMTP',
    'seo'      => 'SEO',
    'social'   => 'Social Media',
    'scripts'  => 'Scripts',
    'system'   => 'System',
  ] as $key => $label)
  <a href="{{ route('admin.settings.index', ['tab' => $key]) }}"
     style="padding:10px 18px;font-size:13px;font-weight:{{ $tab === $key ? '700' : '400' }};color:{{ $tab === $key ? 'var(--teal)' : 'var(--gray-600)' }};border-bottom:2px solid {{ $tab === $key ? 'var(--teal)' : 'transparent' }};text-decoration:none;white-space:nowrap;">
    {{ $label }}
  </a>
  @endforeach
</div>

<div style="max-width:760px;">

{{-- GENERAL --}}
@if($tab === 'general')
<form method="POST" action="{{ route('admin.settings.update') }}">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="general">
<div class="card">
  <div style="font-weight:700;font-size:14px;margin-bottom:20px;">General Settings</div>
  <div class="form-grid">
    <div class="form-group"><label class="form-label">Site Name</label><input name="site_name" class="form-input" value="{{ $s('site_name','7AI Technologies') }}"></div>
    <div class="form-group"><label class="form-label">Site Tagline</label><input name="site_tagline" class="form-input" value="{{ $s('site_tagline','African Intelligence, Amplified') }}"></div>
  </div>
  <div class="form-grid">
    <div class="form-group"><label class="form-label">Default Timezone</label>
      <select name="default_timezone" class="form-input">
        @foreach(['Africa/Lagos','Africa/Nairobi','Africa/Johannesburg','Africa/Accra','UTC'] as $tz)
        <option value="{{ $tz }}" {{ $s('default_timezone','Africa/Lagos') === $tz ? 'selected' : '' }}>{{ $tz }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group"><label class="form-label">Default Language</label>
      <select name="default_language" class="form-input">
        <option value="en" {{ $s('default_language','en') === 'en' ? 'selected' : '' }}>English</option>
        <option value="fr" {{ $s('default_language','en') === 'fr' ? 'selected' : '' }}>French</option>
        <option value="sw" {{ $s('default_language','en') === 'sw' ? 'selected' : '' }}>Swahili</option>
      </select>
    </div>
  </div>
  <div style="border-top:1px solid var(--gray-200);margin:20px 0;"></div>
  <div style="font-weight:600;font-size:13px;margin-bottom:14px;color:var(--gray-700);">Navigation CTA</div>
  <p style="font-size:13px;color:var(--gray-500);margin-bottom:14px;">Controls the button shown on the top-right of every page.</p>
  <div class="form-grid">
    <div class="form-group"><label class="form-label">Primary Button Text</label><input name="nav_cta_text" class="form-input" value="{{ $s('nav_cta_text','AI CONFERENCE') }}"></div>
    <div class="form-group"><label class="form-label">Primary Button URL</label><input name="nav_cta_url" class="form-input" value="{{ $s('nav_cta_url','/abuja') }}"></div>
  </div>
  <div class="form-grid">
    <div class="form-group"><label class="form-label">Secondary Link Text</label><input name="nav_secondary_text" class="form-input" value="{{ $s('nav_secondary_text','About') }}"></div>
    <div class="form-group"><label class="form-label">Secondary Link URL</label><input name="nav_secondary_url" class="form-input" value="{{ $s('nav_secondary_url','/about') }}"></div>
  </div>
  <button type="submit" class="btn btn-primary">Save General Settings</button>
</div>
</form>

{{-- BRAND --}}
@elseif($tab === 'brand')
<form method="POST" action="{{ route('admin.settings.update') }}">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="brand">
<div class="card">
  <div style="font-weight:700;font-size:14px;margin-bottom:20px;">Brand Settings</div>
  <div class="form-grid">
    <div class="form-group"><label class="form-label">Logo URL</label><input name="logo" class="form-input" value="{{ $s('logo') }}" placeholder="/assets/images/logo-white.svg"></div>
    <div class="form-group"><label class="form-label">Favicon URL</label><input name="favicon" class="form-input" value="{{ $s('favicon') }}" placeholder="/favicon.ico"></div>
  </div>
  <div class="form-group"><label class="form-label">Footer Logo URL <span style="font-weight:300;color:var(--gray-400);">(leave blank to use main logo)</span></label><input name="footer_logo" class="form-input" value="{{ $s('footer_logo') }}"></div>
  <div style="border-top:1px solid var(--gray-200);margin:20px 0;"></div>
  <div class="form-grid">
    <div class="form-group"><label class="form-label">Primary Color</label><input type="text" name="primary_color" class="form-input" value="{{ $s('primary_color','#0B4F6C') }}" placeholder="#0B4F6C"></div>
    <div class="form-group"><label class="form-label">Secondary Color</label><input type="text" name="secondary_color" class="form-input" value="{{ $s('secondary_color','#3EE07F') }}" placeholder="#3EE07F"></div>
  </div>
  <button type="submit" class="btn btn-primary">Save Brand Settings</button>
</div>
</form>

{{-- CONTACT --}}
@elseif($tab === 'contact')
<form method="POST" action="{{ route('admin.settings.update') }}">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="contact">
<div class="card">
  <div style="font-weight:700;font-size:14px;margin-bottom:20px;">Contact Information</div>
  <div class="form-grid">
    <div class="form-group"><label class="form-label">Contact Email</label><input type="email" name="contact_email" class="form-input" value="{{ $s('contact_email','hello@7ai.africa') }}"></div>
    <div class="form-group"><label class="form-label">Support Email</label><input type="email" name="support_email" class="form-input" value="{{ $s('support_email') }}" placeholder="support@7ai.africa"></div>
  </div>
  <div class="form-grid">
    <div class="form-group"><label class="form-label">Phone Number</label><input name="contact_phone" class="form-input" value="{{ $s('contact_phone') }}"></div>
    <div class="form-group"><label class="form-label">WhatsApp Number</label><input name="whatsapp_number" class="form-input" value="{{ $s('whatsapp_number') }}" placeholder="+234..."></div>
  </div>
  <div class="form-group"><label class="form-label">Address</label><input name="address" class="form-input" value="{{ $s('address') }}" placeholder="Lagos, Nigeria"></div>
  <div class="form-group"><label class="form-label">Location / City</label><input name="location" class="form-input" value="{{ $s('location') }}" placeholder="Lagos, Nigeria"></div>
  <button type="submit" class="btn btn-primary">Save Contact Settings</button>
</div>
</form>

{{-- SMTP — two SEPARATE forms, no nesting --}}
@elseif($tab === 'smtp')

{{-- Form 1: Save SMTP settings --}}
<form method="POST" action="{{ route('admin.settings.update') }}">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="smtp">
<div class="card" style="margin-bottom:24px;">
  <div style="font-weight:700;font-size:14px;margin-bottom:6px;">Email / SMTP Configuration</div>
  <p style="font-size:13px;color:var(--gray-500);margin-bottom:20px;">These settings override the server's .env mail config. Leave blank to use .env defaults.</p>
  <div class="form-grid">
    <div class="form-group"><label class="form-label">SMTP Host</label><input name="mail_host" class="form-input" value="{{ $s('mail_host') }}" placeholder="mail.7ai.africa"></div>
    <div class="form-group"><label class="form-label">SMTP Port</label><input name="mail_port" class="form-input" value="{{ $s('mail_port','587') }}" placeholder="587"></div>
  </div>
  <div class="form-grid">
    <div class="form-group"><label class="form-label">SMTP Username</label><input name="mail_username" class="form-input" value="{{ $s('mail_username') }}" placeholder="noreply@7ai.africa"></div>
    <div class="form-group"><label class="form-label">SMTP Password <span style="font-weight:300;color:var(--gray-400);">(blank = keep existing)</span></label><input type="password" name="mail_password" class="form-input" autocomplete="new-password" placeholder="••••••••"></div>
  </div>
  <div class="form-grid">
    <div class="form-group"><label class="form-label">Encryption</label>
      <select name="mail_encryption" class="form-input">
        <option value="tls" {{ $s('mail_encryption','tls') === 'tls' ? 'selected' : '' }}>TLS (port 587)</option>
        <option value="ssl" {{ $s('mail_encryption','tls') === 'ssl' ? 'selected' : '' }}>SSL (port 465)</option>
        <option value=""   {{ $s('mail_encryption','tls') === ''    ? 'selected' : '' }}>None</option>
      </select>
    </div>
    <div class="form-group"><label class="form-label">From Name</label><input name="mail_from_name" class="form-input" value="{{ $s('mail_from_name','7AI') }}" placeholder="7AI"></div>
  </div>
  <div class="form-group"><label class="form-label">From Email Address</label><input type="email" name="mail_from_address" class="form-input" value="{{ $s('mail_from_address','noreply@7ai.africa') }}" placeholder="noreply@7ai.africa"></div>
  <button type="submit" class="btn btn-primary">Save SMTP Settings</button>
</div>
</form>

{{-- Form 2: Send test email — completely separate form --}}
<form method="POST" action="{{ route('admin.settings.test-email') }}">
@csrf
<div class="card">
  <div style="font-weight:700;font-size:14px;margin-bottom:6px;">Send Test Email</div>
  <p style="font-size:13px;color:var(--gray-500);margin-bottom:16px;">Verify your saved SMTP settings are working by sending a test email. <strong>Save your settings first, then test.</strong></p>
  <div style="display:flex;gap:12px;align-items:flex-end;">
    <div class="form-group" style="flex:1;margin-bottom:0;">
      <label class="form-label">Recipient email address</label>
      <input type="email" name="test_email" class="form-input" placeholder="you@example.com" required>
    </div>
    <button type="submit" class="btn btn-primary" style="white-space:nowrap;">Send Test →</button>
    <a href="{{ route('admin.settings.smtp-diagnostics') }}" class="btn btn-outline" style="white-space:nowrap;">SMTP Diagnostics</a>
  </div>
  @if(session('smtp_error'))
  <div style="margin-top:14px;padding:12px 16px;background:#fee2e2;border:1px solid #fca5a5;border-radius:6px;font-size:13px;color:#991b1b;">
    <strong>SMTP Error:</strong> {{ session('smtp_error') }}
  </div>
  <script>console.error("SMTP Test Email Failed:", {{ Js::from(session('smtp_error')) }});</script>
  @endif
</div>
</form>

{{-- SEO --}}
@elseif($tab === 'seo')
<form method="POST" action="{{ route('admin.settings.update') }}">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="seo">
<div class="card">
  <div style="font-weight:700;font-size:14px;margin-bottom:20px;">SEO Settings</div>
  <div class="form-group"><label class="form-label">Default Meta Title</label><input name="meta_title" class="form-input" value="{{ $s('meta_title') }}" placeholder="7AI — African Intelligence, Amplified"></div>
  <div class="form-group"><label class="form-label">Default Meta Description</label><textarea name="meta_description" class="form-input" rows="3">{{ $s('meta_description') }}</textarea></div>
  <div class="form-group"><label class="form-label">Default Keywords</label><input name="meta_keywords" class="form-input" value="{{ $s('meta_keywords') }}" placeholder="AI Africa, smart home, business automation"></div>
  <div class="form-group"><label class="form-label">Open Graph / Social Share Image URL</label><input name="og_image" class="form-input" value="{{ $s('og_image') }}" placeholder="/assets/images/og-image.jpg"></div>
  <button type="submit" class="btn btn-primary">Save SEO Settings</button>
</div>
</form>

{{-- SOCIAL MEDIA --}}
@elseif($tab === 'social')
<form method="POST" action="{{ route('admin.settings.update') }}">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="social">
<div class="card" style="margin-bottom:24px;">
  <div style="font-weight:700;font-size:14px;margin-bottom:20px;">Social Media URLs</div>
  @foreach(['facebook_url'=>'Facebook','instagram_url'=>'Instagram','twitter_url'=>'X / Twitter','linkedin_url'=>'LinkedIn','youtube_url'=>'YouTube','tiktok_url'=>'TikTok'] as $key => $label)
  <div class="form-group"><label class="form-label">{{ $label }}</label><input name="{{ $key }}" type="url" class="form-input" value="{{ $s($key) }}" placeholder="https://..."></div>
  @endforeach
  <button type="submit" class="btn btn-primary">Save Social URLs</button>
</div>
</form>

<div class="card">
  <div style="font-weight:700;font-size:14px;margin-bottom:16px;">Footer Social Link Icons</div>
  @if($socialLinks->isNotEmpty())
  <div class="table-wrap" style="margin-bottom:20px;">
    <table>
      <thead><tr><th>Platform</th><th>URL</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @foreach($socialLinks as $link)
        <tr>
          <td><strong>{{ ucfirst($link->platform) }}</strong></td>
          <td style="font-size:12px;color:var(--gray-500);">{{ Str::limit($link->url, 50) }}</td>
          <td><span class="badge {{ $link->is_active ? 'badge-green' : 'badge-gray' }}">{{ $link->is_active ? 'Active' : 'Off' }}</span></td>
          <td>
            <form method="POST" action="{{ route('admin.settings.social.destroy', $link) }}" style="display:inline;" onsubmit="return confirm('Remove?')">
              @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Remove</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
  <form method="POST" action="{{ route('admin.settings.social.store') }}">
    @csrf
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Platform</label>
        <select name="platform" class="form-input">
          @foreach(['twitter','linkedin','facebook','youtube','instagram','tiktok','github'] as $p)
          <option value="{{ $p }}">{{ ucfirst($p) }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group"><label class="form-label">URL *</label><input type="url" name="url" class="form-input" placeholder="https://twitter.com/7ai" required></div>
    </div>
    <button type="submit" class="btn btn-primary btn-sm">Add Social Link</button>
  </form>
</div>

{{-- SCRIPTS --}}
@elseif($tab === 'scripts')
<form method="POST" action="{{ route('admin.settings.update') }}">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="scripts">
<div class="card">
  <div style="font-weight:700;font-size:14px;margin-bottom:6px;">Script Injection &amp; Integrations</div>
  <p style="font-size:13px;color:var(--gray-500);margin-bottom:20px;">Scripts are injected into every page. Use with care.</p>
  <div class="form-group"><label class="form-label">Google Analytics ID <span style="font-weight:300;color:var(--gray-400);">(e.g. G-XXXXXXXX)</span></label><input name="google_analytics" class="form-input" value="{{ $s('google_analytics') }}" placeholder="G-XXXXXXXXXX"></div>
  <div class="form-group"><label class="form-label">Meta Pixel ID</label><input name="meta_pixel" class="form-input" value="{{ $s('meta_pixel') }}" placeholder="123456789"></div>
  <div class="form-group"><label class="form-label">Header Scripts <span style="font-weight:300;color:var(--gray-400);">(injected in &lt;head&gt;)</span></label><textarea name="header_scripts" class="form-input" rows="6" style="font-family:monospace;font-size:12px;" placeholder="&lt;script&gt;...&lt;/script&gt;">{{ $s('header_scripts') }}</textarea></div>
  <div class="form-group"><label class="form-label">Footer Scripts <span style="font-weight:300;color:var(--gray-400);">(injected before &lt;/body&gt;)</span></label><textarea name="footer_scripts" class="form-input" rows="6" style="font-family:monospace;font-size:12px;" placeholder="&lt;script&gt;...&lt;/script&gt;">{{ $s('footer_scripts') }}</textarea></div>
  <div class="form-group"><label class="form-label">Chatbot / Live Chat Script</label><textarea name="chatbot_script" class="form-input" rows="4" style="font-family:monospace;font-size:12px;" placeholder="Paste your chat widget embed code here">{{ $s('chatbot_script') }}</textarea></div>
  <button type="submit" class="btn btn-primary">Save Script Settings</button>
</div>
</form>

{{-- SYSTEM --}}
@elseif($tab === 'system')
<form method="POST" action="{{ route('admin.settings.update') }}">
@csrf @method('PUT')
<input type="hidden" name="_tab" value="system">
<div class="card">
  <div style="font-weight:700;font-size:14px;margin-bottom:20px;">System Settings</div>
  <div class="form-group"><label class="form-label">Footer Text</label><textarea name="footer_text" class="form-input" rows="2">{{ $s('footer_text') }}</textarea></div>
  <div class="form-group"><label class="form-label">Copyright Text</label><input name="copyright_text" class="form-input" value="{{ $s('copyright_text','© '.date('Y').' 7AI Technologies. All rights reserved.') }}"></div>
  <div style="border-top:1px solid var(--gray-200);margin:20px 0;"></div>
  <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:20px;">
    <label class="form-check">
      <input type="hidden" name="maintenance_mode" value="0">
      <input type="checkbox" name="maintenance_mode" value="1" {{ $s('maintenance_mode') === '1' ? 'checked' : '' }}>
      <span style="font-weight:500;">Maintenance Mode</span>
      <span style="display:block;font-size:12px;color:var(--gray-400);margin-top:2px;">When enabled, visitors see a maintenance page. Admins can still log in.</span>
    </label>
    <label class="form-check">
      <input type="hidden" name="registration_enabled" value="0">
      <input type="checkbox" name="registration_enabled" value="1" {{ $s('registration_enabled','1') !== '0' ? 'checked' : '' }}>
      <span style="font-weight:500;">Allow New User Registration</span>
    </label>
    <label class="form-check">
      <input type="hidden" name="email_notifications" value="0">
      <input type="checkbox" name="email_notifications" value="1" {{ $s('email_notifications','1') !== '0' ? 'checked' : '' }}>
      <span style="font-weight:500;">Send Email Notifications</span>
      <span style="display:block;font-size:12px;color:var(--gray-400);margin-top:2px;">Send welcome emails and admin notifications when users register.</span>
    </label>
  </div>
  <button type="submit" class="btn btn-primary">Save System Settings</button>
</div>
</form>

@endif

</div>
</x-admin-layout>
