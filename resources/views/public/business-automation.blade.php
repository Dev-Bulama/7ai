<x-app-layout :title="$page?->seo_title ?? '7ai Business Automation — AI for African Businesses'" :description="$page?->seo_description ?? 'Practical AI automation for African businesses.'">

<div class="page-hero page-hero-biz">
  <div class="hero-ghost" style="color:rgba(168,205,184,0.05);font-size:clamp(160px,22vw,360px);">Biz</div>
  <div class="hero-inner">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a><span>/</span>
      <a href="{{ route('home') }}#pillars">7ai Build</a><span>/</span>
      <strong>Business Automation</strong>
    </div>
    <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">7ai Build — Business</span></div>
    <h1>{!! $page?->hero_title ? nl2br(e($page->hero_title)) : 'Let AI do the<br><em>heavy lifting.</em>' !!}</h1>
    <p class="hero-sub-text">{{ $page?->hero_description ?? 'Practical AI automation for African businesses — reducing manual work, cutting costs, and giving your team the time to focus on what truly matters.' }}</p>
    <div class="hero-actions">
      <a href="{{ $page?->cta_link ?: route('contact') }}" class="btn-primary">{{ $page?->cta_text ?? 'Talk to us' }}</a>
      <a href="#features" class="btn-ghost">See what's possible</a>
    </div>
  </div>
</div>

<!-- FEATURES -->
<section class="fe-section bg-navy-mid" id="features">
  <div class="two-col">
    <div>
      <div class="section-label">Why automate now</div>
      <h2>Your competitors are already <em>using AI.</em></h2>
      <p class="body-text">Across West Africa, forward-looking businesses are using AI to respond to customers faster, process data without a team of analysts, and manage operations with a fraction of the staff time previously required.</p>
      <p class="body-text">7ai Business Automation meets you where you are — whether you run a small trading business, a financial services firm, a healthcare clinic, or a growing e-commerce operation.</p>
      <p class="body-text">No complicated jargon. No imported solutions that don't fit your context. Just automation that works for your business, your team, and your customers.</p>
    </div>
    <div class="feature-list">
      @forelse($features as $f)
      <div class="feature-item">
        <div class="feature-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
        <div><div class="feature-title">{{ $f->title }}</div><div class="feature-desc">{{ $f->description }}</div></div>
      </div>
      @empty
      <div class="feature-item"><div class="feature-num">01</div><div><div class="feature-title">Customer service automation</div><div class="feature-desc">AI chatbots and response systems that handle common customer queries 24/7 — via WhatsApp, your website, or email.</div></div></div>
      <div class="feature-item"><div class="feature-num">02</div><div><div class="feature-title">Document &amp; data processing</div><div class="feature-desc">Automatically extract, sort, and process information from invoices, forms, and reports — cutting manual data entry to near zero.</div></div></div>
      <div class="feature-item"><div class="feature-num">03</div><div><div class="feature-title">Inventory &amp; supply chain AI</div><div class="feature-desc">Predictive inventory management that learns your sales patterns, flags low stock, and helps you order smarter.</div></div></div>
      <div class="feature-item"><div class="feature-num">04</div><div><div class="feature-title">HR &amp; payroll automation</div><div class="feature-desc">Automate leave management, timesheet processing, and payroll calculations — reducing errors and admin time.</div></div></div>
      <div class="feature-item"><div class="feature-num">05</div><div><div class="feature-title">Sales &amp; marketing intelligence</div><div class="feature-desc">AI that analyses your customer data, identifies buying patterns, and helps you reach the right people at the right time.</div></div></div>
      @endforelse
    </div>
  </div>
</section>

<!-- SECTORS -->
<section class="fe-section bg-navy-deep">
  <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">Sectors we serve</span></div>
  <h2>Built for the businesses<br><em>that build Africa.</em></h2>
  <div class="sectors-grid">
    @forelse($sectors as $s)
    <div class="sector-card"><div class="sector-accent"></div><div class="sector-title">{{ $s->title }}</div><p class="sector-desc">{{ $s->description }}</p></div>
    @empty
    <div class="sector-card"><div class="sector-accent"></div><div class="sector-title">Retail &amp; trading</div><p class="sector-desc">Inventory intelligence, automated reordering, and customer loyalty systems for shops and trading businesses.</p></div>
    <div class="sector-card"><div class="sector-accent"></div><div class="sector-title">Financial services</div><p class="sector-desc">Automated document processing, compliance checks, and customer onboarding for microfinance, insurance, and fintech.</p></div>
    <div class="sector-card"><div class="sector-accent"></div><div class="sector-title">Healthcare</div><p class="sector-desc">Patient scheduling, records management, and appointment reminders — giving clinics more time for care.</p></div>
    <div class="sector-card"><div class="sector-accent"></div><div class="sector-title">Logistics &amp; transport</div><p class="sector-desc">Route optimisation, delivery tracking, and fleet management AI for logistics companies.</p></div>
    <div class="sector-card"><div class="sector-accent"></div><div class="sector-title">Real estate</div><p class="sector-desc">Automated tenant communications, maintenance scheduling, and property management dashboards.</p></div>
    <div class="sector-card"><div class="sector-accent"></div><div class="sector-title">Education</div><p class="sector-desc">Admin automation, student data management, and AI-assisted learning tools for schools and universities.</p></div>
    @endforelse
  </div>
</section>

<!-- HOW WE WORK -->
<section class="fe-section bg-navy-mid">
  <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">Our approach</span></div>
  <h2>We start with your<br><em>business, not the tech.</em></h2>
  <div class="steps-grid">
    <div class="step-card"><div class="step-num">01</div><div class="step-title">Business audit</div><p class="step-desc">We map your current processes to identify where time, money, and effort are being lost to manual work.</p></div>
    <div class="step-card"><div class="step-num">02</div><div class="step-title">Automation roadmap</div><p class="step-desc">We design a phased plan — prioritising quick wins first, then building toward deeper transformation over time.</p></div>
    <div class="step-card"><div class="step-num">03</div><div class="step-title">Build &amp; integrate</div><p class="step-desc">We configure or build AI tools that connect to your existing systems — no big-bang replacements, just smart additions.</p></div>
    <div class="step-card"><div class="step-num">04</div><div class="step-title">Team training</div><p class="step-desc">We train your staff so they understand and trust the new systems — adoption matters as much as the technology itself.</p></div>
    <div class="step-card"><div class="step-num">05</div><div class="step-title">Measure &amp; improve</div><p class="step-desc">We track results, report on time saved and costs reduced, and continuously refine your automation as your business grows.</p></div>
  </div>
</section>

<!-- FAQ -->
<section class="fe-section bg-navy">
  <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">Common questions</span></div>
  <h2>Questions businesses<br><em>ask us first.</em></h2>
  <div class="faq-list">
    @forelse($faqs as $faq)
    <div class="faq-item {{ $loop->first ? 'open' : '' }}">
      <div class="faq-q" onclick="toggleFaq(this)">{{ $faq->question }}<span class="faq-icon">{{ $loop->first ? '−' : '+' }}</span></div>
      <div class="faq-a">{{ $faq->answer }}</div>
    </div>
    @empty
    <div class="faq-item open">
      <div class="faq-q" onclick="toggleFaq(this)">Do I need to be a large company to benefit from AI automation?<span class="faq-icon">−</span></div>
      <div class="faq-a">Not at all. Some of our most impactful work is with small and medium businesses. We size our solutions to your business and your budget.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">Will AI replace my staff?<span class="faq-icon">+</span></div>
      <div class="faq-a">Our goal is never to replace people — it's to free them from repetitive work so they can focus on relationships, judgment, and creativity.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">How long does it take to see results?<span class="faq-icon">+</span></div>
      <div class="faq-a">For simple automation (like a WhatsApp chatbot or invoice processing), you can see results within weeks. We always start with quick wins so you see value early.</div>
    </div>
    @endforelse
  </div>
</section>

<!-- CTA -->
<div class="cta-strip">
  <div>
    <h2>Ready to automate your<br><em>business?</em></h2>
    <p>Let's start with a conversation — we'll identify your biggest opportunities and map a path to automation that makes sense for your business.</p>
  </div>
  <a href="{{ route('contact') }}" class="btn-dark">Talk to us →</a>
</div>

<!-- ALSO EXPLORE -->
<div class="also-section">
  <h3>Also from 7ai</h3>
  <div class="also-grid">
    <a href="{{ route('smart-home') }}" class="also-card">
      <div class="also-label">7ai Build</div>
      <div class="also-title">Smart Home</div>
      <p class="also-desc">AI-powered home automation built for African households.</p>
      <span class="also-arrow">Explore →</span>
    </a>
    <a href="{{ route('personal-ai') }}" class="also-card">
      <div class="also-label">7ai Learn</div>
      <div class="also-title">Personal AI</div>
      <p class="also-desc">Practical AI skills training for individuals and teams.</p>
      <span class="also-arrow">Explore →</span>
    </a>
    <a href="{{ route('advisory') }}" class="also-card">
      <div class="also-label">7ai Advise</div>
      <div class="also-title">Advisory</div>
      <p class="also-desc">Strategic guidance for organisations navigating the AI transition.</p>
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
