<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>{{ $title ?? \App\Models\Setting::get('site_name','7AI') . ' — African Intelligence, Amplified' }}</title>
  <meta name="description" content="{{ $description ?? \App\Models\Setting::get('site_tagline','Smart home automation and AI solutions built for Africa.') }}">
  @if(isset($ogImage))
  <meta property="og:image" content="{{ $ogImage }}">
  @endif
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Mono:wght@400;500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/frontend.css') }}">
  {{ $head ?? '' }}
</head>
<body>

@php
  $siteName = \App\Models\Setting::get('site_name','7AI');
  $logoSrc  = \App\Models\Setting::get('logo');
  $navCtaText = \App\Models\Setting::get('nav_cta_text', 'AI CONFERENCE');
  $navCtaUrl  = \App\Models\Setting::get('nav_cta_url', '/abuja');
@endphp

<!-- NAV -->
<nav class="fe-nav" id="fe-nav">
  <a href="{{ route('home') }}" class="fe-nav-logo">
    @if($logoSrc)
      <img src="{{ $logoSrc }}" alt="{{ $siteName }}">
    @else
      7<span>ai</span>
    @endif
  </a>

  <ul class="fe-nav-links">
    <li><a href="{{ route('home') }}#pillars" class="{{ request()->routeIs('home') ? '' : '' }}">What we do</a></li>
    <li><a href="{{ route('smart-homes') }}" class="{{ request()->routeIs('smart-homes') ? 'active' : '' }}">Smart Home</a></li>
    <li><a href="{{ route('business-automation') }}" class="{{ request()->routeIs('business-automation') ? 'active' : '' }}">Business</a></li>
    <li><a href="{{ route('personal-ai') }}" class="{{ request()->routeIs('personal-ai') ? 'active' : '' }}">Personal AI</a></li>
    <li><a href="{{ route('advisory') }}" class="{{ request()->routeIs('advisory') ? 'active' : '' }}">Advisory</a></li>
    <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
    <li><a href="{{ $navCtaUrl }}" class="nav-cta-btn">{{ $navCtaText }}</a></li>
  </ul>

  <button class="fe-mobile-btn" id="fe-mobile-btn" aria-label="Open menu" aria-expanded="false">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- Mobile Drawer -->
<div class="fe-mobile-drawer" id="fe-mobile-drawer">
  <div class="fe-drawer-overlay" id="fe-drawer-overlay"></div>
  <div class="fe-drawer-panel">
    <button class="fe-drawer-close" id="fe-drawer-close" aria-label="Close menu">&times;</button>
    <a href="{{ route('home') }}">Home</a>
    <a href="{{ route('home') }}#pillars">What we do</a>
    <a href="{{ route('smart-homes') }}">Smart Home</a>
    <a href="{{ route('business-automation') }}">Business Automation</a>
    <a href="{{ route('personal-ai') }}">Personal AI</a>
    <a href="{{ route('advisory') }}">Advisory</a>
    <a href="{{ route('about') }}">About</a>
    <a href="{{ route('blog') }}">Blog</a>
    <a href="{{ $navCtaUrl }}" class="fe-drawer-cta">{{ $navCtaText }} →</a>
  </div>
</div>

{{ $slot }}

<!-- FOOTER -->
@php
  $footerTagline = \App\Models\Setting::get('footer_text','African intelligence, amplified.');
  $copyright     = \App\Models\Setting::get('copyright_text','© 2026 7AI. West Africa.');
  $footerLogo    = \App\Models\Setting::get('logo');
@endphp
<footer class="fe-footer">
  <a href="{{ route('home') }}" class="footer-logo">
    @if($footerLogo)
      <img src="{{ $footerLogo }}" alt="{{ $siteName }}">
    @else
      7<span>ai</span>
    @endif
  </a>
  <div class="footer-tagline">{{ $footerTagline }}</div>
  <div class="footer-copy">{{ $copyright }}</div>
</footer>

<script>
(function(){
  var btn     = document.getElementById('fe-mobile-btn');
  var drawer  = document.getElementById('fe-mobile-drawer');
  var overlay = document.getElementById('fe-drawer-overlay');
  var closeBtn= document.getElementById('fe-drawer-close');
  function open(){ drawer.classList.add('open'); btn.setAttribute('aria-expanded','true'); }
  function close(){ drawer.classList.remove('open'); btn.setAttribute('aria-expanded','false'); }
  if(btn) btn.addEventListener('click', open);
  if(overlay) overlay.addEventListener('click', close);
  if(closeBtn) closeBtn.addEventListener('click', close);
})();
</script>

{{ $scripts ?? '' }}
@stack('scripts')

@php
  $activePopup = \App\Models\SitePopup::where('is_active', true)
    ->where(fn($q) => $q->whereNull('start_date')->orWhereDate('start_date','<=',now()))
    ->where(fn($q) => $q->whereNull('end_date')->orWhereDate('end_date','>=',now()))
    ->first();
@endphp
@if($activePopup)
<div id="site-popup" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.75);align-items:center;justify-content:center;padding:20px;">
  <div style="position:relative;max-width:520px;width:100%;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,0.4);">
    <button onclick="closePopup()" style="position:absolute;top:12px;right:12px;z-index:1;background:rgba(0,0,0,0.5);border:none;color:#fff;width:36px;height:36px;border-radius:50%;font-size:20px;line-height:36px;text-align:center;cursor:pointer;">×</button>
    @if($activePopup->image_path)
    <img src="{{ asset('storage/'.$activePopup->image_path) }}" alt="{{ $activePopup->name }}" style="width:100%;max-height:500px;object-fit:contain;display:block;">
    @else
    <div style="background:var(--navy);padding:60px 40px;text-align:center;">
      <div style="font-family:'Playfair Display',serif;font-size:48px;font-weight:700;color:#fff;margin-bottom:8px;">7ai</div>
      <div style="font-size:18px;color:rgba(255,255,255,0.8);">{{ $activePopup->name }}</div>
    </div>
    @endif
    @if($activePopup->link_url)
    <div style="padding:20px;text-align:center;border-top:1px solid #f0f0f0;">
      <a href="{{ $activePopup->link_url }}" class="btn-primary" style="min-width:200px;" onclick="closePopup()">{{ $activePopup->link_text ?? 'Learn More' }}</a>
    </div>
    @endif
  </div>
</div>
<script>
(function(){
  var key='popup_shown_{{ $activePopup->id }}';
  var max={{ $activePopup->show_times }};
  var shown=parseInt(localStorage.getItem(key)||'0');
  if(shown<max){
    setTimeout(function(){
      var el=document.getElementById('site-popup');
      if(el){el.style.display='flex';}
      localStorage.setItem(key,shown+1);
    },1500);
  }
})();
function closePopup(){var el=document.getElementById('site-popup');if(el)el.style.display='none';}
document.getElementById('site-popup')?.addEventListener('click',function(e){if(e.target===this)closePopup();});
</script>
@endif
</body>
</html>
