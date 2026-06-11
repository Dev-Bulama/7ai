<x-app-layout :title="$page->meta_title ?: $page->title . ' — 7AI'" :description="$page->meta_description ?: 'Smart home automation and AI solutions built for Africa.'">

<div class="page-hero page-hero-dark">
  <div class="section-inner" style="max-width:1280px;margin:0 auto;text-align:center;">
    <div class="section-badge">7AI Solutions</div>
    <h1 style="font-size:clamp(32px,5vw,60px);font-weight:700;color:#fff;letter-spacing:-0.025em;max-width:780px;margin:0 auto 20px;line-height:1.1;">
      {{ $page->title }}
    </h1>
    @if($page->meta_description)
    <p style="font-size:18px;color:rgba(255,255,255,0.7);max-width:560px;margin:0 auto;line-height:1.7;">
      {{ $page->meta_description }}
    </p>
    @endif
  </div>
</div>

<section class="section">
  <div class="section-inner" style="max-width:900px;margin:0 auto;">
    @if($page->content)
      <div class="cms-content">
        {!! $page->content !!}
      </div>
    @endif
  </div>
</section>

<section class="cta-section">
  <div class="section-inner">
    <h2>Ready to Get Started in {{ $page->title }}?</h2>
    <p>Book a free consultation with our local team.</p>
    <div style="display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap;">
      <a href="{{ route('contact') }}" class="btn btn-white btn-lg">Book Consultation</a>
      <a href="{{ route('investors') }}" class="btn btn-lg" style="border:1.5px solid rgba(255,255,255,0.4);color:rgba(255,255,255,0.9);background:transparent;">Become an Investor</a>
    </div>
  </div>
</section>

</x-app-layout>
