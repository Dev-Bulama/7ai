<x-app-layout :title="$page?->seo_title ?? '7ai Smart Home — AI-Powered Living for Africa'" :description="$page?->seo_description ?? 'AI-powered smart home solutions designed for African households.'">

<div class="page-hero page-hero-navy">
  <div class="hero-ghost">&#8962;</div>
  <div class="hero-inner">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a><span>/</span>
      <a href="{{ route('home') }}#pillars">7ai Build</a><span>/</span>
      <strong>Smart Home</strong>
    </div>
    <div class="eyebrow-row">
      <div class="eyebrow-line"></div>
      <span class="eyebrow-text">7ai Build — Smart Home</span>
    </div>
    <h1>{!! $page?->hero_title ? nl2br(e($page->hero_title)) : 'Your home,<br><em>intelligently yours.</em>' !!}</h1>
    <p class="hero-sub-text">{{ $page?->hero_description ?? 'AI-powered smart home solutions designed for African households — affordable, practical, and built for our climate, our power realities, and our way of living.' }}</p>
    <div class="hero-actions">
      <a href="{{ route('contact') }}" class="btn-primary">Get a consultation</a>
      <a href="#features" class="btn-ghost">See what's possible</a>
    </div>
  </div>
</div>

<!-- INTRO / FEATURES -->
<section class="fe-section bg-navy-mid" id="features">
  <div class="two-col">
    <div>
      <div class="section-label">The problem we solve</div>
      <h2>Smart homes built for <em>here,</em> not elsewhere.</h2>
      <p class="body-text">Most smart home technology is designed for stable power grids, temperate climates, and high-speed internet — none of which describe the average West African home. 7ai Smart Home changes that.</p>
      <p class="body-text">We design and install AI-powered home systems that work with erratic power supply, high temperatures, intermittent connectivity, and the security challenges specific to our communities.</p>
      <p class="body-text">Whether you live in a flat in Lagos, a compound in Accra, or a gated estate in Abuja — we build intelligent homes that serve your life, not the other way around.</p>
    </div>
    <div class="feature-list">
      @forelse($features as $f)
      <div class="feature-item">
        <div class="feature-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
        <div>
          <div class="feature-title">{{ $f->title }}</div>
          <div class="feature-desc">{{ $f->description }}</div>
        </div>
      </div>
      @empty
      <div class="feature-item"><div class="feature-num">01</div><div><div class="feature-title">AI-powered security</div><div class="feature-desc">Smart cameras, motion detection, facial recognition entry, and real-time alerts — all managed from your phone. Works even on low bandwidth.</div></div></div>
      <div class="feature-item"><div class="feature-num">02</div><div><div class="feature-title">Smart energy management</div><div class="feature-desc">AI that learns your power usage, optimises inverter and solar systems, and cuts your electricity bill.</div></div></div>
      <div class="feature-item"><div class="feature-num">03</div><div><div class="feature-title">Intelligent climate control</div><div class="feature-desc">Smart AC and fan control that adjusts to your schedule and the outside temperature — keeping you comfortable without wasting power.</div></div></div>
      <div class="feature-item"><div class="feature-num">04</div><div><div class="feature-title">Voice &amp; app control</div><div class="feature-desc">Control lights, locks, appliances, and gates from one app or with your voice — in English or local language commands.</div></div></div>
      <div class="feature-item"><div class="feature-num">05</div><div><div class="feature-title">Smart water &amp; utilities</div><div class="feature-desc">Automated borehole pumps, water level monitoring, and leak detection — so you never run dry or waste water again.</div></div></div>
      @endforelse
    </div>
  </div>
</section>

<!-- USE CASES -->
<section class="fe-section bg-navy-deep">
  <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">Real-world use cases</span></div>
  <h2>What it looks like<br><em>in practice.</em></h2>
  <div class="use-cases-grid">
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">The family home</div><p class="uc-desc">Smart locks that let your children in after school, security cameras you can check from work, and an AI that switches off appliances when the solar battery gets low.</p></div>
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">The gated estate</div><p class="uc-desc">Estate-wide access control, visitor management, CCTV with AI motion alerts, and communal energy monitoring — all on one dashboard.</p></div>
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">The rental property</div><p class="uc-desc">Remote-managed smart locks for tenant access, utility monitoring, and automated notifications when something needs attention.</p></div>
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">The home office</div><p class="uc-desc">Backup power intelligence, smart lighting that reduces eye strain, and AI-assisted scheduling for your home workspace.</p></div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="fe-section bg-navy-mid">
  <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">How it works</span></div>
  <h2>From consultation<br><em>to completion.</em></h2>
  <div class="steps-grid">
    <div class="step-card"><div class="step-num">01</div><div class="step-title">Free consultation</div><p class="step-desc">We visit your home or speak with you remotely to understand your needs, your infrastructure, and your budget.</p></div>
    <div class="step-card"><div class="step-num">02</div><div class="step-title">Custom design</div><p class="step-desc">We design a smart home plan tailored to your space — no off-the-shelf packages, everything is mapped to your actual home.</p></div>
    <div class="step-card"><div class="step-num">03</div><div class="step-title">Professional installation</div><p class="step-desc">Our certified technicians install and configure everything, including app setup and testing across all your devices.</p></div>
    <div class="step-card"><div class="step-num">04</div><div class="step-title">Training &amp; handover</div><p class="step-desc">We walk every household member through the system so everyone knows how to use it comfortably and confidently.</p></div>
    <div class="step-card"><div class="step-num">05</div><div class="step-title">Ongoing support</div><p class="step-desc">Remote monitoring, software updates, and a support line — so your system keeps working long after we've left.</p></div>
  </div>
</section>

<!-- FAQ -->
<section class="fe-section bg-navy">
  <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">Common questions</span></div>
  <h2>What people<br><em>ask us most.</em></h2>
  <div class="faq-list">
    @forelse($faqs as $faq)
    <div class="faq-item {{ $loop->first ? 'open' : '' }}">
      <div class="faq-q" onclick="toggleFaq(this)">{{ $faq->question }}<span class="faq-icon">{{ $loop->first ? '−' : '+' }}</span></div>
      <div class="faq-a">{{ $faq->answer }}</div>
    </div>
    @empty
    <div class="faq-item open">
      <div class="faq-q" onclick="toggleFaq(this)">Does it work when there is no light (power outage)?<span class="faq-icon">−</span></div>
      <div class="faq-a">Yes. Our systems are designed specifically for intermittent power. Core security and smart features run on battery backup and integrate with your inverter or solar setup.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">How much does it cost?<span class="faq-icon">+</span></div>
      <div class="faq-a">Costs vary depending on the size of your home and what you want to automate. We offer packages starting from entry-level setups to full smart home integrations. Contact us for a free consultation and personalised quote.</div>
    </div>
    @endforelse
  </div>
</section>

<!-- CTA STRIP -->
<div class="cta-strip">
  <div>
    <h2>Ready to make your home<br><em>work for you?</em></h2>
    <p>Book a free consultation — we'll assess your home and design a smart solution that fits your life and your budget.</p>
  </div>
  <a href="{{ route('contact') }}" class="btn-dark">Book free consultation →</a>
</div>

<!-- ALSO EXPLORE -->
<div class="also-section">
  <h3>Also from 7ai</h3>
  <div class="also-grid">
    <a href="{{ route('business-automation') }}" class="also-card">
      <div class="also-label">7ai Build</div>
      <div class="also-title">Business Automation</div>
      <p class="also-desc">AI automation for African businesses — reducing manual work and cutting costs.</p>
      <span class="also-arrow">Explore →</span>
    </a>
    <a href="{{ route('personal-ai') }}" class="also-card">
      <div class="also-label">7ai Learn</div>
      <div class="also-title">Personal AI</div>
      <p class="also-desc">Practical AI skills training for individuals ready to work smarter.</p>
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
