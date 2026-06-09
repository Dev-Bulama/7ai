<x-app-layout title="{{ $page?->seo_title ?? 'Solutions — '.($settings['site_name']) }}" description="{{ $page?->seo_description ?? 'Explore 7AI\'s complete suite of smart home and AI solutions.' }}">
<div class="page-hero page-hero-dark">
  <div class="section-inner" style="max-width:1280px;margin:0 auto;">
    <div class="breadcrumb"><a href="{{ route('home') }}" style="color:rgba(255,255,255,0.5);">Home</a><span class="sep" style="color:rgba(255,255,255,0.3);">›</span><span style="color:rgba(255,255,255,0.7);">Solutions</span></div>
    <div class="section-badge">All Solutions</div>
    <h1 style="font-size:clamp(36px,4.5vw,60px);font-weight:700;color:#fff;letter-spacing:-0.025em;max-width:700px;line-height:1.1;margin-bottom:20px;">{!! nl2br(e($page?->hero_title ?? 'Complete Intelligent Technology Solutions')) !!}</h1>
    <p style="font-size:18px;color:rgba(255,255,255,0.7);max-width:540px;line-height:1.7;">{{ $page?->hero_description ?? 'From smart homes to enterprise AI — one partner for all your intelligent technology needs.' }}</p>
    @if($page?->cta_text)
    <div style="margin-top:32px;display:flex;gap:16px;flex-wrap:wrap;">
      <a href="{{ $page->cta_link ?? route('contact') }}" class="btn btn-primary btn-lg">{{ $page->cta_text }}</a>
    </div>
    @endif
  </div>
</div>

<section class="section" style="padding-bottom:0;">
  <div class="section-inner">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:80px;">
      <a href="{{ route('smart-homes') }}" style="text-decoration:none;">
        <div style="background:var(--teal-dark);border-radius:20px;padding:48px;position:relative;overflow:hidden;min-height:280px;display:flex;flex-direction:column;justify-content:flex-end;transition:transform 0.3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
          <div style="position:absolute;inset:0;background:radial-gradient(circle at 70% 30%,rgba(62,224,127,0.12) 0%,transparent 60%);"></div>
          <div style="position:relative;">
            <div style="font-size:11px;font-weight:600;color:var(--green);letter-spacing:0.1em;text-transform:uppercase;margin-bottom:16px;">Smart Home</div>
            <h2 style="font-size:32px;font-weight:700;color:#fff;margin-bottom:12px;letter-spacing:-0.02em;">Home Automation</h2>
            <p style="font-size:15px;color:rgba(255,255,255,0.65);line-height:1.6;max-width:380px;">Complete smart home systems — lighting, security, energy, climate, access, and IoT integration.</p>
            <div style="margin-top:24px;display:inline-flex;align-items:center;gap:8px;color:rgba(255,255,255,0.8);font-size:14px;font-weight:500;">Explore Smart Homes <span>→</span></div>
          </div>
        </div>
      </a>
      <a href="{{ route('ai-solutions') }}" style="text-decoration:none;">
        <div style="background:var(--dark);border-radius:20px;padding:48px;position:relative;overflow:hidden;min-height:280px;display:flex;flex-direction:column;justify-content:flex-end;transition:transform 0.3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
          <div style="position:absolute;inset:0;background:radial-gradient(circle at 30% 70%,rgba(11,79,108,0.4) 0%,transparent 60%);"></div>
          <div style="position:relative;">
            <div style="font-size:11px;font-weight:600;color:var(--green);letter-spacing:0.1em;text-transform:uppercase;margin-bottom:16px;">AI Services</div>
            <h2 style="font-size:32px;font-weight:700;color:#fff;margin-bottom:12px;letter-spacing:-0.02em;">Enterprise AI</h2>
            <p style="font-size:15px;color:rgba(255,255,255,0.65);line-height:1.6;max-width:380px;">Machine learning, predictive analytics, AI agents, computer vision, and custom AI development.</p>
            <div style="margin-top:24px;display:inline-flex;align-items:center;gap:8px;color:rgba(255,255,255,0.8);font-size:14px;font-weight:500;">Explore AI Solutions <span>→</span></div>
          </div>
        </div>
      </a>
    </div>
  </div>
</section>

@if($serviceCategories->count())
<section class="section section-gray">
  <div class="section-inner">
    <div class="section-header" style="text-align:center;">
      <div class="section-badge">All Services</div>
      <h2 class="section-title">Everything We Offer</h2>
    </div>
    @foreach($serviceCategories as $cat)
    <div style="margin-bottom:60px;">
      <h3 style="font-size:22px;font-weight:700;color:var(--dark);margin-bottom:24px;padding-bottom:16px;border-bottom:1px solid var(--gray-200);">{{ $cat->name }}</h3>
      <div class="grid-3">
        @foreach($cat->services->where('status','published') as $service)
        <div class="card">
          @if($service->icon)<div class="card-icon">{!! $service->icon !!}</div>@endif
          <h3>{{ $service->name }}</h3>
          <p>{{ $service->short_description }}</p>
          @if($service->price_from)<div style="margin-top:12px;font-size:13px;color:var(--teal);font-weight:600;">From {{ $service->price_from }}</div>@endif
        </div>
        @endforeach
      </div>
    </div>
    @endforeach
  </div>
</section>
@else
<section class="section section-gray">
  <div class="section-inner">
    <div class="section-header" style="text-align:center;">
      <div class="section-badge">Why 7AI</div>
      <h2 class="section-title">The 7AI Difference</h2>
    </div>
    <div class="grid-3">
      @php $featureCards = \App\Models\Card::where('is_active',true)->where('group','features')->orderBy('sort_order')->get(); @endphp
      @forelse($featureCards as $card)
      <div class="card">
        @if($card->icon)<div class="card-icon">{!! $card->icon !!}</div>@endif
        <h3>{{ $card->title }}</h3>
        <p>{{ $card->description }}</p>
      </div>
      @empty
      <div class="card"><div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div><h3>Built for Africa</h3><p>Designed with African infrastructure, climate, and business realities in mind.</p></div>
      <div class="card"><div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div><h3>Enterprise Security</h3><p>Military-grade encryption, local data sovereignty, and compliance-ready architecture.</p></div>
      <div class="card"><div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg></div><h3>Proven ROI</h3><p>Average 40-60% reduction in energy costs and 70% reduction in manual processes.</p></div>
      @endforelse
    </div>
  </div>
</section>
@endif

<section class="cta-section"><div class="section-inner">
  <h2>{{ $heroCta?->title ?? 'Find the Right Solution for You' }}</h2>
  <p>{{ $heroCta?->text ?? 'Talk to our experts and get a tailored recommendation for your home or business.' }}</p>
  <div style="display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap;">
    <a href="{{ $heroCta?->button_url ?? route('contact') }}" class="btn btn-white btn-lg">{{ $heroCta?->button_label ?? 'Book Consultation' }}</a>
    <a href="{{ route('pricing') }}" class="btn btn-lg" style="border:1.5px solid rgba(255,255,255,0.4);color:rgba(255,255,255,0.9);background:transparent;">View Pricing</a>
  </div>
</div></section>
</x-app-layout>
