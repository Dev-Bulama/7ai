<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>{{ $title ?? config('app.name', '7AI') . ' — African Intelligence, Amplified' }}</title>
  <meta name="description" content="{{ $description ?? 'Smart home automation and AI solutions built for Africa.' }}">
  @if(isset($ogImage))
  <meta property="og:image" content="{{ $ogImage }}">
  @endif
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* Mobile-first critical overrides */
    html, body { max-width: 100%; overflow-x: hidden; }
    img { max-width: 100%; height: auto; }
    * { box-sizing: border-box; }
    /* Ensure nav doesn't overflow on mobile */
    @media (max-width: 900px) {
      .nav-links, .nav-cta { display: none !important; }
      .mobile-menu-btn { display: flex !important; }
    }
  </style>
  {{ $head ?? '' }}
</head>
<body>

<nav class="{{ $navClass ?? 'dark-nav' }}" id="nav">
  <div class="nav-inner">
    <a href="{{ route('home') }}" class="nav-logo">
      @php $logoSrc = \App\Models\Setting::get('logo', '/assets/images/logo-white.svg'); @endphp
      <img src="{{ $logoSrc }}" alt="{{ \App\Models\Setting::get('site_name','7AI') }} Logo" id="nav-logo-img">
    </a>
    <ul class="nav-links">
      <li class="dropdown">
        <a href="{{ route('solutions') }}">Solutions ▾</a>
        <div class="dropdown-menu">
          <a href="{{ route('smart-homes') }}">Smart Homes</a>
          <a href="{{ route('ai-solutions') }}">AI Solutions</a>
          <a href="{{ route('industries') }}">Industries</a>
        </div>
      </li>
      <li><a href="{{ route('pricing') }}" class="{{ request()->routeIs('pricing') ? 'active' : '' }}">Pricing</a></li>
      <li><a href="{{ route('case-studies') }}" class="{{ request()->routeIs('case-studies') ? 'active' : '' }}">Case Studies</a></li>
      <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') ? 'active' : '' }}">Blog</a></li>
      <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
      <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
      <li><a href="{{ route('investors') }}" class="{{ request()->routeIs('investors') ? 'active' : '' }}">Investors</a></li>
    </ul>
    <div class="nav-cta">
      <a href="{{ route('support') }}" class="btn btn-ghost" style="color:rgba(255,255,255,0.8)">Support</a>
      <a href="{{ route('contact') }}" class="btn btn-primary">Book Consultation</a>
    </div>
    <button class="mobile-menu-btn" id="mobile-menu-btn" aria-label="Menu" aria-expanded="false" aria-controls="mobile-menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<!-- Mobile overlay -->
<div class="mobile-overlay" id="mobile-overlay"></div>

<!-- Mobile slide-in drawer -->
<div class="mobile-menu" id="mobile-menu" role="dialog" aria-modal="true" aria-label="Navigation menu">
  <div class="mobile-menu-header">
    <a href="{{ route('home') }}" class="mobile-menu-logo">
      <img src="{{ $logoSrc ?? '/assets/images/logo-white.svg' }}" alt="7AI">
      <span class="mobile-menu-logo-name">{{ \App\Models\Setting::get('site_name','7AI') }}</span>
    </a>
    <button class="mobile-menu-close" id="mobile-menu-close" aria-label="Close menu">&times;</button>
  </div>

  <div class="mobile-menu-body">
    <div class="mobile-nav-label">Solutions</div>
    <button class="mobile-acc-btn" id="solutions-acc-btn" aria-expanded="false">
      Solutions <span class="acc-arrow">&#9660;</span>
    </button>
    <div class="mobile-acc-panel" id="solutions-acc-panel">
      <a href="{{ route('solutions') }}">All Solutions</a>
      <a href="{{ route('smart-homes') }}">Smart Homes</a>
      <a href="{{ route('ai-solutions') }}">AI Solutions</a>
      <a href="{{ route('industries') }}">Industries</a>
    </div>

    <div class="mobile-nav-label">Company</div>
    <a href="{{ route('pricing') }}">Pricing</a>
    <a href="{{ route('case-studies') }}">Case Studies</a>
    <a href="{{ route('blog') }}">Blog</a>
    <a href="{{ route('about') }}">About Us</a>
    <a href="{{ route('careers') }}">Careers</a>
    <a href="{{ route('investors') }}">Investors</a>

    <div class="mobile-nav-label">Help</div>
    <a href="{{ route('support') }}">Support Center</a>
    <a href="{{ route('docs') }}">Documentation</a>
    <a href="{{ route('contact') }}">Contact Us</a>
  </div>

  <div class="mobile-menu-footer">
    @auth
      <a href="{{ route('customer.dashboard') }}" class="btn btn-ghost-dark">My Dashboard</a>
    @else
      <a href="{{ route('login') }}" class="btn btn-ghost-dark">Sign In</a>
    @endauth
    <a href="{{ route('contact') }}" class="btn btn-primary">Book Consultation</a>
  </div>
</div>

{{ $slot }}

<footer>
  <div class="footer-inner">
    @php
      $footerText  = \App\Models\Setting::get('footer_text', 'African Intelligence, Amplified. Transforming homes and businesses through AI-powered automation built for Africa\'s future.');
      $copyright   = \App\Models\Setting::get('copyright_text', '© 2025 7AI Technologies. All rights reserved. Built for Africa.');
      $socialLinks = \App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get();
    @endphp
    <div class="footer-grid">
      <div class="footer-brand">
        <img src="{{ \App\Models\Setting::get('logo', '/assets/images/logo-white.svg') }}" alt="7AI">
        <p>{{ $footerText }}</p>
        @if($socialLinks->isNotEmpty())
        <div class="social-links" style="margin-top:24px;display:flex;gap:12px;">
          @foreach($socialLinks as $social)
          <a href="{{ $social->url }}" title="{{ ucfirst($social->platform) }}" target="_blank" rel="noopener">
            @switch($social->platform)
              @case('twitter') 𝕏 @break
              @case('linkedin') in @break
              @case('youtube') ▶ @break
              @case('instagram') ◉ @break
              @case('facebook') f @break
              @default {{ substr($social->platform,0,1) }}
            @endswitch
          </a>
          @endforeach
        </div>
        @else
        <div class="social-links" style="margin-top:24px;">
          <a href="#" title="Twitter">𝕏</a>
          <a href="#" title="LinkedIn">in</a>
          <a href="#" title="YouTube">▶</a>
          <a href="#" title="Instagram">◉</a>
        </div>
        @endif
      </div>
      <div class="footer-col">
        <h4>Solutions</h4>
        <ul>
          <li><a href="{{ route('smart-homes') }}">Smart Homes</a></li>
          <li><a href="{{ route('ai-solutions') }}">AI Solutions</a></li>
          <li><a href="{{ route('industries') }}">Industries</a></li>
          <li><a href="{{ route('solutions') }}">All Solutions</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="{{ route('about') }}">About Us</a></li>
          <li><a href="{{ route('case-studies') }}">Case Studies</a></li>
          <li><a href="{{ route('blog') }}">Blog</a></li>
          <li><a href="{{ route('careers') }}">Careers</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Support</h4>
        <ul>
          <li><a href="{{ route('support') }}">Help Center</a></li>
          <li><a href="{{ route('docs') }}">Documentation</a></li>
          <li><a href="{{ route('contact') }}">Contact Us</a></li>
          <li><a href="{{ route('pricing') }}">Pricing</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Legal</h4>
        <ul>
          <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
          <li><a href="{{ route('terms') }}">Terms of Service</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>{{ $copyright }}</p>
      @php $addr = \App\Models\Setting::get('address','Lagos · Accra · Nairobi · Johannesburg'); @endphp
      @if($addr)
      <p style="color:rgba(255,255,255,0.3);">{{ $addr }}</p>
      @endif
    </div>
  </div>
</footer>

<script src="{{ asset('assets/js/main.js') }}"></script>
{{ $scripts ?? '' }}

@php
  $activePopup = \App\Models\SitePopup::where('is_active', true)
    ->where(fn($q) => $q->whereNull('start_date')->orWhereDate('start_date','<=',now()))
    ->where(fn($q) => $q->whereNull('end_date')->orWhereDate('end_date','>=',now()))
    ->first();
@endphp
@if($activePopup)
<!-- POPUP FLYER -->
<div id="site-popup" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.75);align-items:center;justify-content:center;padding:20px;">
  <div style="position:relative;max-width:520px;width:100%;background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,0.4);">
    <button onclick="closePopup()" style="position:absolute;top:12px;right:12px;z-index:1;background:rgba(0,0,0,0.5);border:none;color:#fff;width:36px;height:36px;border-radius:50%;font-size:20px;line-height:36px;text-align:center;cursor:pointer;">×</button>
    @if($activePopup->image_path)
    <img src="{{ asset('storage/'.$activePopup->image_path) }}" alt="{{ $activePopup->name }}" style="width:100%;max-height:500px;object-fit:contain;display:block;">
    @else
    <div style="background:linear-gradient(135deg,var(--teal-dark),var(--teal));padding:60px 40px;text-align:center;">
      <div style="font-size:48px;font-weight:700;color:#fff;margin-bottom:8px;">7AI</div>
      <div style="font-size:18px;color:rgba(255,255,255,0.8);">{{ $activePopup->name }}</div>
    </div>
    @endif
    @if($activePopup->link_url)
    <div style="padding:20px;text-align:center;border-top:1px solid #f0f0f0;">
      <a href="{{ $activePopup->link_url }}" class="btn btn-primary" style="min-width:200px;" onclick="closePopup()">{{ $activePopup->link_text ?? 'Learn More' }}</a>
    </div>
    @endif
  </div>
</div>
<script>
(function() {
  var key = 'popup_shown_{{ $activePopup->id }}';
  var max = {{ $activePopup->show_times }};
  var shown = parseInt(localStorage.getItem(key) || '0');
  if (shown < max) {
    setTimeout(function() {
      var el = document.getElementById('site-popup');
      if (el) { el.style.display = 'flex'; }
      localStorage.setItem(key, shown + 1);
    }, 1500);
  }
})();
function closePopup() {
  var el = document.getElementById('site-popup');
  if (el) { el.style.display = 'none'; }
}
document.getElementById('site-popup')?.addEventListener('click', function(e) {
  if (e.target === this) closePopup();
});
</script>
@endif
</body>
</html>
