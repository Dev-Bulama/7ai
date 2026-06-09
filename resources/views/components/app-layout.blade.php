<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? '7AI — African Intelligence, Amplified' }}</title>
  <meta name="description" content="{{ $description ?? 'Smart home automation and AI solutions built for Africa.' }}">
  @if(isset($ogImage))
  <meta property="og:image" content="{{ $ogImage }}">
  @endif
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  {{ $head ?? '' }}
</head>
<body>

<nav class="{{ $navClass ?? 'dark-nav' }}" id="nav">
  <div class="nav-inner">
    <a href="{{ route('home') }}" class="nav-logo">
      <img src="{{ asset('assets/images/logo-white.svg') }}" alt="7AI Logo" id="nav-logo-img">
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
    </ul>
    <div class="nav-cta">
      <a href="{{ route('support') }}" class="btn btn-ghost" style="color:rgba(255,255,255,0.8)">Support</a>
      <a href="{{ route('contact') }}" class="btn btn-primary">Book Consultation</a>
    </div>
    <button class="mobile-menu-btn" aria-label="Menu">
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
      <img src="{{ asset('assets/images/logo-white.svg') }}" alt="7AI">
      <span class="mobile-menu-logo-name">7AI</span>
    </a>
    <button class="mobile-menu-close" id="mobile-menu-close" aria-label="Close menu">&times;</button>
  </div>

  <div class="mobile-menu-body">

    <div class="mobile-nav-label">Solutions</div>

    <button class="mobile-acc-btn" id="solutions-acc-btn" aria-expanded="false">
      Solutions
      <span class="acc-arrow">&#9660;</span>
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
    <div class="footer-grid">
      <div class="footer-brand">
        <img src="{{ asset('assets/images/logo-white.svg') }}" alt="7AI">
        <p>African Intelligence, Amplified. Transforming homes and businesses through AI-powered automation built for Africa's future.</p>
        <div class="social-links" style="margin-top:24px;">
          <a href="#" title="Twitter">𝕏</a>
          <a href="#" title="LinkedIn">in</a>
          <a href="#" title="YouTube">▶</a>
          <a href="#" title="Instagram">◉</a>
        </div>
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
      <p>© 2025 7AI Technologies. All rights reserved. Built for Africa.</p>
      <p style="color:rgba(255,255,255,0.3);">Lagos · Accra · Nairobi · Johannesburg</p>
    </div>
  </div>
</footer>

<script src="{{ asset('assets/js/main.js') }}"></script>
{{ $scripts ?? '' }}
</body>
</html>
