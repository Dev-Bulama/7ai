<x-app-layout :title="$page?->seo_title ?? '7ai Smart Home — Intelligent Living for Africa'" :description="$page?->seo_description ?? 'Complete smart home automation systems tailored for African homes and climates.'">

<!-- HERO -->
<div class="page-hero page-hero-navy">
  <div class="hero-ghost" style="color:rgba(168,205,184,0.05);font-size:clamp(100px,16vw,280px);">Home</div>
  <div class="hero-inner">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a><span>/</span>
      <a href="{{ route('home') }}#pillars">7ai Build</a><span>/</span>
      <strong>Smart Home</strong>
    </div>
    <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">7ai Build — Smart Home</span></div>
    <h1>{!! $page?->hero_title ? nl2br(e($page->hero_title)) : 'Your home,<br><em>intelligently controlled.</em>' !!}</h1>
    <p class="hero-sub-text">{{ $page?->hero_description ?? "Africa's most comprehensive smart home platform — seamlessly connecting every device, system, and space in your home." }}</p>
    <div class="hero-actions">
      <a href="{{ route('contact') }}" class="btn-primary">Book home assessment</a>
      <a href="#features" class="btn-ghost">See all features</a>
    </div>
  </div>
</div>

<!-- FEATURES -->
<section class="fe-section bg-navy-mid" id="features">
  <div class="two-col">
    <div>
      <div class="section-label">What's included</div>
      <h2>Nine systems.<br><em>One intelligent home.</em></h2>
      <p class="body-text">Every 7ai smart home integrates seamlessly across lighting, security, energy, climate, and more — controlled from a single app, voice command, or automated by AI.</p>
      <p class="body-text">Designed for African conditions: our systems handle power fluctuations, intermittent connectivity, and local climate — without compromise.</p>
      <a href="{{ route('contact') }}" class="btn-primary" style="margin-top:12px;display:inline-flex;">Get a free quote →</a>
    </div>
    <div class="feature-list">
      <div class="feature-item">
        <div class="feature-num">01</div>
        <div><div class="feature-title">Smart Lighting</div><div class="feature-desc">Adaptive brightness and colour that cuts energy use by up to 60%. Schedules, scenes, and motion-activated modes.</div></div>
      </div>
      <div class="feature-item">
        <div class="feature-num">02</div>
        <div><div class="feature-title">AI Security</div><div class="feature-desc">Facial recognition, 4K cameras, motion analytics, and real-time mobile alerts. 24/7 protection, locally stored.</div></div>
      </div>
      <div class="feature-item">
        <div class="feature-num">03</div>
        <div><div class="feature-title">Smart Energy</div><div class="feature-desc">Solar + battery integration with automatic load-shedding protection. Track consumption in real time.</div></div>
      </div>
      <div class="feature-item">
        <div class="feature-num">04</div>
        <div><div class="feature-title">Climate Control</div><div class="feature-desc">AI-driven HVAC management adapted for African climates. Set comfort profiles and let the system handle it.</div></div>
      </div>
      <div class="feature-item">
        <div class="feature-num">05</div>
        <div><div class="feature-title">Smart Access</div><div class="feature-desc">Biometric locks, video doorbells, and remote access management. Grant access from your phone, anywhere.</div></div>
      </div>
      <div class="feature-item">
        <div class="feature-num">06</div>
        <div><div class="feature-title">Voice Automation</div><div class="feature-desc">Native support for English, French, Swahili, Hausa, Yoruba, Zulu, and more African languages.</div></div>
      </div>
    </div>
  </div>
</section>

<!-- MORE SYSTEMS -->
<section class="fe-section bg-navy-deep">
  <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">Full ecosystem</span></div>
  <h2>Complete smart<br><em>home ecosystem.</em></h2>
  <div class="sectors-grid">
    <div class="sector-card">
      <div class="sector-accent"></div>
      <div class="sector-title">IoT Integration</div>
      <p class="sector-desc">Connect 500+ compatible devices across Zigbee, Z-Wave, Wi-Fi, and Matter protocols.</p>
    </div>
    <div class="sector-card">
      <div class="sector-accent"></div>
      <div class="sector-title">AI Assistants</div>
      <p class="sector-desc">Your personal AI learns daily patterns, automates routines, sends reminders, and proactively manages home systems.</p>
    </div>
    <div class="sector-card">
      <div class="sector-accent"></div>
      <div class="sector-title">Smart Surveillance</div>
      <p class="sector-desc">4K cameras with person and vehicle detection, package monitoring, and 30-day cloud or local storage.</p>
    </div>
    <div class="sector-card">
      <div class="sector-accent"></div>
      <div class="sector-title">Power Management</div>
      <p class="sector-desc">Intelligent load balancing protects appliances during outages and automatically switches to battery or solar.</p>
    </div>
    <div class="sector-card">
      <div class="sector-accent"></div>
      <div class="sector-title">Water Intelligence</div>
      <p class="sector-desc">Automated pump management, leak detection, and consumption tracking for boreholes and tanks.</p>
    </div>
    <div class="sector-card">
      <div class="sector-accent"></div>
      <div class="sector-title">Home App</div>
      <p class="sector-desc">One app controls everything — live feeds, energy stats, guest access, and automations from your phone.</p>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="fe-section bg-navy-mid">
  <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">Process</span></div>
  <h2>From assessment<br><em>to automation.</em></h2>
  <div class="steps-grid">
    <div class="step-card">
      <div class="step-num">01</div>
      <div class="step-title">Free home assessment</div>
      <p class="step-desc">Our team visits your home, assesses your needs, and proposes a tailored smart home plan within 48 hours.</p>
    </div>
    <div class="step-card">
      <div class="step-num">02</div>
      <div class="step-title">Design &amp; planning</div>
      <p class="step-desc">We design your full smart home blueprint — devices, wiring, integration points, and automation flows.</p>
    </div>
    <div class="step-card">
      <div class="step-num">03</div>
      <div class="step-title">Professional installation</div>
      <p class="step-desc">Certified 7ai engineers handle the full installation with minimal disruption to your household.</p>
    </div>
    <div class="step-card">
      <div class="step-num">04</div>
      <div class="step-title">Onboarding &amp; support</div>
      <p class="step-desc">We walk you through your new system and provide 24/7 support via phone, WhatsApp, or the app.</p>
    </div>
  </div>
</section>

<!-- CTA -->
<div class="cta-strip">
  <div>
    <h2>Transform your home<br><em>today.</em></h2>
    <p>Book a free home assessment and get a custom smart home proposal within 48 hours.</p>
  </div>
  <div style="display:flex;flex-direction:column;gap:12px;align-items:flex-start;">
    <a href="{{ route('contact') }}" class="btn-primary">Book free assessment</a>
    <a href="{{ route('pricing') }}" class="btn-ghost">View packages →</a>
  </div>
</div>

<!-- ALSO EXPLORE -->
<div class="also-section">
  <h3>Also explore</h3>
  <div class="also-grid">
    <a href="{{ route('business-automation') }}" class="also-card">
      <div class="also-label">7ai Build</div>
      <div class="also-title">Business Automation</div>
      <p class="also-desc">Practical AI automation for African businesses — customer service, data processing, and more.</p>
      <span class="also-arrow">→</span>
    </a>
    <a href="{{ route('personal-ai') }}" class="also-card">
      <div class="also-label">7ai Learn</div>
      <div class="also-title">Personal AI</div>
      <p class="also-desc">Learn to use AI in your daily life. Free programmes available now.</p>
      <span class="also-arrow">→</span>
    </a>
    <a href="{{ route('pricing') }}" class="also-card">
      <div class="also-label">Packages</div>
      <div class="also-title">Pricing</div>
      <p class="also-desc">Flexible smart home packages from entry level to full whole-home automation.</p>
      <span class="also-arrow">→</span>
    </a>
  </div>
</div>

</x-app-layout>
