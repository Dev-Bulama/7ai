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
@if($teamMembers->isNotEmpty())
<section class="fe-section bg-navy-mid">
  <style>
    .team-grid-about{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:48px;}
    .team-card-about{background:#0a1628;border-radius:16px;overflow:hidden;position:relative;transition:transform .3s ease,box-shadow .3s ease;cursor:default;}
    .team-card-about:hover{transform:translateY(-6px);box-shadow:0 24px 60px rgba(0,0,0,0.5);}
    .team-photo-wrap-about{aspect-ratio:3/4;overflow:hidden;position:relative;background:linear-gradient(160deg,#0d1f3c 0%,#1a2f4a 100%);}
    .team-photo-img-about{width:100%;height:100%;object-fit:cover;object-position:top center;display:block;transition:transform .5s ease;}
    .team-card-about:hover .team-photo-img-about{transform:scale(1.04);}
    .team-photo-placeholder-about{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:clamp(36px,6vw,56px);font-weight:700;color:rgba(122,174,142,0.6);background:linear-gradient(160deg,#0d1f3c 0%,#1a3a2a 100%);}
    .team-featured-badge-about{position:absolute;top:12px;right:12px;background:rgba(122,174,142,0.9);color:#0a1628;font-family:'DM Mono',monospace;font-size:8px;letter-spacing:0.14em;text-transform:uppercase;padding:4px 10px;border-radius:20px;font-weight:600;backdrop-filter:blur(4px);}
    .team-overlay-about{position:absolute;bottom:0;left:0;right:0;background:linear-gradient(to top,rgba(10,22,40,0.98) 0%,rgba(10,22,40,0.7) 60%,transparent 100%);padding:28px 20px 20px;}
    .team-name-about{font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:#fff;line-height:1.2;margin-bottom:4px;}
    .team-title-about{font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.16em;text-transform:uppercase;color:rgba(122,174,142,0.9);margin-bottom:3px;}
    .team-sub-about{font-size:11px;color:rgba(255,255,255,0.45);font-weight:300;margin-bottom:10px;}
    .team-socials-about{display:flex;gap:10px;margin-top:8px;}
    .team-socials-about a{display:flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:rgba(122,174,142,0.15);border:1px solid rgba(122,174,142,0.3);color:rgba(122,174,142,0.8);transition:background .2s,color .2s;}
    .team-socials-about a:hover{background:rgba(122,174,142,0.3);color:#fff;}
    .team-socials-about svg{width:13px;height:13px;fill:currentColor;}
    @media(max-width:1100px){.team-grid-about{grid-template-columns:repeat(3,1fr);}}
    @media(max-width:720px){.team-grid-about{grid-template-columns:repeat(2,1fr);gap:14px;}}
    @media(max-width:480px){.team-grid-about{grid-template-columns:repeat(2,1fr);gap:10px;}}
  </style>
  <div class="section-header">
    <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">The team</span></div>
    <h2>The minds<br><em>behind 7ai.</em></h2>
    <p class="section-sub">A diverse team of engineers, strategists, and innovators united by one vision for Africa.</p>
  </div>
  <div class="team-grid-about">
    @foreach($teamMembers as $member)
    <div class="team-card-about">
      <div class="team-photo-wrap-about">
        @if($member->photo_url)
          <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="team-photo-img-about">
        @else
          <div class="team-photo-placeholder-about">{{ $member->initials }}</div>
        @endif
        @if($member->is_featured)
          <span class="team-featured-badge-about">Featured</span>
        @endif
        <div class="team-overlay-about">
          <div class="team-name-about">{{ $member->name }}</div>
          @if($member->job_title)<div class="team-title-about">{{ $member->job_title }}</div>@endif
          @if($member->subtitle)<div class="team-sub-about">{{ $member->subtitle }}</div>@endif
          @if($member->linkedin || $member->twitter || $member->github || $member->instagram)
          <div class="team-socials-about">
            @if($member->linkedin)
            <a href="{{ $member->linkedin }}" target="_blank" rel="noopener" title="LinkedIn">
              <svg viewBox="0 0 24 24"><path d="M20.447 20.452H17.21v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.985V9h3.085v1.561h.046c.43-.815 1.48-1.674 3.048-1.674 3.259 0 3.862 2.145 3.862 4.932v6.633zM5.337 7.433a1.79 1.79 0 1 1 0-3.58 1.79 1.79 0 0 1 0 3.58zm1.543 13.019H3.794V9h3.086v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
            </a>
            @endif
            @if($member->twitter)
            <a href="{{ $member->twitter }}" target="_blank" rel="noopener" title="X / Twitter">
              <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.74l7.73-8.835L1.254 2.25H8.08l4.259 5.63L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z"/></svg>
            </a>
            @endif
            @if($member->github)
            <a href="{{ $member->github }}" target="_blank" rel="noopener" title="GitHub">
              <svg viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
            </a>
            @endif
            @if($member->instagram)
            <a href="{{ $member->instagram }}" target="_blank" rel="noopener" title="Instagram">
              <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
            </a>
            @endif
          </div>
          @endif
        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>
@endif

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
    <h2>{{ $heroCta?->title ?? 'Join the 7ai' }}<br><em>{{ $heroCta?->text ? '' : 'movement.' }}</em></h2>
    @if($heroCta?->text)
    <p>{{ $heroCta->text }}</p>
    @else
    <p>Work with us, partner with us, or let us transform your home or business. Africa's intelligence era starts now.</p>
    @endif
  </div>
  <div style="display:flex;flex-direction:column;gap:12px;align-items:flex-start;">
    <a href="{{ $heroCta?->button_url ?: route('contact') }}" class="btn-primary">{{ $heroCta?->button_label ?? 'Get in touch' }}</a>
    @if($heroCta?->button2_url || true)
    <a href="{{ $heroCta?->button2_url ?: route('careers') }}" class="btn-ghost">{{ $heroCta?->button2_label ?? 'View careers →' }}</a>
    @endif
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
