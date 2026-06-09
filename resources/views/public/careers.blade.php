<x-app-layout title="{{ $page?->seo_title ?? 'Careers — '.($settings['site_name']) }}" description="{{ $page?->seo_description ?? 'Join the team building Africa\'s intelligent future.' }}">
<div class="page-hero page-hero-dark">
  <div class="section-inner" style="max-width:1280px;margin:0 auto;">
    <div class="section-badge">Careers</div>
    <h1 style="font-size:clamp(36px,4.5vw,60px);font-weight:700;color:#fff;letter-spacing:-0.025em;max-width:700px;line-height:1.1;margin-bottom:20px;">{!! nl2br(e($page?->hero_title ?? "Build Africa's Intelligent Future.")) !!}</h1>
    <p style="font-size:18px;color:rgba(255,255,255,0.7);max-width:520px;line-height:1.7;">{{ $page?->hero_description ?? 'Join a diverse team of engineers, researchers, and innovators working on technology that matters — built by Africans, for Africa.' }}</p>
    <div style="margin-top:32px;display:flex;gap:24px;flex-wrap:wrap;">
      <div style="background:rgba(255,255,255,0.1);border-radius:12px;padding:20px 28px;"><div style="font-size:28px;font-weight:700;color:#fff;">18</div><div style="font-size:13px;color:rgba(255,255,255,0.6);">Open Positions</div></div>
      <div style="background:rgba(255,255,255,0.1);border-radius:12px;padding:20px 28px;"><div style="font-size:28px;font-weight:700;color:#fff;">4</div><div style="font-size:13px;color:rgba(255,255,255,0.6);">Countries</div></div>
      <div style="background:rgba(255,255,255,0.1);border-radius:12px;padding:20px 28px;"><div style="font-size:28px;font-weight:700;color:#fff;">Remote</div><div style="font-size:13px;color:rgba(255,255,255,0.6);">Friendly</div></div>
    </div>
  </div>
</div>

<section class="section section-gray">
  <div class="section-inner">
    <div class="section-header" style="text-align:center;"><div class="section-badge">Why 7AI</div><h2 class="section-title">Why Join Us</h2></div>
    <div class="grid-3">
      <div class="card"><div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div><h3>Mission-Driven Work</h3><p>Every line of code, every system deployed has real impact on African communities. The work matters.</p></div>
      <div class="card"><div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div><h3>Competitive Compensation</h3><p>Market-leading salaries, equity participation, health insurance, and performance bonuses — pan-African scale.</p></div>
      <div class="card"><div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg></div><h3>Flexible & Remote</h3><p>Work from Lagos, Accra, Nairobi, Johannesburg, or anywhere. Results matter, not where you sit.</p></div>
      <div class="card"><div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg></div><h3>Learning & Growth</h3><p>$2,000 annual learning budget, conference attendance, internal training programs, and mentorship from day one.</p></div>
      <div class="card"><div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div><h3>Cutting-Edge Tech</h3><p>Work with state-of-the-art AI, ML, and IoT technology. No legacy systems. Always at the frontier.</p></div>
      <div class="card"><div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/></svg></div><h3>Team Culture</h3><p>A diverse, inclusive team that celebrates African excellence. Flat hierarchy, open communication, high trust.</p></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="section-inner">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:40px;flex-wrap:wrap;gap:16px;">
      <h2 style="font-size:28px;font-weight:700;color:var(--dark);letter-spacing:-0.02em;">Open Positions</h2>
      <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <button style="padding:6px 14px;border-radius:100px;border:1.5px solid var(--teal);background:var(--teal);color:#fff;font-size:13px;font-weight:600;cursor:pointer;">All</button>
        <button style="padding:6px 14px;border-radius:100px;border:1.5px solid var(--gray-200);background:transparent;color:var(--gray-600);font-size:13px;font-weight:600;cursor:pointer;">Engineering</button>
        <button style="padding:6px 14px;border-radius:100px;border:1.5px solid var(--gray-200);background:transparent;color:var(--gray-600);font-size:13px;font-weight:600;cursor:pointer;">AI/ML</button>
        <button style="padding:6px 14px;border-radius:100px;border:1.5px solid var(--gray-200);background:transparent;color:var(--gray-600);font-size:13px;font-weight:600;cursor:pointer;">Design</button>
        <button style="padding:6px 14px;border-radius:100px;border:1.5px solid var(--gray-200);background:transparent;color:var(--gray-600);font-size:13px;font-weight:600;cursor:pointer;">Operations</button>
      </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:16px;">
      <!-- JOB CARDS -->
      <div style="background:var(--white);border:1px solid var(--gray-200);border-radius:16px;padding:28px;display:flex;align-items:center;justify-content:space-between;gap:24px;transition:all 0.2s;flex-wrap:wrap;" onmouseover="this.style.borderColor='var(--teal)';this.style.boxShadow='0 8px 24px rgba(11,79,108,0.08)'" onmouseout="this.style.borderColor='var(--gray-200)';this.style.boxShadow=''">
        <div>
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
            <h3 style="font-size:17px;font-weight:600;color:var(--dark);">Senior AI/ML Engineer</h3>
            <span class="tag green">New</span>
          </div>
          <div style="display:flex;gap:16px;flex-wrap:wrap;">
            <span style="font-size:13px;color:var(--gray-500);">🏙️ Lagos or Remote</span>
            <span style="font-size:13px;color:var(--gray-500);">💼 Full-time</span>
            <span style="font-size:13px;color:var(--gray-500);">🤖 AI/ML</span>
          </div>
        </div>
        <a href="{{ route('contact') }}" class="btn btn-outline btn-sm" style="white-space:nowrap;">Apply Now</a>
      </div>

      <div style="background:var(--white);border:1px solid var(--gray-200);border-radius:16px;padding:28px;display:flex;align-items:center;justify-content:space-between;gap:24px;transition:all 0.2s;flex-wrap:wrap;" onmouseover="this.style.borderColor='var(--teal)';this.style.boxShadow='0 8px 24px rgba(11,79,108,0.08)'" onmouseout="this.style.borderColor='var(--gray-200)';this.style.boxShadow=''">
        <div>
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;"><h3 style="font-size:17px;font-weight:600;color:var(--dark);">IoT Systems Engineer</h3><span class="tag green">New</span></div>
          <div style="display:flex;gap:16px;flex-wrap:wrap;">
            <span style="font-size:13px;color:var(--gray-500);">🏙️ Nairobi</span>
            <span style="font-size:13px;color:var(--gray-500);">💼 Full-time</span>
            <span style="font-size:13px;color:var(--gray-500);">⚙️ Engineering</span>
          </div>
        </div>
        <a href="{{ route('contact') }}" class="btn btn-outline btn-sm">Apply Now</a>
      </div>

      <div style="background:var(--white);border:1px solid var(--gray-200);border-radius:16px;padding:28px;display:flex;align-items:center;justify-content:space-between;gap:24px;transition:all 0.2s;flex-wrap:wrap;" onmouseover="this.style.borderColor='var(--teal)';this.style.boxShadow='0 8px 24px rgba(11,79,108,0.08)'" onmouseout="this.style.borderColor='var(--gray-200)';this.style.boxShadow=''">
        <div>
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;"><h3 style="font-size:17px;font-weight:600;color:var(--dark);">Product Designer (UI/UX)</h3></div>
          <div style="display:flex;gap:16px;flex-wrap:wrap;">
            <span style="font-size:13px;color:var(--gray-500);">🌍 Remote</span>
            <span style="font-size:13px;color:var(--gray-500);">💼 Full-time</span>
            <span style="font-size:13px;color:var(--gray-500);">🎨 Design</span>
          </div>
        </div>
        <a href="{{ route('contact') }}" class="btn btn-outline btn-sm">Apply Now</a>
      </div>

      <div style="background:var(--white);border:1px solid var(--gray-200);border-radius:16px;padding:28px;display:flex;align-items:center;justify-content:space-between;gap:24px;transition:all 0.2s;flex-wrap:wrap;" onmouseover="this.style.borderColor='var(--teal)';this.style.boxShadow='0 8px 24px rgba(11,79,108,0.08)'" onmouseout="this.style.borderColor='var(--gray-200)';this.style.boxShadow=''">
        <div>
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;"><h3 style="font-size:17px;font-weight:600;color:var(--dark);">Laravel Backend Engineer</h3></div>
          <div style="display:flex;gap:16px;flex-wrap:wrap;">
            <span style="font-size:13px;color:var(--gray-500);">🏙️ Lagos or Remote</span>
            <span style="font-size:13px;color:var(--gray-500);">💼 Full-time</span>
            <span style="font-size:13px;color:var(--gray-500);">⚙️ Engineering</span>
          </div>
        </div>
        <a href="{{ route('contact') }}" class="btn btn-outline btn-sm">Apply Now</a>
      </div>

      <div style="background:var(--white);border:1px solid var(--gray-200);border-radius:16px;padding:28px;display:flex;align-items:center;justify-content:space-between;gap:24px;transition:all 0.2s;flex-wrap:wrap;" onmouseover="this.style.borderColor='var(--teal)';this.style.boxShadow='0 8px 24px rgba(11,79,108,0.08)'" onmouseout="this.style.borderColor='var(--gray-200)';this.style.boxShadow=''">
        <div>
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;"><h3 style="font-size:17px;font-weight:600;color:var(--dark);">Solutions Architect — Enterprise</h3><span class="tag teal">Senior</span></div>
          <div style="display:flex;gap:16px;flex-wrap:wrap;">
            <span style="font-size:13px;color:var(--gray-500);">🏙️ Accra or Johannesburg</span>
            <span style="font-size:13px;color:var(--gray-500);">💼 Full-time</span>
            <span style="font-size:13px;color:var(--gray-500);">⚙️ Engineering</span>
          </div>
        </div>
        <a href="{{ route('contact') }}" class="btn btn-outline btn-sm">Apply Now</a>
      </div>

      <div style="background:var(--white);border:1px solid var(--gray-200);border-radius:16px;padding:28px;display:flex;align-items:center;justify-content:space-between;gap:24px;transition:all 0.2s;flex-wrap:wrap;" onmouseover="this.style.borderColor='var(--teal)';this.style.boxShadow='0 8px 24px rgba(11,79,108,0.08)'" onmouseout="this.style.borderColor='var(--gray-200)';this.style.boxShadow=''">
        <div>
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;"><h3 style="font-size:17px;font-weight:600;color:var(--dark);">Enterprise Sales Manager</h3></div>
          <div style="display:flex;gap:16px;flex-wrap:wrap;">
            <span style="font-size:13px;color:var(--gray-500);">🏙️ Lagos</span>
            <span style="font-size:13px;color:var(--gray-500);">💼 Full-time</span>
            <span style="font-size:13px;color:var(--gray-500);">📊 Operations</span>
          </div>
        </div>
        <a href="{{ route('contact') }}" class="btn btn-outline btn-sm">Apply Now</a>
      </div>
    </div>
  </div>
</section>

<section class="cta-section"><div class="section-inner">
  <h2>Don't See the Right Role?</h2>
  <p>We're always looking for exceptional talent. Send us your CV and tell us how you'd make an impact.</p>
  <a href="{{ route('contact') }}" class="btn btn-white btn-lg">Get In Touch</a>
</div></section>
</x-app-layout>
