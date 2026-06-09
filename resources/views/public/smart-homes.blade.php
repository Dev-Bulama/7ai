<x-app-layout title="{{ $page?->seo_title ?? 'Smart Homes — '.($settings['site_name']) }}" description="{{ $page?->seo_description ?? 'Complete smart home automation systems for African homes.' }}">
<div class="page-hero page-hero-dark">
  <div class="section-inner" style="max-width:1280px;margin:0 auto;">
    <div class="breadcrumb"><a href="{{ route('home') }}" style="color:rgba(255,255,255,0.5);">Home</a><span class="sep" style="color:rgba(255,255,255,0.3);">›</span><a href="{{ route('solutions') }}" style="color:rgba(255,255,255,0.5);">Solutions</a><span class="sep" style="color:rgba(255,255,255,0.3);">›</span><span style="color:rgba(255,255,255,0.7);">Smart Homes</span></div>
    <div class="section-badge">Smart Home</div>
    <h1 style="font-size:clamp(36px,4.5vw,60px);font-weight:700;color:#fff;letter-spacing:-0.025em;max-width:700px;line-height:1.1;margin-bottom:20px;">{!! nl2br(e($page?->hero_title ?? 'Smart Home Automation for African Living')) !!}</h1>
    <p style="font-size:18px;color:rgba(255,255,255,0.7);max-width:540px;line-height:1.7;">{{ $page?->hero_description ?? "Africa's most comprehensive smart home platform — seamlessly connecting every device, system, and space in your home." }}</p>
    <div style="margin-top:40px;display:flex;gap:16px;flex-wrap:wrap;">
      <a href="{{ $heroCta?->button_url ?? route('contact') }}" class="btn btn-primary btn-lg">{{ $page?->cta_text ?? $heroCta?->button_label ?? 'Book Home Assessment' }}</a>
      <a href="{{ route('pricing') }}" class="btn btn-white btn-lg">View Packages</a>
    </div>
  </div>
</div>

<!-- SMART HOME CARDS -->
<section class="section">
  <div class="section-inner">
    <div class="section-header">
      <div class="section-badge">Features</div>
      <h2 class="section-title">Everything Your Smart<br>Home Needs</h2>
      <p class="section-sub">Nine integrated systems working in harmony to make your home genuinely intelligent.</p>
    </div>
    <div class="grid-3">
      @forelse($cards as $card)
      <div class="card">
        @if($card->icon)<div class="card-icon">{!! $card->icon !!}</div>@endif
        <h3>{{ $card->title }}</h3>
        <p>{{ $card->description }}</p>
        @if($card->button_text && $card->link)
        <a href="{{ $card->link }}" style="color:var(--teal);font-size:13px;font-weight:600;margin-top:8px;display:inline-block;">{{ $card->button_text }} →</a>
        @endif
      </div>
      @empty
      <div class="card"><h3>Smart Lighting</h3><p>Adaptive lighting that reduces energy by 60% and sets the perfect ambiance automatically.</p></div>
      <div class="card"><h3>Smart Security</h3><p>AI-powered security with facial recognition, motion detection, and 24/7 real-time alerts.</p></div>
      <div class="card"><h3>Smart Energy</h3><p>Solar integration and load management — cut bills and maximise renewable energy.</p></div>
      @endforelse
    </div>
  </div>
</section>

@if($services->count())
<!-- SERVICES LIST -->
<section class="section section-gray">
  <div class="section-inner">
    <div class="section-header" style="text-align:center;">
      <div class="section-badge">Packages</div>
      <h2 class="section-title">Smart Home Packages</h2>
      <p class="section-sub">Choose a package or let us build a custom solution for your home.</p>
    </div>
    <div class="grid-3">
      @foreach($services as $service)
      <div class="card">
        @if($service->icon)<div class="card-icon">{!! $service->icon !!}</div>@endif
        <h3>{{ $service->name }}</h3>
        <p>{{ $service->short_description }}</p>
        @if($service->price_from)<div style="margin-top:12px;font-size:14px;color:var(--teal);font-weight:600;">From {{ $service->price_from }}</div>@endif
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

@if($faqs->count())
<!-- FAQs -->
<section class="section">
  <div class="section-inner" style="max-width:800px;margin:0 auto;">
    <div class="section-header" style="text-align:center;">
      <div class="section-badge">FAQ</div>
      <h2 class="section-title">Frequently Asked Questions</h2>
    </div>
    @foreach($faqs as $faq)
    <details style="border-bottom:1px solid var(--gray-200);padding:20px 0;" @if($loop->first) open @endif>
      <summary style="cursor:pointer;font-size:17px;font-weight:600;color:var(--dark);list-style:none;display:flex;justify-content:space-between;align-items:center;">
        {{ $faq->question }}<span style="font-size:20px;color:var(--gray-400);">+</span>
      </summary>
      <p style="margin-top:12px;color:var(--gray-600);line-height:1.7;font-size:15px;">{{ $faq->answer }}</p>
    </details>
    @endforeach
  </div>
</section>
@endif

<section class="cta-section"><div class="section-inner">
  <h2>{{ $bottomCta?->title ?? 'Ready to Transform Your Home?' }}</h2>
  <p>{{ $bottomCta?->text ?? 'Book a free home assessment and discover what smart automation can do for you.' }}</p>
  <div style="display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap;">
    <a href="{{ $bottomCta?->button_url ?? route('contact') }}" class="btn btn-white btn-lg">{{ $bottomCta?->button_label ?? 'Book Free Assessment' }}</a>
    <a href="{{ route('pricing') }}" class="btn btn-lg" style="border:1.5px solid rgba(255,255,255,0.4);color:rgba(255,255,255,0.9);background:transparent;">View Pricing</a>
  </div>
</div></section>
</x-app-layout>
