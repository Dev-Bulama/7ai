<x-admin-layout title="Settings">
<div style="max-width:700px;">
<form method="POST" action="{{ route('admin.settings.update') }}">@csrf @method('PUT')
  <div class="card" style="margin-bottom:20px;">
    <div class="section-title" style="margin-bottom:20px;">General Settings</div>
    <div class="form-group"><label class="form-label">Site Name</label><input name="settings[site_name]" class="form-input" value="{{ \App\Models\Setting::get('site_name','7AI Technologies') }}"></div>
    <div class="form-group"><label class="form-label">Site Tagline</label><input name="settings[site_tagline]" class="form-input" value="{{ \App\Models\Setting::get('site_tagline','African Intelligence, Amplified') }}"></div>
    <div class="form-group"><label class="form-label">Contact Email</label><input name="settings[contact_email]" type="email" class="form-input" value="{{ \App\Models\Setting::get('contact_email','hello@7ai.africa') }}"></div>
    <div class="form-group"><label class="form-label">Phone</label><input name="settings[contact_phone]" class="form-input" value="{{ \App\Models\Setting::get('contact_phone') }}"></div>
  </div>
  <div class="card" style="margin-bottom:20px;">
    <div class="section-title" style="margin-bottom:20px;">SEO Settings</div>
    <div class="form-group"><label class="form-label">Default Meta Title</label><input name="settings[meta_title]" class="form-input" value="{{ \App\Models\Setting::get('meta_title') }}"></div>
    <div class="form-group"><label class="form-label">Default Meta Description</label><textarea name="settings[meta_description]" class="form-input" style="min-height:80px;">{{ \App\Models\Setting::get('meta_description') }}</textarea></div>
  </div>
  <div class="card" style="margin-bottom:20px;">
    <div class="section-title" style="margin-bottom:20px;">Email Settings</div>
    <div class="form-group"><label class="form-label">Default From Name</label><input name="settings[mail_from_name]" class="form-input" value="{{ \App\Models\Setting::get('mail_from_name','7AI') }}"></div>
    <div class="form-group"><label class="form-label">Default From Email</label><input name="settings[mail_from_email]" type="email" class="form-input" value="{{ \App\Models\Setting::get('mail_from_email','hello@7ai.africa') }}"></div>
  </div>
  <div class="card" style="margin-bottom:20px;">
    <div class="section-title" style="margin-bottom:20px;">Navigation CTA</div>
    <p style="font-size:13px;color:#6b7280;margin-bottom:16px;">Controls the button shown on the top-right of every page's navigation bar.</p>
    <div class="form-group"><label class="form-label">Primary Button Text</label><input name="settings[nav_cta_text]" class="form-input" placeholder="Book Consultation" value="{{ \App\Models\Setting::get('nav_cta_text','Book Consultation') }}"></div>
    <div class="form-group"><label class="form-label">Primary Button URL</label><input name="settings[nav_cta_url]" class="form-input" placeholder="/contact" value="{{ \App\Models\Setting::get('nav_cta_url','/contact') }}"></div>
    <div class="form-group"><label class="form-label">Secondary Button Text</label><input name="settings[nav_secondary_text]" class="form-input" placeholder="Support" value="{{ \App\Models\Setting::get('nav_secondary_text','Support') }}"></div>
    <div class="form-group"><label class="form-label">Secondary Button URL</label><input name="settings[nav_secondary_url]" class="form-input" placeholder="/support" value="{{ \App\Models\Setting::get('nav_secondary_url','/support') }}"></div>
  </div>
  <button type="submit" class="btn btn-primary btn-lg">Save Settings</button>
</form>
</div>
</x-admin-layout>
