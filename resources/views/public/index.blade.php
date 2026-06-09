<x-app-layout title="{{ $settings['site_name'] ?? '7AI' }} — African Intelligence, Amplified" description="Smart home automation and enterprise AI solutions built for Africa.">

<!-- HERO -->
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-grid"></div>
  <canvas id="hero-canvas" style="position:absolute;inset:0;width:100%;height:100%;"></canvas>

  <div class="hero-content">
    <div class="hero-badge">
      <span class="dot"></span>
      Now Available Across Africa
    </div>

    <h1>{{ $heroCta?->title ?? 'African Intelligence,' }}<br>
      @if(!$heroCta)<span class="accent">Amplified.</span>@endif
    </h1>

    <p>{{ $heroCta?->text ?? 'Transforming homes, businesses, and communities through AI-powered automation and intelligent technology solutions built for Africa\'s future.' }}</p>

    <div class="hero-actions">
      <a href="{{ $heroCta?->button_url ?? route('contact') }}" class="btn btn-primary btn-lg">{{ $heroCta?->button_label ?? 'Book Consultation' }}</a>
      @if($heroCta?->button2_label)
      <a href="{{ $heroCta->button2_url ?? route('investors') }}" class="btn btn-white btn-lg">{{ $heroCta->button2_label }}</a>
      @else
      <a href="{{ route('investors') }}" class="btn btn-white btn-lg">Register as Investor</a>
      @endif
      <a href="#demo" class="btn btn-ghost btn-lg" style="color:rgba(255,255,255,0.75)">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 8.5l-5 3A.5.5 0 0 1 6 11V5a.5.5 0 0 1 .5-.5.5.5 0 0 1 .25.07l5 3a.5.5 0 0 1 0 .86z"/></svg>
        Watch Demo
      </a>
    </div>

    <div class="hero-stats">
      <div class="stat-item">
        <div class="stat-number"><span data-target="500" data-suffix="+">500+</span></div>
        <div class="stat-label">Homes Automated</div>
      </div>
      <div class="stat-item">
        <div class="stat-number"><span data-target="120" data-suffix="+">120+</span></div>
        <div class="stat-label">Business Clients</div>
      </div>
      <div class="stat-item">
        <div class="stat-number"><span data-target="98" data-suffix="%">98%</span></div>
        <div class="stat-label">Client Satisfaction</div>
      </div>
      <div class="stat-item">
        <div class="stat-number"><span data-target="12" data-suffix="">12</span><span class="green">+</span></div>
        <div class="stat-label">African Countries</div>
      </div>
    </div>
  </div>
</section>

<!-- LOGOS / TRUST -->
<section class="section" style="padding:60px 24px;border-bottom:1px solid var(--gray-200);">
  <div class="section-inner" style="text-align:center;">
    <p style="font-size:13px;font-weight:600;color:var(--gray-400);letter-spacing:0.08em;text-transform:uppercase;margin-bottom:32px;">Trusted by leading organizations</p>
    <div style="display:flex;align-items:center;justify-content:center;gap:48px;flex-wrap:wrap;opacity:0.5;">
      <div style="font-size:20px;font-weight:700;color:var(--gray-400);">TechCorp Africa</div>
      <div style="font-size:20px;font-weight:700;color:var(--gray-400);">NovaBuild</div>
      <div style="font-size:20px;font-weight:700;color:var(--gray-400);">Solaris Estates</div>
      <div style="font-size:20px;font-weight:700;color:var(--gray-400);">PanAfrica Hub</div>
      <div style="font-size:20px;font-weight:700;color:var(--gray-400);">Greenfield Co.</div>
      <div style="font-size:20px;font-weight:700;color:var(--gray-400);">Meridian Group</div>
    </div>
  </div>
</section>

<!-- SMART HOME SOLUTIONS -->
<section class="section section-gray" id="smart-homes">
  <div class="section-inner">
    <div class="section-header">
      <div class="section-badge">Smart Home</div>
      <h2 class="section-title">Intelligent Living,<br>Redefined.</h2>
      <p class="section-sub">Complete smart home automation systems tailored for African homes and climates — reliable, efficient, and beautifully designed.</p>
    </div>

    <div class="grid-3">
      @forelse($homeCards as $card)
      <div class="card">
        @if($card->icon)
        <div class="card-icon">{!! $card->icon !!}</div>
        @elseif($card->image)
        <div class="card-icon"><img src="{{ $card->image }}" alt="{{ $card->title }}" style="width:24px;height:24px;object-fit:contain;"></div>
        @endif
        <h3>{{ $card->title }}</h3>
        <p>{{ $card->description }}</p>
        @if($card->button_text && $card->link)
        <a href="{{ $card->link }}" style="color:var(--teal);font-size:13px;font-weight:600;text-decoration:none;margin-top:8px;display:inline-block;">{{ $card->button_text }} →</a>
        @endif
      </div>
      @empty
      {{-- Fallback static cards --}}
      <div class="card"><div class="card-icon"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2L2 7v10a2 2 0 002 2h16a2 2 0 002-2V7L12 2z"/><path d="M9 22V12h6v10"/></svg></div><h3>Smart Lighting</h3><p>Adaptive lighting systems that learn your routines and reduce energy by up to 60%.</p></div>
      <div class="card"><div class="card-icon"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg></div><h3>Smart Security</h3><p>AI-powered security with facial recognition, motion detection, and real-time alerts 24/7.</p></div>
      <div class="card"><div class="card-icon"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div><h3>Smart Energy</h3><p>Solar integration and predictive energy monitoring — cut bills and maximise renewable energy.</p></div>
      @endforelse
    </div>

    <div style="margin-top:48px;text-align:center;">
      <a href="{{ route('smart-homes') }}" class="btn btn-outline btn-lg">Explore Smart Home Solutions</a>
    </div>
  </div>
</section>

<!-- AI SERVICES -->
<section class="section section-dark" id="ai-solutions">
  <div class="section-inner">
    <div class="section-header">
      <div class="section-badge">AI Services</div>
      <h2 class="section-title">Intelligence Built<br>for Africa's Scale.</h2>
      <p class="section-sub">Enterprise-grade AI solutions designed for African businesses — from predictive analytics to autonomous agents.</p>
    </div>

    <div class="grid-3">
      @forelse($aiCards as $card)
      <div class="card">
        @if($card->icon)
        <div class="card-icon">{!! $card->icon !!}</div>
        @endif
        <h3>{{ $card->title }}</h3>
        <p>{{ $card->description }}</p>
      </div>
      @empty
      <div class="card"><div class="card-icon"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 20h20M4 20V10l8-8 8 8v10"/></svg></div><h3>Machine Learning</h3><p>Custom ML models trained on local datasets for agriculture, finance, healthcare, and logistics.</p></div>
      <div class="card"><div class="card-icon"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div><h3>Predictive Analytics</h3><p>Turn raw data into forward-looking intelligence. Forecast demand and detect anomalies.</p></div>
      <div class="card"><div class="card-icon"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M12 2v4m0 12v4M4.22 4.22l2.83 2.83m9.9 9.9l2.83 2.83M2 12h4m12 0h4"/></svg></div><h3>AI Agents</h3><p>Autonomous AI agents that handle complex workflows and customer interactions around the clock.</p></div>
      @endforelse
    </div>

    <div style="margin-top:48px;text-align:center;">
      <a href="{{ route('ai-solutions') }}" class="btn btn-white btn-lg">Explore AI Solutions</a>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="section">
  <div class="section-inner">
    <div class="section-header" style="text-align:center;">
      <div class="section-badge">Process</div>
      <h2 class="section-title">From Consultation<br>to Automation</h2>
      <p class="section-sub" style="margin:0 auto;">Simple, structured, and transparent — we guide you through every step of your transformation journey.</p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:40px;margin-top:16px;">
      @foreach([['1','Discovery Call','We understand your goals, environment, and requirements in depth.'],['2','Custom Design','Our engineers design a tailored solution architecture for your needs.'],['3','Installation','Certified technicians deploy and configure all hardware and software.'],['4','Training','Full onboarding and training for you and your team or household.'],['5','24/7 Support','Ongoing monitoring, updates, and support to keep everything running perfectly.']] as [$num,$title,$desc])
      <div style="text-align:center;">
        <div style="width:64px;height:64px;border-radius:50%;background:rgba(11,79,108,0.08);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:24px;font-weight:700;color:var(--teal);">{{ $num }}</div>
        <h3 style="font-size:17px;font-weight:600;color:var(--dark);margin-bottom:10px;">{{ $title }}</h3>
        <p style="font-size:14px;color:var(--gray-600);line-height:1.6;">{{ $desc }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- INDUSTRIES -->
<section class="section section-gray">
  <div class="section-inner">
    <div class="section-header">
      <div class="section-badge">Industries</div>
      <h2 class="section-title">Built for Every<br>African Sector</h2>
      <p class="section-sub">Our solutions adapt to the unique requirements of different industries across the continent.</p>
    </div>
    <div class="grid-4">
      @foreach([['Residential','M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z'],['Commercial','M2 3h20v14H2zM8 21h8M12 17v4'],['Manufacturing','M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z'],['Healthcare','M22 12h-4l-3 9L9 3l-3 9H2'],['Hospitality','M2 7h20v14H2zM16 3H8a2 2 0 00-2 2v2h12V5a2 2 0 00-2-2z'],['Education','M3 3h18v18H3zM3 9h18M9 21V9'],['Agriculture','M12 2a10 10 0 100 20A10 10 0 0012 2zm0 0v20M2 12h20'],['Finance','M2 2h20v20H2zM16 8h-6a2 2 0 00-2 2v5a2 2 0 002 2h6M14 15l3-3-3-3']] as [$name, $svgPath])
      <a href="{{ route('industries') }}" style="text-decoration:none;">
        <div class="card" style="text-align:center;">
          <div class="card-icon" style="margin:0 auto 16px;">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="{{ $svgPath }}"/></svg>
          </div>
          <h3 style="font-size:16px;">{{ $name }}</h3>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="section">
  <div class="section-inner">
    <div class="section-header" style="text-align:center;">
      <div class="section-badge">Testimonials</div>
      <h2 class="section-title">What Our Clients Say</h2>
    </div>

    <div class="grid-3">
      @forelse($testimonials as $t)
      <div class="testimonial-card">
        <p class="testimonial-text">"{{ $t->content }}"</p>
        <div class="testimonial-author">
          @if($t->author_avatar)
          <img src="{{ $t->author_avatar }}" alt="{{ $t->author_name }}" class="author-avatar" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
          @else
          <div class="author-avatar">{{ substr($t->author_name, 0, 2) }}</div>
          @endif
          <div>
            <div class="author-name">{{ $t->author_name }}</div>
            <div class="author-role">{{ $t->author_role }}@if($t->author_company) — {{ $t->author_company }}@endif</div>
          </div>
        </div>
      </div>
      @empty
      {{-- fallback --}}
      <div class="testimonial-card"><p class="testimonial-text">"7AI transformed our office building into a fully intelligent workspace. Energy costs dropped 45% in the first month."</p><div class="testimonial-author"><div class="author-avatar">AO</div><div><div class="author-name">Adewale Okonkwo</div><div class="author-role">CEO, Meridian Group — Lagos</div></div></div></div>
      @endforelse
    </div>
  </div>
</section>

<!-- BLOG PREVIEW -->
<section class="section section-gray">
  <div class="section-inner">
    <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:48px;flex-wrap:wrap;gap:16px;">
      <div>
        <div class="section-badge">Insights</div>
        <h2 class="section-title" style="margin-bottom:0;">Latest from 7AI</h2>
      </div>
      <a href="{{ route('blog') }}" class="btn btn-outline">View All Articles</a>
    </div>

    <div class="grid-3">
      @forelse($latestPosts as $post)
      <div class="blog-card">
        <div class="blog-image" style="background:linear-gradient(135deg,var(--teal-dark),var(--teal-light));"></div>
        <div class="blog-content">
          @if($post->category)<span class="blog-tag">{{ $post->category->name }}</span>@endif
          <h3>{{ $post->title }}</h3>
          <p style="font-size:14px;color:var(--gray-600);line-height:1.6;">{{ $post->excerpt }}</p>
          <div class="blog-meta">
            <span>{{ $post->published_at?->format('M j, Y') }}</span>
            <span>·</span>
            <span>{{ $post->read_time }} min read</span>
          </div>
        </div>
      </div>
      @empty
      <div class="blog-card"><div class="blog-image" style="background:linear-gradient(135deg,var(--teal-dark),var(--teal-light));"></div><div class="blog-content"><span class="blog-tag">Smart Home</span><h3>The Future of Smart Homes in Sub-Saharan Africa</h3><p style="font-size:14px;color:var(--gray-600);">How AI-powered home automation is reshaping urban living across Nigeria, Ghana, and Kenya.</p></div></div>
      @endforelse
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section" id="demo">
  <div class="section-inner">
    <div style="display:inline-block;background:rgba(255,255,255,0.15);border-radius:100px;padding:5px 16px;font-size:12px;font-weight:600;color:rgba(255,255,255,0.9);letter-spacing:0.05em;text-transform:uppercase;margin-bottom:24px;">Get Started Today</div>
    <h2>{{ $bottomCta?->title ?? 'Ready to Transform Your Home or Business?' }}</h2>
    <p>{{ $bottomCta?->text ?? 'Book a free 30-minute consultation with our experts and discover what AI automation can do for you.' }}</p>
    <div style="display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap;">
      <a href="{{ $bottomCta?->button_url ?? route('contact') }}" class="btn btn-white btn-lg">{{ $bottomCta?->button_label ?? 'Book Free Consultation' }}</a>
      @if($bottomCta?->button2_label)
      <a href="{{ $bottomCta->button2_url ?? route('pricing') }}" class="btn btn-lg" style="border:1.5px solid rgba(255,255,255,0.4);color:rgba(255,255,255,0.9);background:transparent;">{{ $bottomCta->button2_label }}</a>
      @else
      <a href="{{ route('pricing') }}" class="btn btn-lg" style="border:1.5px solid rgba(255,255,255,0.4);color:rgba(255,255,255,0.9);background:transparent;">View Pricing</a>
      @endif
    </div>
  </div>
</section>

</x-app-layout>
