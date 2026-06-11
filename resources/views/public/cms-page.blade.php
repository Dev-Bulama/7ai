<x-app-layout :title="$page->meta_title ?: ($page->title . ' — 7ai')" :description="$page->meta_description ?: 'Smart home automation and AI solutions built for Africa.'">

<!-- HERO -->
<div class="page-hero page-hero-navy">
  <div class="hero-ghost" style="color:rgba(168,205,184,0.04);font-size:clamp(100px,16vw,260px);">7ai</div>
  <div class="hero-inner">
    <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">7ai</span></div>
    <h1>{{ $page->title }}</h1>
    @if($page->meta_description)
    <p class="hero-sub-text">{{ $page->meta_description }}</p>
    @endif
  </div>
</div>

<!-- CONTENT + REGISTRATION FORM -->
<section class="fe-section bg-navy-mid">
  <div class="cms-page-grid" style="display:grid;grid-template-columns:1fr 420px;gap:80px;align-items:start;max-width:1180px;margin:0 auto;">

    <!-- Page body content -->
    <div>
      @if($page->content)
      <div class="cms-content" style="color:var(--text-muted);line-height:1.8;font-size:15px;font-weight:300;">
        {!! $page->content !!}
      </div>
      @endif
    </div>

    <!-- Registration form -->
    <div style="background:rgba(255,255,255,0.03);border:0.5px solid var(--border-sage);border-radius:4px;padding:40px;position:sticky;top:80px;">
      <div class="section-label" style="margin-bottom:8px;">Free registration</div>
      <h3 style="font-family:'Playfair Display',serif;font-size:24px;font-weight:700;color:var(--white);margin-bottom:8px;line-height:1.2;">Save your seat</h3>
      <p style="font-size:13px;font-weight:300;color:var(--text-muted);margin-bottom:28px;line-height:1.6;">Fill in your details and we'll send the full event info to your email.</p>

      @if(session('success'))
      <div class="alert-success">{{ session('success') }}</div>
      @endif

      <form method="POST" action="{{ route('contact.submit') }}" class="contact-form">
        @csrf
        <input type="hidden" name="service_interest" value="abuja-conference">
        <input type="hidden" name="message" value="Registered for Abuja AI Conference">

        <div class="form-field">
          <label class="form-label">First name *</label>
          <input type="text" name="first_name" class="form-input" required placeholder="e.g. Amaka">
        </div>
        <div class="form-field">
          <label class="form-label">Last name *</label>
          <input type="text" name="last_name" class="form-input" required placeholder="e.g. Okafor">
        </div>
        <div class="form-field">
          <label class="form-label">Email address *</label>
          <input type="email" name="email" class="form-input" required placeholder="you@example.com">
        </div>
        <div class="form-field">
          <label class="form-label">Phone (WhatsApp)</label>
          <input type="tel" name="phone" class="form-input" placeholder="+234...">
        </div>
        <div class="form-field">
          <label class="form-label">Organisation / Company</label>
          <input type="text" name="company" class="form-input" placeholder="Your employer or business">
        </div>
        <button type="submit" class="form-submit" style="width:100%;text-align:center;margin-top:8px;">Register free →</button>
        <p style="font-size:11px;font-weight:300;color:var(--text-dim);margin-top:16px;text-align:center;line-height:1.5;">No cost. No spam. We'll only contact you about this event.</p>
      </form>
    </div>
  </div>
</section>

<!-- ALSO EXPLORE -->
<div class="also-section">
  <h3>Learn more about 7ai</h3>
  <div class="also-grid">
    <a href="{{ route('smart-homes') }}" class="also-card">
      <div class="also-label">7ai Build</div>
      <div class="also-title">Smart Home</div>
      <p class="also-desc">Intelligent automation for African homes — lighting, security, energy, and more.</p>
      <span class="also-arrow">→</span>
    </a>
    <a href="{{ route('business-automation') }}" class="also-card">
      <div class="also-label">7ai Build</div>
      <div class="also-title">Business Automation</div>
      <p class="also-desc">Practical AI automation that reduces manual work and gives your team time back.</p>
      <span class="also-arrow">→</span>
    </a>
    <a href="{{ route('about') }}" class="also-card">
      <div class="also-label">Company</div>
      <div class="also-title">About 7ai</div>
      <p class="also-desc">Our mission, values, and the team building Africa's AI future.</p>
      <span class="also-arrow">→</span>
    </a>
  </div>
</div>

</x-app-layout>

<style>
@media (max-width: 900px) {
  .cms-page-grid { grid-template-columns: 1fr !important; }
}
</style>
