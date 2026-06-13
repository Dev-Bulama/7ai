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
<section style="padding:100px 6vw;background:#060e1c;">
  <div style="max-width:1240px;margin:0 auto;">
    <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:24px;margin-bottom:64px;">
      <div>
        <div style="display:inline-flex;align-items:center;gap:10px;margin-bottom:16px;">
          <div style="width:28px;height:1px;background:#3ee07f;"></div>
          <span style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:#3ee07f;">Our team</span>
        </div>
        <h2 style="font-family:'Playfair Display',serif;font-size:clamp(32px,4.5vw,52px);font-weight:900;color:#fff;line-height:1.05;margin:0;">Meet the minds<br><em style="color:rgba(168,205,184,0.85);">building 7ai.</em></h2>
        <p style="font-size:16px;font-weight:300;color:rgba(255,255,255,0.5);margin:16px 0 0;max-width:500px;line-height:1.7;">Passionate engineers, strategists, and innovators united by one vision — Africa's AI future.</p>
      </div>
      <a href="{{ route('about') }}" style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.15em;text-transform:uppercase;color:#3ee07f;text-decoration:none;border:0.5px solid rgba(62,224,127,0.3);padding:12px 20px;border-radius:2px;white-space:nowrap;transition:all 0.2s;" onmouseover="this.style.background='rgba(62,224,127,0.08)'" onmouseout="this.style.background='transparent'">View Full Team →</a>
    </div>

    {{-- Responsive portrait grid --}}
    <div class="team-grid-home">
      @foreach($teamMembers as $member)
      <div class="team-card-home">
        {{-- Portrait photo area --}}
        <div class="team-photo-wrap">
          @if($member->photo_url)
          <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" loading="lazy" class="team-photo-img">
          @else
          <div class="team-photo-placeholder">
            <span>{{ $member->initials }}</span>
          </div>
          @endif
          @if($member->is_featured)
          <div class="team-featured-badge">Featured</div>
          @endif
        </div>
        {{-- Info --}}
        <div class="team-card-info">
          <div class="team-card-name">{{ $member->name }}</div>
          @if($member->job_title)
          <div class="team-card-title">{{ $member->job_title }}</div>
          @endif
          @if($member->subtitle)
          <div class="team-card-sub">{{ Str::limit($member->subtitle, 60) }}</div>
          @endif
          @if($member->linkedin || $member->twitter || $member->github || $member->instagram)
          <div class="team-card-socials">
            @if($member->linkedin)
            <a href="{{ $member->linkedin }}" target="_blank" rel="noopener" title="LinkedIn" class="team-social-link">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
            </a>
            @endif
            @if($member->twitter)
            <a href="{{ $member->twitter }}" target="_blank" rel="noopener" title="X / Twitter" class="team-social-link">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
            @endif
            @if($member->github)
            <a href="{{ $member->github }}" target="_blank" rel="noopener" title="GitHub" class="team-social-link">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22"/></svg>
            </a>
            @endif
            @if($member->instagram)
            <a href="{{ $member->instagram }}" target="_blank" rel="noopener" title="Instagram" class="team-social-link">
              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
            </a>
            @endif
          </div>
          @endif
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<style>
.team-grid-home{display:grid;grid-template-columns:repeat(4,1fr);gap:2px;}
.team-card-home{background:#0a1628;overflow:hidden;transition:transform 0.3s;}
.team-card-home:hover{transform:translateY(-4px);}
.team-photo-wrap{position:relative;width:100%;aspect-ratio:3/4;overflow:hidden;background:rgba(122,174,142,0.05);}
.team-photo-img{width:100%;height:100%;object-fit:cover;object-position:top center;display:block;transition:transform 0.5s;}
.team-card-home:hover .team-photo-img{transform:scale(1.04);}
.team-photo-placeholder{width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(160deg,#0b2640 0%,#0b4f6c 100%);}
.team-photo-placeholder span{font-family:'DM Mono',monospace;font-size:clamp(28px,4vw,48px);font-weight:600;color:rgba(122,174,142,0.6);}
.team-featured-badge{position:absolute;top:12px;right:12px;background:rgba(62,224,127,0.15);border:0.5px solid rgba(62,224,127,0.4);color:#3ee07f;font-family:'DM Mono',monospace;font-size:8px;letter-spacing:0.15em;text-transform:uppercase;padding:4px 8px;border-radius:2px;}
.team-card-info{padding:20px 18px 24px;}
.team-card-name{font-family:'Playfair Display',serif;font-size:17px;font-weight:700;color:#fff;margin-bottom:5px;line-height:1.2;}
.team-card-title{font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.16em;text-transform:uppercase;color:#7aae8e;margin-bottom:6px;}
.team-card-sub{font-size:12px;font-weight:300;color:rgba(255,255,255,0.45);line-height:1.5;margin-bottom:12px;}
.team-card-socials{display:flex;gap:10px;align-items:center;}
.team-social-link{color:rgba(255,255,255,0.35);transition:color 0.2s;display:flex;align-items:center;}
.team-social-link:hover{color:#3ee07f;}
@media(max-width:1024px){.team-grid-home{grid-template-columns:repeat(3,1fr);}}
@media(max-width:720px){.team-grid-home{grid-template-columns:repeat(2,1fr);}}
@media(max-width:480px){.team-grid-home{grid-template-columns:1fr 1fr;gap:1px;}}
</style>
@endif

</x-app-layout>
