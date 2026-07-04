<x-admin-layout :title="'Conference Settings — '.$form->name">
<div style="padding:32px;max-width:700px;">

  <div style="margin-bottom:24px;">
    <div style="font-size:12px;color:#718096;margin-bottom:4px;">
      <a href="{{ route('admin.conference.index') }}" style="color:#3182ce;text-decoration:none;">Conference</a> /
      <a href="{{ route('admin.conference.participants', $form) }}" style="color:#3182ce;text-decoration:none;">{{ $form->name }}</a> /
    </div>
    <h1 style="font-size:20px;font-weight:700;color:#1a202c;margin:0;">Conference Settings</h1>
  </div>

  @if(session('success'))
  <div style="background:#f0fff4;border:1px solid #9ae6b4;color:#276749;padding:12px 16px;border-radius:6px;margin-bottom:20px;font-size:14px;">
    {{ session('success') }}
  </div>
  @endif

  <form method="POST" action="{{ route('admin.conference.update-settings', $form) }}" enctype="multipart/form-data"
    style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:32px;">
    @csrf @method('PUT')

    <div style="display:grid;gap:20px;">

      <div>
        <label style="display:block;font-size:12px;font-weight:600;color:#4a5568;margin-bottom:6px;">Event Name</label>
        <input name="event_name" value="{{ old('event_name', $settings->event_name) }}" required
          style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:4px;font-size:14px;">
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        <div>
          <label style="display:block;font-size:12px;font-weight:600;color:#4a5568;margin-bottom:6px;">Event Date</label>
          <input name="event_date" type="date" value="{{ old('event_date', $settings->event_date?->format('Y-m-d')) }}"
            style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:4px;font-size:14px;">
        </div>
        <div>
          <label style="display:block;font-size:12px;font-weight:600;color:#4a5568;margin-bottom:6px;">Participant ID Prefix</label>
          <input name="participant_id_prefix" value="{{ old('participant_id_prefix', $settings->participant_id_prefix) }}" maxlength="10"
            placeholder="e.g. CONF, AI25" required
            style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:4px;font-size:14px;">
        </div>
      </div>

      <div>
        <label style="display:block;font-size:12px;font-weight:600;color:#4a5568;margin-bottom:6px;">Event Venue</label>
        <input name="event_venue" value="{{ old('event_venue', $settings->event_venue) }}"
          style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:4px;font-size:14px;">
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        <div>
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:14px;color:#4a5568;">
            <input type="hidden" name="lunch_enabled" value="0">
            <input type="checkbox" name="lunch_enabled" value="1" @checked($settings->lunch_enabled)
              style="width:16px;height:16px;">
            Enable Lunch Tracking
          </label>
        </div>
        <div>
          <label style="display:block;font-size:12px;font-weight:600;color:#4a5568;margin-bottom:6px;">Lunch Rounds</label>
          <input name="lunch_rounds" type="number" min="1" max="5" value="{{ old('lunch_rounds', $settings->lunch_rounds) }}"
            style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:4px;font-size:14px;">
        </div>
      </div>

      <div style="border-top:1px solid #e2e8f0;padding-top:20px;">
        <h3 style="font-size:14px;font-weight:600;color:#4a5568;margin:0 0 16px;">Badge Appearance</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
          <div>
            <label style="display:block;font-size:12px;font-weight:600;color:#4a5568;margin-bottom:6px;">Background Color</label>
            <input name="badge_bg_color" type="color" value="{{ old('badge_bg_color', $settings->badge_bg_color ?? '#0a1628') }}"
              style="width:100%;height:40px;padding:2px;border:1px solid #e2e8f0;border-radius:4px;cursor:pointer;">
          </div>
          <div>
            <label style="display:block;font-size:12px;font-weight:600;color:#4a5568;margin-bottom:6px;">Accent Color</label>
            <input name="badge_accent_color" type="color" value="{{ old('badge_accent_color', $settings->badge_accent_color ?? '#3ee07f') }}"
              style="width:100%;height:40px;padding:2px;border:1px solid #e2e8f0;border-radius:4px;cursor:pointer;">
          </div>
        </div>
        <div style="margin-top:16px;">
          <label style="display:block;font-size:12px;font-weight:600;color:#4a5568;margin-bottom:6px;">Badge Logo (optional)</label>
          @if($settings->badge_logo_path)
          <div style="margin-bottom:8px;">
            <img src="{{ asset('storage/'.$settings->badge_logo_path) }}" style="height:40px;border-radius:4px;">
          </div>
          @endif
          <input name="badge_logo" type="file" accept="image/*"
            style="font-size:14px;color:#4a5568;">
        </div>
      </div>

      @if($settings->qr_generated_at)
      <div style="background:#f0fff4;border:1px solid #9ae6b4;border-radius:4px;padding:12px 16px;font-size:13px;color:#276749;">
        ✓ QR codes last generated: {{ $settings->qr_generated_at->format('d M Y H:i') }}
      </div>
      @endif

      <div style="background:#fffaf0;border:1px solid #fbd38d;border-radius:4px;padding:12px 16px;font-size:13px;color:#7b341e;">
        After saving settings, run this command on the server to generate QR codes for all participants:<br>
        <code style="font-family:monospace;font-weight:600;">php artisan conference:generate-participant-qrcodes --form={{ $form->slug }}</code>
      </div>

      {{-- Badge HTML Template Editor --}}
      <div style="border-top:1px solid #e2e8f0;padding-top:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;flex-wrap:wrap;gap:8px;">
          <h3 style="font-size:14px;font-weight:600;color:#1a202c;margin:0;">Badge HTML Template</h3>
          <div style="display:flex;gap:8px;flex-wrap:wrap;">
            @php $previewSub = $form->submissions()->whereNotNull('qr_token')->first(); @endphp
            @if($previewSub)
            <a href="{{ route('admin.conference.participant-card', [$form, $previewSub]) }}"
               target="_blank"
               style="padding:6px 14px;background:#553c9a;color:#fff;text-decoration:none;border-radius:4px;font-size:12px;font-weight:600;">
              👁 Preview Badge
            </a>
            @endif
            <button type="button" onclick="resetTemplate()"
              style="padding:6px 14px;background:#e53e3e;color:#fff;border:none;border-radius:4px;font-size:12px;font-weight:600;cursor:pointer;">
              ↩ Reset to Default
            </button>
          </div>
        </div>
        <p style="font-size:12px;color:#718096;margin-bottom:10px;">
          Customize the badge design using HTML &amp; CSS. Available placeholders:
          @php $cb = '}}'; @endphp
          @foreach(['NAME','PARTICIPANT_ID','QR_CODE','ROLE','EMAIL','PHONE','EVENT_NAME','EVENT_DATE','EVENT_VENUE','LOGO','ACCENT_COLOR','BG_COLOR'] as $ph)
          <code style="background:#f7fafc;padding:1px 5px;border-radius:3px;display:inline-block;margin:2px 1px;">{{ '{{' . $ph . $cb }}</code>
          @endforeach
        </p>
        <textarea name="badge_html_template" id="badge_html_template" rows="22"
          style="width:100%;padding:12px;border:1px solid #e2e8f0;border-radius:4px;font-size:12px;font-family:'Courier New',monospace;line-height:1.5;color:#2d3748;resize:vertical;"
        >@php echo htmlspecialchars(old('badge_html_template', $settings->badge_html_template ?? \App\Http\Controllers\Admin\ConferenceController::defaultBadgeTemplate())); @endphp</textarea>
        <input type="hidden" name="reset_badge_template" id="reset_badge_template" value="0">
        <p style="font-size:11px;color:#a0aec0;margin-top:6px;">Leave blank or reset to use the system default template. Changes take effect immediately after saving.</p>
        <p style="font-size:11px;color:#e53e3e;margin-top:4px;">⚠ For colors to print correctly, include <code style="background:#fff5f5;padding:1px 4px;border-radius:2px;">* { -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important; }</code> in your &lt;style&gt; block, and add <code style="background:#fff5f5;padding:1px 4px;border-radius:2px;">!important</code> to all background-color rules.</p>
      </div>

      {{-- Flyer Generator --}}
      <div style="border-top:1px solid #e2e8f0;padding-top:20px;">
        <h3 style="font-size:14px;font-weight:600;color:#1a202c;margin:0 0 16px;">&#128444; Flyer Generator</h3>
        <div style="display:grid;gap:16px;">
          <div>
            <label style="display:block;font-size:12px;font-weight:600;color:#4a5568;margin-bottom:6px;">Flyer Hashtag</label>
            <input type="text" name="flyer_hashtag" value="{{ old('flyer_hashtag', $settings->flyer_hashtag ?? '#7AIAbuja2026') }}"
              style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:4px;font-size:14px;"
              placeholder="#7AIAbuja2026" maxlength="100">
          </div>
          <div>
            <label style="display:block;font-size:12px;font-weight:600;color:#4a5568;margin-bottom:6px;">Public Flyer Generator Link</label>
            <div style="display:flex;align-items:center;gap:8px;">
              <input type="text" readonly value="{{ route('conference.flyer', $form->slug) }}"
                style="flex:1;padding:9px 12px;border:1px solid #e2e8f0;border-radius:4px;font-size:13px;font-family:monospace;background:#f7fafc;color:#2b6cb0;cursor:text;"
                onclick="this.select()">
              <a href="{{ route('conference.flyer', $form->slug) }}" target="_blank"
                style="padding:9px 16px;background:#3182ce;color:#fff;text-decoration:none;border-radius:4px;font-size:13px;font-weight:600;white-space:nowrap;">Open</a>
            </div>
            <p style="font-size:11px;color:#a0aec0;margin-top:4px;">Share this link so attendees can create their personalised flyers.</p>
          </div>
          <div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;flex-wrap:wrap;gap:8px;">
              <label style="font-size:12px;font-weight:600;color:#4a5568;margin:0;">Flyer HTML Template</label>
              <button type="button" onclick="resetFlyerTemplate()"
                style="padding:6px 14px;background:#dd6b20;color:#fff;border:none;border-radius:4px;font-size:12px;font-weight:600;cursor:pointer;">
                ↩ Reset to Default
              </button>
            </div>
            <textarea name="flyer_html_template" id="flyer_html_template" rows="14"
              style="width:100%;padding:12px;border:1px solid #e2e8f0;border-radius:4px;font-size:12px;font-family:'Courier New',monospace;line-height:1.5;color:#2d3748;resize:vertical;"
              placeholder="Leave blank to use default template"
            >@php echo htmlspecialchars(old('flyer_html_template', $settings->flyer_html_template ?? '')); @endphp</textarea>
            <input type="hidden" name="reset_flyer_template" id="reset_flyer_template" value="0">
            @php $cb2 = '}}'; @endphp
            <p style="font-size:11px;color:#a0aec0;margin-top:4px;">
              Placeholders:
              @foreach(['NAME','ROLE','PHOTO','EVENT_NAME','EVENT_DATE','HASHTAG','ACCENT_COLOR','BG_COLOR','LOGO'] as $fp)
              <code style="background:#f7fafc;padding:1px 4px;border-radius:2px;display:inline-block;margin:1px;">{{ '{{' . $fp . $cb2 }}</code>
              @endforeach
            </p>
          </div>
        </div>
      </div>

    </div>

    <div style="margin-top:28px;display:flex;gap:10px;">
      <button type="submit"
        style="padding:10px 24px;background:#3182ce;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:14px;font-weight:600;">
        Save Settings
      </button>
      <a href="{{ route('admin.conference.participants', $form) }}"
        style="padding:10px 20px;background:#f7fafc;color:#4a5568;text-decoration:none;border:1px solid #e2e8f0;border-radius:4px;font-size:14px;">
        Cancel
      </a>
    </div>
  </form>

</div>

<script>
function resetTemplate() {
  if (!confirm('Reset badge template to the system default? This will clear your custom HTML.')) return;
  document.getElementById('reset_badge_template').value = '1';
  document.getElementById('badge_html_template').value = '';
  document.querySelector('form').submit();
}
function resetFlyerTemplate() {
  if (!confirm('Reset flyer template to the system default? This will clear your custom HTML.')) return;
  document.getElementById('reset_flyer_template').value = '1';
  document.getElementById('flyer_html_template').value = '';
  document.querySelector('form').submit();
}
</script>
</x-admin-layout>
