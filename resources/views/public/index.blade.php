<x-app-layout :title="$page?->seo_title ?? ($settings['site_name'].' — Powering Africa\'s AI Transition')" :description="$page?->seo_description ?? $settings['site_tagline']">

<!-- HERO -->
<section class="hero" id="home">
  <div class="hero-bg-number">7</div>
  <div class="hero-inner">
    <div class="eyebrow-row">
      <div class="eyebrow-line"></div>
      <span class="eyebrow-text">West Africa · AI Transition</span>
    </div>
    <h1 class="hero-headline">
      {!! $page?->hero_title ? nl2br(e($page->hero_title)) : 'Powering<br>Africa\'s<br><em>AI transition.</em>' !!}
    </h1>
    <p class="hero-sub">{{ $page?->hero_description ?? 'From the smart home to the boardroom to the policy table — 7ai places the tools, knowledge, and strategy of the AI era in African hands.' }}</p>
    <div class="hero-actions">
      <a href="#training" class="btn-primary">{{ $page?->cta_text ?? 'Start learning free' }}</a>
      <a href="#pillars" class="btn-ghost">What we do</a>
    </div>
    <div class="hero-stats">
      <div>
        <div class="stat-num">3<span>+</span></div>
        <div class="stat-label">Service pillars</div>
      </div>
      <div>
        <div class="stat-num">7<span>.</span></div>
        <div class="stat-label">Whole cycle thinking</div>
      </div>
      <div>
        <div class="stat-num">100<span>%</span></div>
        <div class="stat-label">Africa-first</div>
      </div>
    </div>
  </div>
</section>

<!-- PILLARS -->
<section class="fe-section bg-navy-mid" id="pillars">
  <div class="section-header">
    <div class="eyebrow-row">
      <div class="eyebrow-line"></div>
      <span class="eyebrow-text">What we do</span>
    </div>
    <h2 class="section-title">Three pillars.<br><em>One mission.</em></h2>
    <p class="section-sub">Every product, programme, and advisory we offer connects back to a single purpose — making Africa ready for the AI era.</p>
  </div>
  <div class="pillars-grid">
    <div class="pillar-card">
      <div class="pillar-accent"></div>
      <div class="pillar-icon">01 — Build</div>
      <div class="pillar-name">7ai Build</div>
      <div class="pillar-tag">AI Tools & Products</div>
      <p class="pillar-desc">Africa-first AI products built for the contexts, languages, and challenges that matter on the ground. From smart home solutions to enterprise automation tools.</p>
      <a href="{{ route('smart-home') }}" class="pillar-learn">Learn more →</a>
    </div>
    <div class="pillar-card">
      <div class="pillar-accent"></div>
      <div class="pillar-icon">02 — Learn</div>
      <div class="pillar-name">7ai Learn</div>
      <div class="pillar-tag">Education & Training</div>
      <p class="pillar-desc">Structured pathways from AI-curious to AI-capable — for individuals, businesses, and government teams. Practical, accessible, and built for African contexts.</p>
      <a href="{{ route('personal-ai') }}" class="pillar-learn">Explore training →</a>
    </div>
    <div class="pillar-card">
      <div class="pillar-accent"></div>
      <div class="pillar-icon">03 — Advise</div>
      <div class="pillar-name">7ai Advise</div>
      <div class="pillar-tag">Consulting & Advisory</div>
      <p class="pillar-desc">Strategic guidance for organisations navigating the AI transition. We help leaders understand what AI means for their sector and how to act decisively.</p>
      <a href="{{ route('advisory') }}" class="pillar-learn">Work with us →</a>
    </div>
  </div>
</section>

<!-- MISSION STRIP -->
<div class="mission-strip" id="mission">
  <div class="mission-seven">7</div>
  <div>
    <div class="mission-label">Why 7</div>
    <p class="mission-quote">In many African traditions, seven represents <em>wholeness</em> — the complete cycle.</p>
    <p class="mission-body">7ai is named for that wholeness. We don't serve just one audience or one need. We serve the full arc of Africa's AI transition — individuals, businesses, institutions — because the opportunity is too large and too important to approach in pieces.</p>
  </div>
</div>

<!-- TRAINING -->
<section class="training-section" id="training">
  <div class="section-header">
    <div class="eyebrow-row">
      <div class="eyebrow-line" style="background:#3a7a58;"></div>
      <span class="eyebrow-text" style="color:#3a7a58;">7ai Learn</span>
    </div>
    <h2 class="section-title">AI training built<br><em style="color:#3a7a58;">for you.</em></h2>
    <p class="section-sub">Practical AI skills you can apply immediately — whether you're an individual, a team, or a decision-maker.</p>
  </div>
  <div class="training-grid">
    <div class="training-modules">
      <div class="training-module">
        <div class="module-num">01</div>
        <div><div class="module-title">Personal AI productivity</div><div class="module-desc">Use AI to work faster, think clearer, and do more every day.</div></div>
      </div>
      <div class="training-module">
        <div class="module-num">02</div>
        <div><div class="module-title">Business automation</div><div class="module-desc">Discover how AI can streamline your operations and cut costs.</div></div>
      </div>
      <div class="training-module">
        <div class="module-num">03</div>
        <div><div class="module-title">Smart home setup</div><div class="module-desc">Make your home intelligent, efficient, and secure with AI.</div></div>
      </div>
      <div class="training-module">
        <div class="module-num">04</div>
        <div><div class="module-title">AI for leaders &amp; policy</div><div class="module-desc">Understand AI's implications for governance, strategy, and decision-making.</div></div>
      </div>
    </div>
    <div class="training-right">
      <div class="training-cta-ghost">AI</div>
      <div class="training-cta-label">Get started</div>
      <h3 class="training-cta-headline">Learn AI.<br><em>Start today.</em></h3>
      <p class="training-cta-sub">Join our growing community of Africans building skills for the AI era. Free programmes available now.</p>
      <ul class="training-list">
        <li><span>—</span> Personal productivity</li>
        <li><span>—</span> Business automation</li>
        <li><span>—</span> Smart home setup</li>
        <li><span>—</span> And much more</li>
      </ul>
      <a href="{{ route('personal-ai') }}" class="register-free">Register free →</a>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section class="contact-section" id="contact">
  <div class="contact-inner">
    <div>
      <div class="eyebrow-row">
        <div class="eyebrow-line"></div>
        <span class="eyebrow-text">Get in touch</span>
      </div>
      <h2 class="section-title">Ready to begin<br><em>your transition?</em></h2>
      <p class="section-sub">Whether you want to learn, build, or get strategic advice — we'd love to hear from you.</p>
      <div class="contact-info">
        <div>
          <div class="contact-item-label">Location</div>
          <div class="contact-item-value">{{ $settings['address'] ?: 'West Africa' }}</div>
        </div>
        <div>
          <div class="contact-item-label">Email</div>
          <div class="contact-item-value">{{ $settings['contact_email'] ?: 'hello@7ai.africa' }}</div>
        </div>
        <div>
          <div class="contact-item-label">Training</div>
          <div class="contact-item-value">Register free — programmes available now</div>
        </div>
      </div>
    </div>

    <div>
      @if(session('success'))
      <div class="alert-success">{{ session('success') }}</div>
      @endif
      <form class="contact-form" action="{{ route('contact.submit') }}" method="POST">
        @csrf
        <div class="form-field">
          <label class="form-label">Full name</label>
          <input type="text" name="name" class="form-input" placeholder="Your name" required>
        </div>
        <div class="form-field">
          <label class="form-label">Email address</label>
          <input type="email" name="email" class="form-input" placeholder="you@example.com" required>
        </div>
        <div class="form-field">
          <label class="form-label">I'm interested in</label>
          <select name="subject" class="form-select">
            <option value="">Select one</option>
            <option>AI training (personal)</option>
            <option>Business automation</option>
            <option>Smart home setup</option>
            <option>Advisory &amp; consulting</option>
            <option>Partnership</option>
          </select>
        </div>
        <div class="form-field">
          <label class="form-label">Message (optional)</label>
          <textarea name="message" class="form-textarea" placeholder="Tell us a bit about what you need..."></textarea>
        </div>
        <button type="submit" class="form-submit">Send message →</button>
      </form>
    </div>
  </div>
</section>

@if($teamMembers->isNotEmpty())
<!-- TEAM -->
<section class="fe-section bg-navy-deep" style="padding:80px 6vw;">
  <div style="max-width:1200px;margin:0 auto;">
    <div class="eyebrow-row" style="margin-bottom:16px;"><div class="eyebrow-line"></div><span class="eyebrow-text">Our team</span></div>
    <h2 style="font-family:'Playfair Display',serif;font-size:clamp(28px,4vw,44px);font-weight:900;color:var(--white);margin-bottom:48px;line-height:1.1;">The people<br><em>building 7ai.</em></h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:24px;">
      @foreach($teamMembers as $member)
      <div style="text-align:center;">
        @if($member->photo_url)
        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:2px solid rgba(122,174,142,0.3);margin:0 auto 16px;display:block;">
        @else
        <div style="width:80px;height:80px;border-radius:50%;background:rgba(122,174,142,0.1);border:1px solid rgba(122,174,142,0.3);display:flex;align-items:center;justify-content:center;font-family:'DM Mono',monospace;font-size:18px;font-weight:600;color:var(--sage-light);margin:0 auto 16px;">{{ $member->initials }}</div>
        @endif
        <div style="font-family:'Playfair Display',serif;font-size:16px;font-weight:700;color:var(--white);margin-bottom:4px;">{{ $member->name }}</div>
        @if($member->job_title)
        <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.14em;text-transform:uppercase;color:var(--sage);">{{ $member->job_title }}</div>
        @endif
      </div>
      @endforeach
    </div>
    <div style="text-align:center;margin-top:48px;">
      <a href="{{ route('about') }}" style="font-family:'DM Mono',monospace;font-size:11px;letter-spacing:0.12em;text-transform:uppercase;color:var(--sage-light);text-decoration:none;">Meet the full team →</a>
    </div>
  </div>
</section>
@endif

</x-app-layout>
