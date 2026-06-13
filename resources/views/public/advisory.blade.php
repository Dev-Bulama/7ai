<x-app-layout :title="$page?->seo_title ?? '7ai Advisory — Strategic AI Consulting for Africa'" :description="$page?->seo_description ?? 'Strategic AI advisory and consulting for organisations navigating the AI transition.'">

<div class="page-hero page-hero-navy">
  <div class="hero-ghost" style="font-size:clamp(160px,20vw,340px);color:rgba(168,205,184,0.05);">Adv</div>
  <div class="hero-inner">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a><span>/</span>
      <a href="{{ route('home') }}#pillars">7ai Advise</a><span>/</span>
      <strong>Advisory</strong>
    </div>
    <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">7ai Advise — Advisory</span></div>
    <h1>{!! $page?->hero_title ? nl2br(e($page->hero_title)) : 'Strategic clarity<br><em>for the AI era.</em>' !!}</h1>
    <p class="hero-sub-text">{{ $page?->hero_description ?? 'Expert advisory for organisations ready to move beyond the noise — and make clear, confident decisions about AI strategy, governance, and transformation.' }}</p>
    <div class="hero-actions">
      <a href="{{ $page?->cta_link ?: route('contact') }}" class="btn-primary">{{ $page?->cta_text ?? 'Start a conversation' }}</a>
      <a href="#services" class="btn-ghost">Our services</a>
    </div>
  </div>
</div>

<!-- SERVICES -->
<section class="fe-section bg-navy-mid" id="services">
  <div class="two-col">
    <div>
      <div class="section-label">What we do</div>
      <h2>We help leaders <em>decide</em> — not just understand.</h2>
      <p class="body-text">There's no shortage of AI commentary. What's missing is strategic clarity — the ability to look at your organisation, your sector, and your context, and know exactly what to do and in what order.</p>
      <p class="body-text">7ai Advisory exists for leaders who are done with hype and ready for action. We work with government institutions, corporations, development organisations, and high-growth businesses across Africa.</p>
      <p class="body-text">Our approach is direct, practical, and deeply grounded in the African context — because advice designed for Silicon Valley rarely lands in Lagos or Nairobi.</p>
    </div>
    <div style="display:flex;flex-direction:column;gap:2px;">
      @forelse($services as $s)
      <div style="background:rgba(255,255,255,0.03);border:0.5px solid var(--border-sage);border-radius:4px;padding:28px 32px;transition:background 0.2s;" onmouseover="this.style.background='rgba(122,174,142,0.06)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
        <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.18em;text-transform:uppercase;color:var(--sage);margin-bottom:10px;">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} — {{ $s->subtitle ?? 'Service' }}</div>
        <div style="font-size:17px;font-weight:500;color:var(--white);margin-bottom:8px;">{{ $s->title }}</div>
        <p style="font-size:13px;font-weight:300;color:var(--text-muted);line-height:1.7;">{{ $s->description }}</p>
      </div>
      @empty
      <div style="background:rgba(255,255,255,0.03);border:0.5px solid var(--border-sage);border-radius:4px;padding:28px 32px;">
        <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.18em;text-transform:uppercase;color:var(--sage);margin-bottom:10px;">01 — Strategy</div>
        <div style="font-size:17px;font-weight:500;color:var(--white);margin-bottom:8px;">AI readiness assessment</div>
        <p style="font-size:13px;font-weight:300;color:var(--text-muted);line-height:1.7;">A structured evaluation of your organisation's current capabilities, data, infrastructure, and team — followed by a clear picture of where you stand and what you need.</p>
      </div>
      <div style="background:rgba(255,255,255,0.03);border:0.5px solid var(--border-sage);border-radius:4px;padding:28px 32px;">
        <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.18em;text-transform:uppercase;color:var(--sage);margin-bottom:10px;">02 — Roadmap</div>
        <div style="font-size:17px;font-weight:500;color:var(--white);margin-bottom:8px;">AI transition planning</div>
        <p style="font-size:13px;font-weight:300;color:var(--text-muted);line-height:1.7;">A phased, prioritised plan for how your organisation adopts AI — from quick-win pilots to long-term transformation — with clear ownership and milestones.</p>
      </div>
      <div style="background:rgba(255,255,255,0.03);border:0.5px solid var(--border-sage);border-radius:4px;padding:28px 32px;">
        <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.18em;text-transform:uppercase;color:var(--sage);margin-bottom:10px;">03 — Leadership</div>
        <div style="font-size:17px;font-weight:500;color:var(--white);margin-bottom:8px;">Executive AI briefings</div>
        <p style="font-size:13px;font-weight:300;color:var(--text-muted);line-height:1.7;">Tailored sessions for boards, senior leadership, and government officials — cutting through the noise to give decision-makers exactly what they need to lead confidently.</p>
      </div>
      <div style="background:rgba(255,255,255,0.03);border:0.5px solid var(--border-sage);border-radius:4px;padding:28px 32px;">
        <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.18em;text-transform:uppercase;color:var(--sage);margin-bottom:10px;">04 — Policy</div>
        <div style="font-size:17px;font-weight:500;color:var(--white);margin-bottom:8px;">AI policy &amp; governance</div>
        <p style="font-size:13px;font-weight:300;color:var(--text-muted);line-height:1.7;">Support for government institutions and regulators developing AI policy — drawing on international frameworks and adapting them to the African context.</p>
      </div>
      @endforelse
    </div>
  </div>
</section>

<!-- WHO WE WORK WITH -->
<section class="fe-section bg-navy-deep">
  <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">Who we work with</span></div>
  <h2>Built for those who<br><em>shape the agenda.</em></h2>
  <div class="use-cases-grid">
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">Government ministries</div><p class="uc-desc">Supporting policy teams in developing national AI strategies, digital governance frameworks, and public service automation roadmaps.</p></div>
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">Financial institutions</div><p class="uc-desc">Helping banks, fintechs, and insurance companies navigate AI adoption responsibly — from fraud detection to customer intelligence.</p></div>
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">Development organisations</div><p class="uc-desc">Supporting NGOs, development banks, and international agencies applying AI to health, agriculture, education, and economic inclusion.</p></div>
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">Corporations &amp; conglomerates</div><p class="uc-desc">Advising large businesses and holding companies on organisation-wide AI strategy, change management, and competitive positioning.</p></div>
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">Educational institutions</div><p class="uc-desc">Working with universities and polytechnics to integrate AI into curricula, research programmes, and administrative operations.</p></div>
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">Startups &amp; scale-ups</div><p class="uc-desc">Helping growth-stage companies build AI into their product and operations strategy before competitors do.</p></div>
  </div>
</section>

<!-- FAQ -->
<section class="fe-section bg-navy">
  <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">Common questions</span></div>
  <h2>What clients<br><em>ask us first.</em></h2>
  <div class="faq-list">
    @forelse($faqs as $faq)
    <div class="faq-item {{ $loop->first ? 'open' : '' }}">
      <div class="faq-q" onclick="toggleFaq(this)">{{ $faq->question }}<span class="faq-icon">{{ $loop->first ? '−' : '+' }}</span></div>
      <div class="faq-a">{{ $faq->answer }}</div>
    </div>
    @empty
    <div class="faq-item open">
      <div class="faq-q" onclick="toggleFaq(this)">How does an engagement typically start?<span class="faq-icon">−</span></div>
      <div class="faq-a">It starts with a conversation — usually 45–60 minutes — where we listen to your context, your challenges, and your goals. We then put together a scoped proposal tailored to exactly what you need.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">Do you work across all sectors?<span class="faq-icon">+</span></div>
      <div class="faq-a">Yes. We work across government, financial services, healthcare, education, agriculture, development, and corporate sectors. Our methodology adapts to your sector and context.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">Can you work with organisations outside Nigeria?<span class="faq-icon">+</span></div>
      <div class="faq-a">Absolutely. We work across West Africa and beyond — including Ghana, Kenya, South Africa, and with international organisations operating on the continent.</div>
    </div>
    @endforelse
  </div>
</section>

<!-- CTA -->
<div class="cta-strip">
  <div>
    <h2>Ready to lead your<br>organisation's <em>AI transition?</em></h2>
    <p>Start with a conversation. We'll tell you honestly what's possible, what's practical, and what to do first.</p>
  </div>
  <a href="{{ route('contact') }}" class="btn-dark">Start a conversation →</a>
</div>

<!-- ALSO EXPLORE -->
<div class="also-section">
  <h3>Also from 7ai</h3>
  <div class="also-grid">
    <a href="{{ route('smart-home') }}" class="also-card">
      <div class="also-label">7ai Build</div>
      <div class="also-title">Smart Home</div>
      <p class="also-desc">AI-powered home solutions for African households.</p>
      <span class="also-arrow">Explore →</span>
    </a>
    <a href="{{ route('business-automation') }}" class="also-card">
      <div class="also-label">7ai Build</div>
      <div class="also-title">Business Automation</div>
      <p class="also-desc">Practical AI automation for African businesses.</p>
      <span class="also-arrow">Explore →</span>
    </a>
    <a href="{{ route('personal-ai') }}" class="also-card">
      <div class="also-label">7ai Learn</div>
      <div class="also-title">Personal AI Productivity</div>
      <p class="also-desc">Learn to use AI every day. Free programmes available.</p>
      <span class="also-arrow">Explore →</span>
    </a>
  </div>
</div>

@push('scripts')
<script>
function toggleFaq(el) {
  var item = el.parentElement;
  var icon = el.querySelector('.faq-icon');
  item.classList.toggle('open');
  icon.textContent = item.classList.contains('open') ? '−' : '+';
}
</script>
@endpush
</x-app-layout>
