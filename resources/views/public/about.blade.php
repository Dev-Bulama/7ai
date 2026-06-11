<x-app-layout :title="$page?->seo_title ?? 'About 7ai — African Intelligence, Amplified'" :description="$page?->seo_description ?? 'We are a team of engineers, designers, and technologists building intelligent solutions for Africa.'">

<!-- HERO -->
<div class="page-hero page-hero-navy">
  <div class="hero-ghost" style="color:rgba(168,205,184,0.05);font-size:clamp(140px,20vw,320px);">7ai</div>
  <div class="hero-inner">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a><span>/</span>
      <strong>About</strong>
    </div>
    <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">Our story</span></div>
    <h1>{!! $page?->hero_title ? nl2br(e($page->hero_title)) : 'Built for Africa\'s<br><em>AI future.</em>' !!}</h1>
    <p class="hero-sub-text">{{ $page?->hero_description ?? 'We founded 7ai with a single belief: Africa deserves world-class intelligence technology built specifically for its communities, climates, and aspirations.' }}</p>
  </div>
</div>

<!-- MISSION -->
<section class="fe-section bg-navy-mid">
  <div class="two-col">
    <div>
      <div class="section-label">Mission</div>
      <h2>Amplifying African<br><em>intelligence at scale.</em></h2>
      <p class="body-text">7ai was founded with a clear purpose: to build intelligent technology infrastructure that works for Africa — not technology retrofitted from elsewhere and forced to fit.</p>
      <p class="body-text">From smart home automation in Lagos apartments to AI-powered advisory for businesses in Nairobi, we design solutions that understand Africa's unique infrastructure, connectivity challenges, and opportunities.</p>
      <p class="body-text">We are engineers, designers, and problem-solvers committed to one outcome: making African homes, businesses, and communities more intelligent, more efficient, and more resilient.</p>
    </div>
    <div class="feature-list">
      <div class="feature-item">
        <div class="feature-num">01</div>
        <div><div class="feature-title">Build</div><div class="feature-desc">Africa-first AI products and smart home solutions built for African contexts, languages, and challenges.</div></div>
      </div>
      <div class="feature-item">
        <div class="feature-num">02</div>
        <div><div class="feature-title">Learn</div><div class="feature-desc">Structured AI training pathways for individuals, teams, and government — practical, accessible, Africa-built.</div></div>
      </div>
      <div class="feature-item">
        <div class="feature-num">03</div>
        <div><div class="feature-title">Advise</div><div class="feature-desc">Strategic guidance for organisations navigating the AI transition. We help leaders understand what AI means for their sector.</div></div>
      </div>
    </div>
  </div>
</section>

<!-- VALUES -->
<section class="fe-section bg-navy-deep">
  <div class="section-header">
    <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">Values</span></div>
    <h2>What we<br><em>stand for.</em></h2>
  </div>
  <div class="sectors-grid">
    <div class="sector-card">
      <div class="sector-accent"></div>
      <div class="sector-title">Africa First</div>
      <p class="sector-desc">Every solution we build is designed with African conditions in mind — climate, connectivity, culture, and community.</p>
    </div>
    <div class="sector-card">
      <div class="sector-accent"></div>
      <div class="sector-title">Trust &amp; Reliability</div>
      <p class="sector-desc">We build systems that work when power fluctuates, when connectivity drops, and when conditions are imperfect.</p>
    </div>
    <div class="sector-card">
      <div class="sector-accent"></div>
      <div class="sector-title">Long-Term Impact</div>
      <p class="sector-desc">We measure success by the lasting positive change we create in communities, not just by client contracts signed.</p>
    </div>
    <div class="sector-card">
      <div class="sector-accent"></div>
      <div class="sector-title">Talent Development</div>
      <p class="sector-desc">We actively build Africa's AI talent pipeline — training engineers, partnering with universities, and creating opportunities.</p>
    </div>
    <div class="sector-card">
      <div class="sector-accent"></div>
      <div class="sector-title">Open &amp; Transparent</div>
      <p class="sector-desc">Honest pricing, clear communication, and genuine partnerships — not vendor lock-in relationships.</p>
    </div>
    <div class="sector-card">
      <div class="sector-accent"></div>
      <div class="sector-title">Innovation</div>
      <p class="sector-desc">We push the boundaries of what's possible — researching, experimenting, and deploying technology that matters.</p>
    </div>
  </div>
</section>

<!-- TEAM -->
<section class="fe-section bg-navy-mid">
  <div class="section-header">
    <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">The team</span></div>
    <h2>The minds<br><em>behind 7ai.</em></h2>
    <p class="section-sub">A diverse team of engineers, strategists, and innovators united by one vision for Africa.</p>
  </div>
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:2px;background:var(--border-sage);border:0.5px solid var(--border-sage);border-radius:4px;overflow:hidden;">
    <div style="background:var(--navy-deep);padding:36px 28px;text-align:center;">
      <div style="width:64px;height:64px;border-radius:50%;background:rgba(122,174,142,0.15);border:1px solid var(--border-sage);display:flex;align-items:center;justify-content:center;font-family:'DM Mono',monospace;font-size:16px;font-weight:500;color:var(--sage-light);margin:0 auto 20px;">AO</div>
      <div style="font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--white);margin-bottom:6px;">Adaeze Obi</div>
      <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.16em;text-transform:uppercase;color:var(--sage);margin-bottom:4px;">Co-Founder &amp; CEO</div>
      <div style="font-size:12px;font-weight:300;color:var(--text-muted);">Lagos, Nigeria</div>
    </div>
    <div style="background:var(--navy-deep);padding:36px 28px;text-align:center;">
      <div style="width:64px;height:64px;border-radius:50%;background:rgba(122,174,142,0.15);border:1px solid var(--border-sage);display:flex;align-items:center;justify-content:center;font-family:'DM Mono',monospace;font-size:16px;font-weight:500;color:var(--sage-light);margin:0 auto 20px;">KA</div>
      <div style="font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--white);margin-bottom:6px;">Kofi Asante</div>
      <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.16em;text-transform:uppercase;color:var(--sage);margin-bottom:4px;">Co-Founder &amp; CTO</div>
      <div style="font-size:12px;font-weight:300;color:var(--text-muted);">Accra, Ghana</div>
    </div>
    <div style="background:var(--navy-deep);padding:36px 28px;text-align:center;">
      <div style="width:64px;height:64px;border-radius:50%;background:rgba(122,174,142,0.15);border:1px solid var(--border-sage);display:flex;align-items:center;justify-content:center;font-family:'DM Mono',monospace;font-size:16px;font-weight:500;color:var(--sage-light);margin:0 auto 20px;">FN</div>
      <div style="font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--white);margin-bottom:6px;">Fatima Njoroge</div>
      <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.16em;text-transform:uppercase;color:var(--sage);margin-bottom:4px;">VP of Engineering</div>
      <div style="font-size:12px;font-weight:300;color:var(--text-muted);">Nairobi, Kenya</div>
    </div>
    <div style="background:var(--navy-deep);padding:36px 28px;text-align:center;">
      <div style="width:64px;height:64px;border-radius:50%;background:rgba(122,174,142,0.15);border:1px solid var(--border-sage);display:flex;align-items:center;justify-content:center;font-family:'DM Mono',monospace;font-size:16px;font-weight:500;color:var(--sage-light);margin:0 auto 20px;">TM</div>
      <div style="font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--white);margin-bottom:6px;">Themba Mokoena</div>
      <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.16em;text-transform:uppercase;color:var(--sage);margin-bottom:4px;">Head of AI Research</div>
      <div style="font-size:12px;font-weight:300;color:var(--text-muted);">Johannesburg, SA</div>
    </div>
  </div>
</section>

<!-- STATS -->
<section class="fe-section bg-navy">
  <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">Our impact</span></div>
  <h2 style="margin-bottom:60px;">7ai by<br><em>the numbers.</em></h2>
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:2px;background:var(--border-sage);border:0.5px solid var(--border-sage);border-radius:4px;overflow:hidden;">
    <div style="background:var(--navy-mid);padding:40px 28px;">
      <div style="font-family:'Playfair Display',serif;font-size:56px;font-weight:900;color:var(--white);line-height:1;">500<span style="color:var(--sage-light);">+</span></div>
      <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.16em;text-transform:uppercase;color:var(--sage);margin-top:12px;">Homes automated</div>
    </div>
    <div style="background:var(--navy-mid);padding:40px 28px;">
      <div style="font-family:'Playfair Display',serif;font-size:56px;font-weight:900;color:var(--white);line-height:1;">120<span style="color:var(--sage-light);">+</span></div>
      <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.16em;text-transform:uppercase;color:var(--sage);margin-top:12px;">Business clients</div>
    </div>
    <div style="background:var(--navy-mid);padding:40px 28px;">
      <div style="font-family:'Playfair Display',serif;font-size:56px;font-weight:900;color:var(--white);line-height:1;">12<span style="color:var(--sage-light);">+</span></div>
      <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.16em;text-transform:uppercase;color:var(--sage);margin-top:12px;">African countries</div>
    </div>
    <div style="background:var(--navy-mid);padding:40px 28px;">
      <div style="font-family:'Playfair Display',serif;font-size:56px;font-weight:900;color:var(--white);line-height:1;">98<span style="color:var(--sage-light);">%</span></div>
      <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.16em;text-transform:uppercase;color:var(--sage);margin-top:12px;">Client satisfaction</div>
    </div>
  </div>
</section>

<!-- CTA -->
<div class="cta-strip">
  <div>
    <h2>Join the 7ai<br><em>movement.</em></h2>
    <p>Work with us, partner with us, or let us transform your home or business. Africa's intelligence era starts now.</p>
  </div>
  <div style="display:flex;flex-direction:column;gap:12px;align-items:flex-start;">
    <a href="{{ route('contact') }}" class="btn-primary">Get in touch</a>
    <a href="{{ route('careers') }}" class="btn-ghost">View careers →</a>
  </div>
</div>

<!-- ALSO EXPLORE -->
<div class="also-section">
  <h3>Also explore</h3>
  <div class="also-grid">
    <a href="{{ route('smart-homes') }}" class="also-card">
      <div class="also-label">7ai Build</div>
      <div class="also-title">Smart Home</div>
      <p class="also-desc">Intelligent automation for African homes — lighting, security, energy, and more.</p>
      <span class="also-arrow">→</span>
    </a>
    <a href="{{ route('business-automation') }}" class="also-card">
      <div class="also-label">7ai Build</div>
      <div class="also-title">Business Automation</div>
      <p class="also-desc">Practical AI automation that reduces manual work and gives your team time back.</p>
      <span class="also-arrow">→</span>
    </a>
    <a href="{{ route('advisory') }}" class="also-card">
      <div class="also-label">7ai Advise</div>
      <div class="also-title">Advisory</div>
      <p class="also-desc">Strategic guidance for organisations navigating Africa's AI transition.</p>
      <span class="also-arrow">→</span>
    </a>
  </div>
</div>

</x-app-layout>
