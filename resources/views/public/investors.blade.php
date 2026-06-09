<x-app-layout title="{{ $page?->seo_title ?? 'Investor Relations — '.($settings['site_name']) }}" description="{{ $page?->seo_description ?? 'Join 7AI as an investor. Be part of Africa\'s AI revolution.' }}">

<div class="page-hero page-hero-dark">
  <div class="section-inner" style="max-width:1280px;margin:0 auto;text-align:center;">
    <div class="section-badge" style="margin:0 auto 20px;">Investor Relations</div>
    <h1 style="font-size:clamp(32px,5vw,60px);font-weight:700;color:#fff;letter-spacing:-0.025em;max-width:680px;margin:0 auto 20px;line-height:1.1;">
      {!! nl2br(e($page?->hero_title ?? "Invest in Africa's AI Future")) !!}
    </h1>
    <p style="font-size:18px;color:rgba(255,255,255,0.7);max-width:520px;margin:0 auto;line-height:1.7;">
      {{ $page?->hero_description ?? '7AI is building the infrastructure for Africa\'s intelligent future. We\'re inviting aligned investors to grow with us.' }}
    </p>
    @if($page?->cta_text)
    <div style="margin-top:32px;">
      <a href="{{ $page->cta_link ?? route('contact') }}" class="btn btn-primary btn-lg">{{ $page->cta_text }}</a>
    </div>
    @endif
  </div>
</div>

<!-- WHY INVEST -->
<section class="section">
  <div class="section-inner">
    <div class="section-header" style="text-align:center;">
      <div class="section-badge">The Opportunity</div>
      <h2 class="section-title">Why Invest in 7AI</h2>
      <p class="section-sub" style="margin:0 auto;">Africa's AI market is projected to reach $16 billion by 2030. 7AI is positioned at the intersection of smart home technology, enterprise AI, and African consumer growth.</p>
    </div>
    <div class="grid-3" style="margin-bottom:60px;">
      <div class="card">
        <div class="card-icon" style="background:rgba(11,79,108,0.08);width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
          <svg width="22" height="22" fill="none" stroke="#0B4F6C" stroke-width="2" viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
        </div>
        <h3 style="font-size:17px;font-weight:700;color:#0d1b2a;margin-bottom:8px;">$16B Market by 2030</h3>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;">Africa's AI and smart technology market is one of the fastest-growing globally, with 1.4 billion people entering the digital economy.</p>
      </div>
      <div class="card">
        <div class="card-icon" style="background:rgba(62,224,127,0.1);width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
          <svg width="22" height="22" fill="none" stroke="#3EE07F" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        </div>
        <h3 style="font-size:17px;font-weight:700;color:#0d1b2a;margin-bottom:8px;">First-Mover Advantage</h3>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;">7AI is among the first vertically integrated AI and smart home platforms built specifically for African homes and businesses.</p>
      </div>
      <div class="card">
        <div class="card-icon" style="background:rgba(11,79,108,0.08);width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
          <svg width="22" height="22" fill="none" stroke="#0B4F6C" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <h3 style="font-size:17px;font-weight:700;color:#0d1b2a;margin-bottom:8px;">500+ Active Clients</h3>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;">Proven traction across Nigeria, Ghana, Kenya and South Africa with enterprise contracts and a growing residential install base.</p>
      </div>
      <div class="card">
        <div class="card-icon" style="background:rgba(11,79,108,0.08);width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
          <svg width="22" height="22" fill="none" stroke="#0B4F6C" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
        <h3 style="font-size:17px;font-weight:700;color:#0d1b2a;margin-bottom:8px;">Recurring Revenue Model</h3>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;">Subscription-based AI services and managed smart home contracts deliver predictable, compounding recurring revenue streams.</p>
      </div>
      <div class="card">
        <div class="card-icon" style="background:rgba(11,79,108,0.08);width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
          <svg width="22" height="22" fill="none" stroke="#0B4F6C" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <h3 style="font-size:17px;font-weight:700;color:#0d1b2a;margin-bottom:8px;">Enterprise-Grade Security</h3>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;">Built on a foundation of local data sovereignty and compliance-ready architecture that meets institutional and government standards.</p>
      </div>
      <div class="card">
        <div class="card-icon" style="background:rgba(11,79,108,0.08);width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
          <svg width="22" height="22" fill="none" stroke="#0B4F6C" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
        <h3 style="font-size:17px;font-weight:700;color:#0d1b2a;margin-bottom:8px;">120+ Business Clients</h3>
        <p style="font-size:14px;color:#6b7280;line-height:1.6;">Enterprise AI deployments across 12 African countries with an average contract value growing 40% year over year.</p>
      </div>
    </div>
  </div>
</section>

<!-- STATS STRIP -->
<section class="section section-dark" style="background:#083A50;padding:60px 24px;">
  <div class="section-inner">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:40px;text-align:center;">
      <div><div style="font-size:36px;font-weight:700;color:#3EE07F;letter-spacing:-0.03em;">500+</div><div style="font-size:13px;color:rgba(255,255,255,0.6);margin-top:4px;">Homes Automated</div></div>
      <div><div style="font-size:36px;font-weight:700;color:#3EE07F;letter-spacing:-0.03em;">120+</div><div style="font-size:13px;color:rgba(255,255,255,0.6);margin-top:4px;">Business Clients</div></div>
      <div><div style="font-size:36px;font-weight:700;color:#3EE07F;letter-spacing:-0.03em;">12</div><div style="font-size:13px;color:rgba(255,255,255,0.6);margin-top:4px;">African Countries</div></div>
      <div><div style="font-size:36px;font-weight:700;color:#3EE07F;letter-spacing:-0.03em;">98%</div><div style="font-size:13px;color:rgba(255,255,255,0.6);margin-top:4px;">Client Satisfaction</div></div>
      <div><div style="font-size:36px;font-weight:700;color:#3EE07F;letter-spacing:-0.03em;">40%</div><div style="font-size:13px;color:rgba(255,255,255,0.6);margin-top:4px;">YoY Revenue Growth</div></div>
    </div>
  </div>
</section>

<!-- REGISTRATION FORM -->
<section class="section section-gray">
  <div class="section-inner" style="max-width:720px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:48px;">
      <div class="section-badge">Register Your Interest</div>
      <h2 class="section-title">Investor Registration</h2>
      <p style="font-size:16px;color:#6b7280;line-height:1.7;">Complete the form below and our investor relations team will be in touch with a full investment pack within 48 hours.</p>
    </div>

    @if(session('success'))
      <div style="background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:20px 24px;border-radius:12px;margin-bottom:32px;font-size:15px;font-weight:500;text-align:center;">
        ✓ Thank you! Your registration has been received. We'll be in touch within 48 hours.
      </div>
    @endif

    <div style="background:#fff;border-radius:20px;border:1px solid #e5e7eb;padding:40px;">
      <form method="POST" action="{{ route('investors.register') }}">
        @csrf

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;" class="form-grid-2">
          <div>
            <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">First Name *</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}" required
              style="width:100%;padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;outline:none;"
              onfocus="this.style.borderColor='#0B4F6C'" onblur="this.style.borderColor='#e5e7eb'">
            @error('first_name')<span style="color:#dc2626;font-size:12px;">{{ $message }}</span>@enderror
          </div>
          <div>
            <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Last Name *</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}" required
              style="width:100%;padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;outline:none;"
              onfocus="this.style.borderColor='#0B4F6C'" onblur="this.style.borderColor='#e5e7eb'">
          </div>
        </div>

        <div style="margin-bottom:20px;">
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Email Address *</label>
          <input type="email" name="email" value="{{ old('email') }}" required
            style="width:100%;padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;outline:none;"
            onfocus="this.style.borderColor='#0B4F6C'" onblur="this.style.borderColor='#e5e7eb'">
          @error('email')<span style="color:#dc2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;" class="form-grid-2">
          <div>
            <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Phone Number</label>
            <input type="tel" name="phone" value="{{ old('phone') }}"
              placeholder="+234 800 000 0000"
              style="width:100%;padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;outline:none;"
              onfocus="this.style.borderColor='#0B4F6C'" onblur="this.style.borderColor='#e5e7eb'">
          </div>
          <div>
            <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Country *</label>
            <select name="country" required
              style="width:100%;padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;outline:none;background:#fff;">
              <option value="">Select country</option>
              <option>Nigeria</option><option>Ghana</option><option>Kenya</option>
              <option>South Africa</option><option>United Kingdom</option>
              <option>United States</option><option>UAE</option><option>Other</option>
            </select>
          </div>
        </div>

        <div style="margin-bottom:20px;">
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Organisation / Company</label>
          <input type="text" name="company" value="{{ old('company') }}"
            placeholder="Your fund, family office, or company name"
            style="width:100%;padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;outline:none;"
            onfocus="this.style.borderColor='#0B4F6C'" onblur="this.style.borderColor='#e5e7eb'">
        </div>

        <div style="margin-bottom:20px;">
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Investor Type *</label>
          <select name="investor_type" required
            style="width:100%;padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;outline:none;background:#fff;">
            <option value="">Select type</option>
            <option>Angel Investor</option>
            <option>Venture Capital Fund</option>
            <option>Private Equity</option>
            <option>Family Office</option>
            <option>Corporate / Strategic Investor</option>
            <option>Government / Development Finance</option>
            <option>Individual / High Net Worth</option>
          </select>
          @error('investor_type')<span style="color:#dc2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>

        <div style="margin-bottom:20px;">
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Investment Range (USD) *</label>
          <select name="investment_range" required
            style="width:100%;padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;outline:none;background:#fff;">
            <option value="">Select range</option>
            <option>$25,000 – $100,000</option>
            <option>$100,000 – $500,000</option>
            <option>$500,000 – $1,000,000</option>
            <option>$1,000,000 – $5,000,000</option>
            <option>$5,000,000+</option>
          </select>
          @error('investment_range')<span style="color:#dc2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>

        <div style="margin-bottom:28px;">
          <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Why are you interested in 7AI?</label>
          <textarea name="message" rows="4"
            placeholder="Tell us about your investment thesis and what excites you about 7AI's opportunity..."
            style="width:100%;padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;outline:none;resize:vertical;"
            onfocus="this.style.borderColor='#0B4F6C'" onblur="this.style.borderColor='#e5e7eb'">{{ old('message') }}</textarea>
        </div>

        <div style="background:#f8fafc;border-radius:10px;padding:16px;margin-bottom:24px;font-size:13px;color:#6b7280;line-height:1.6;">
          🔒 Your information is kept strictly confidential. 7AI will not share your details with third parties without your consent. Our investor relations team will contact you within 48 hours.
        </div>

        <button type="submit"
          style="width:100%;padding:14px;background:#0B4F6C;color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:700;cursor:pointer;font-family:inherit;transition:background 0.2s;"
          onmouseover="this.style.background='#083A50'" onmouseout="this.style.background='#0B4F6C'">
          Submit Registration →
        </button>
      </form>
    </div>
  </div>
</section>

<style>
@media (max-width: 600px) {
  .form-grid-2 { grid-template-columns: 1fr !important; }
}
</style>
</x-app-layout>
