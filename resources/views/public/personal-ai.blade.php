<x-app-layout :title="$page?->seo_title ?? '7ai Personal AI — Learn AI Skills for Everyday Life'" :description="$page?->seo_description ?? 'Practical AI skills training built for everyday Africans.'">

<div class="page-hero page-hero-navy">
  <div class="hero-ghost" style="font-size:clamp(180px,24vw,380px);color:rgba(122,174,142,0.06);">AI</div>
  <div class="hero-inner">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a><span>/</span>
      <a href="{{ route('home') }}#pillars">7ai Learn</a><span>/</span>
      <strong>Personal AI</strong>
    </div>
    <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">7ai Learn — Personal AI</span></div>
    <h1>{!! $page?->hero_title ? nl2br(e($page->hero_title)) : 'AI skills for<br><em>everyday life.</em>' !!}</h1>
    <p class="hero-sub-text">{{ $page?->hero_description ?? 'Practical AI training built for everyday Africans — whether you\'re a professional, entrepreneur, student, or simply curious about what AI can do for you.' }}</p>
    <div class="hero-actions">
      <a href="{{ $page?->cta_link ?: route('contact') }}" class="btn-primary">{{ $page?->cta_text ?? 'Register free' }}</a>
      <a href="#modules" class="btn-ghost">See the modules</a>
    </div>
  </div>
</div>

<!-- MODULES -->
<section class="fe-section bg-navy-mid" id="modules">
  <div class="section-header">
    <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">What you'll learn</span></div>
    <h2 class="section-title">Four modules.<br><em>Real skills.</em></h2>
    <p class="section-sub">Each module is built around a specific part of your life where AI can make a real difference. No fluff — just practical tools and techniques you can apply immediately.</p>
  </div>
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1px;background:var(--border-sage);border:0.5px solid var(--border-sage);border-radius:4px;overflow:hidden;">
    @forelse($modules as $m)
    <div style="background:var(--navy-mid);padding:40px 32px;transition:background 0.3s;" onmouseover="this.style.background='#172a45'" onmouseout="this.style.background='var(--navy-mid)'">
      <div style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.18em;text-transform:uppercase;color:var(--sage);margin-bottom:16px;">Module {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
      <div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--white);margin-bottom:12px;">{{ $m->title }}</div>
      <p style="font-size:13px;font-weight:300;color:var(--text-muted);line-height:1.7;">{{ $m->description }}</p>
    </div>
    @empty
    <div style="background:var(--navy-mid);padding:40px 32px;">
      <div style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.18em;text-transform:uppercase;color:var(--sage);margin-bottom:16px;">Module 01</div>
      <div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--white);margin-bottom:12px;">Personal AI productivity</div>
      <p style="font-size:13px;font-weight:300;color:var(--text-muted);line-height:1.7;">Use AI to work faster, write better, research deeper, and think more clearly. Practical tools for daily professional and personal tasks.</p>
    </div>
    <div style="background:var(--navy-mid);padding:40px 32px;">
      <div style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.18em;text-transform:uppercase;color:var(--sage);margin-bottom:16px;">Module 02</div>
      <div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--white);margin-bottom:12px;">Business automation basics</div>
      <p style="font-size:13px;font-weight:300;color:var(--text-muted);line-height:1.7;">Discover how AI can streamline your operations, automate repetitive tasks, and help your business run more efficiently.</p>
    </div>
    <div style="background:var(--navy-mid);padding:40px 32px;">
      <div style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.18em;text-transform:uppercase;color:var(--sage);margin-bottom:16px;">Module 03</div>
      <div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--white);margin-bottom:12px;">Smart home setup</div>
      <p style="font-size:13px;font-weight:300;color:var(--text-muted);line-height:1.7;">Understand what a smart home is, what's possible with your budget, and how to start — from smart lighting and security to energy management.</p>
    </div>
    <div style="background:var(--navy-mid);padding:40px 32px;">
      <div style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.18em;text-transform:uppercase;color:var(--sage);margin-bottom:16px;">Module 04</div>
      <div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--white);margin-bottom:12px;">AI for leaders &amp; policy</div>
      <p style="font-size:13px;font-weight:300;color:var(--text-muted);line-height:1.7;">For executives, managers, and public servants — understand what AI means for your sector and how to lead an AI transition confidently.</p>
    </div>
    @endforelse
  </div>
</section>

<!-- WHO IT'S FOR -->
<section class="fe-section bg-navy-deep">
  <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">Who this is for</span></div>
  <h2>Anyone curious<br><em>about AI.</em></h2>
  <div class="use-cases-grid">
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">Students &amp; graduates</div><p class="uc-desc">Get ahead of your peers by building AI skills that employers are actively looking for right now.</p></div>
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">Professionals</div><p class="uc-desc">Use AI to do your job better — write reports faster, research deeper, and present more confidently.</p></div>
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">Entrepreneurs</div><p class="uc-desc">Run a leaner, faster business by automating the tasks that eat your day and your margins.</p></div>
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">Homemakers</div><p class="uc-desc">Discover how AI can help with budgeting, meal planning, home management, and keeping your family organised.</p></div>
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">Civil servants</div><p class="uc-desc">Understand AI's implications for public service delivery and how to champion it responsibly.</p></div>
    <div class="use-case-card"><div class="uc-icon"></div><div class="uc-title">Creatives</div><p class="uc-desc">Writers, designers, and content creators — learn how AI can amplify your output without replacing your voice.</p></div>
  </div>
</section>

<!-- FAQ -->
<section class="fe-section bg-navy">
  <div class="eyebrow-row"><div class="eyebrow-line"></div><span class="eyebrow-text">Common questions</span></div>
  <h2>What people<br><em>want to know.</em></h2>
  <div class="faq-list">
    @forelse($faqs as $faq)
    <div class="faq-item {{ $loop->first ? 'open' : '' }}">
      <div class="faq-q" onclick="toggleFaq(this)">{{ $faq->question }}<span class="faq-icon">{{ $loop->first ? '−' : '+' }}</span></div>
      <div class="faq-a">{{ $faq->answer }}</div>
    </div>
    @empty
    <div class="faq-item open">
      <div class="faq-q" onclick="toggleFaq(this)">Is this really free?<span class="faq-icon">−</span></div>
      <div class="faq-a">Yes. Our entry-level programmes are completely free. We believe access to AI knowledge should not be a privilege — it should be a right for every African who wants it.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">Do I need any technical background?<span class="faq-icon">+</span></div>
      <div class="faq-a">None at all. Our programmes are designed for people with no technical background. If you can use a smartphone and browse the internet, you can follow our training.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">How long does each module take?<span class="faq-icon">+</span></div>
      <div class="faq-a">Each module is designed to be completed in 2–4 hours of focused learning, spread across a week at your own pace. There are no deadlines — you learn when it suits you.</div>
    </div>
    @endforelse
  </div>
</section>

<!-- CTA -->
<div class="cta-strip" style="background:var(--navy-deep);border-top:0.5px solid var(--border-sage);border-bottom:0.5px solid var(--border-sage);">
  <div>
    <h2 style="color:var(--white);">Learn AI.<br><em style="color:var(--sage-light);">Start today.</em></h2>
    <p style="color:var(--text-muted);">Programmes are free to join. Register now and we'll send you everything you need to get started.</p>
  </div>
  <a href="{{ route('contact') }}" class="btn-primary">Register free →</a>
</div>

<!-- ALSO EXPLORE -->
<div class="also-section">
  <h3>Also from 7ai</h3>
  <div class="also-grid">
    <a href="{{ route('smart-home') }}" class="also-card">
      <div class="also-label">7ai Build</div>
      <div class="also-title">Smart Home</div>
      <p class="also-desc">AI-powered home solutions designed for African households.</p>
      <span class="also-arrow">Explore →</span>
    </a>
    <a href="{{ route('business-automation') }}" class="also-card">
      <div class="also-label">7ai Build</div>
      <div class="also-title">Business Automation</div>
      <p class="also-desc">AI tools that automate your operations and reduce costs.</p>
      <span class="also-arrow">Explore →</span>
    </a>
    <a href="{{ route('advisory') }}" class="also-card">
      <div class="also-label">7ai Advise</div>
      <div class="also-title">Advisory &amp; Consulting</div>
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
