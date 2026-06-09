<x-app-layout title="{{ $page?->seo_title ?? 'AI Solutions — '.($settings['site_name']) }}" description="{{ $page?->seo_description ?? 'Enterprise AI, machine learning and intelligent automation.' }}">
<div class="page-hero page-hero-dark">
  <div class="section-inner" style="max-width:1280px;margin:0 auto;">
    <div class="breadcrumb"><a href="{{ route('home') }}" style="color:rgba(255,255,255,0.5);">Home</a><span class="sep" style="color:rgba(255,255,255,0.3);">›</span><a href="{{ route('solutions') }}" style="color:rgba(255,255,255,0.5);">Solutions</a><span class="sep" style="color:rgba(255,255,255,0.3);">›</span><span style="color:rgba(255,255,255,0.7);">AI Solutions</span></div>
    <div class="section-badge">Enterprise AI</div>
    <h1 style="font-size:clamp(36px,4.5vw,60px);font-weight:700;color:#fff;letter-spacing:-0.025em;max-width:700px;line-height:1.1;margin-bottom:20px;">{!! nl2br(e($page?->hero_title ?? 'Enterprise AI Solutions')) !!}</h1>
    <p style="font-size:18px;color:rgba(255,255,255,0.7);max-width:540px;line-height:1.7;">{{ $page?->hero_description ?? 'Purpose-built AI solutions for African business.' }}</p>
    <div style="margin-top:40px;display:flex;gap:16px;flex-wrap:wrap;">
      <a href="{{ $heroCta?->button_url ?? route('contact') }}" class="btn btn-primary btn-lg">{{ $page?->cta_text ?? $heroCta?->button_label ?? 'Start Your AI Journey' }}</a>
      <a href="{{ route('case-studies') }}" class="btn btn-white btn-lg">View Case Studies</a>
    </div>
  </div>
</div>

<section class="section">
  <div class="section-inner">
    <div class="section-header" style="text-align:center;">
      <div class="section-badge">Services</div>
      <h2 class="section-title">Nine AI Capabilities,<br>One Unified Platform</h2>
    </div>

    <div class="grid-3">
      <div class="card">
        <div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 20h20M4 20V10l8-8 8 8v10"/></svg></div>
        <h3>Machine Learning</h3>
        <p>Custom ML models trained on local and regional datasets. Classification, regression, clustering — deployed to production with monitoring and drift detection.</p>
        <a href="{{ route('contact') }}" style="display:inline-block;margin-top:16px;font-size:13px;font-weight:600;color:var(--teal);text-decoration:none;">Learn more →</a>
      </div>
      <div class="card">
        <div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
        <h3>Predictive Analytics</h3>
        <p>Forecast demand, revenue, risk, and churn before they happen. Time-series forecasting, anomaly detection, and causal inference — actionable, not just descriptive.</p>
        <a href="{{ route('contact') }}" style="display:inline-block;margin-top:16px;font-size:13px;font-weight:600;color:var(--teal);text-decoration:none;">Learn more →</a>
      </div>
      <div class="card">
        <div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M12 2v4m0 12v4M4.22 4.22l2.83 2.83m9.9 9.9l2.83 2.83M2 12h4m12 0h4M4.22 19.78l2.83-2.83m9.9-9.9l2.83-2.83"/></svg></div>
        <h3>AI Agents</h3>
        <p>Autonomous AI agents that plan, reason, and execute multi-step tasks — handling customer inquiries, procurement, reporting, and complex workflows.</p>
        <a href="{{ route('contact') }}" style="display:inline-block;margin-top:16px;font-size:13px;font-weight:600;color:var(--teal);text-decoration:none;">Learn more →</a>
      </div>
      <div class="card">
        <div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/></svg></div>
        <h3>AI Automation</h3>
        <p>Intelligent RPA that understands context. Automate document processing, data extraction, report generation, and cross-system workflows with AI precision.</p>
        <a href="{{ route('contact') }}" style="display:inline-block;margin-top:16px;font-size:13px;font-weight:600;color:var(--teal);text-decoration:none;">Learn more →</a>
      </div>
      <div class="card">
        <div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
        <h3>Business Intelligence</h3>
        <p>Real-time dashboards, automated insights, and natural language analytics. Ask your data questions in plain English and get instant answers.</p>
        <a href="{{ route('contact') }}" style="display:inline-block;margin-top:16px;font-size:13px;font-weight:600;color:var(--teal);text-decoration:none;">Learn more →</a>
      </div>
      <div class="card">
        <div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
        <h3>Computer Vision</h3>
        <p>Visual AI for quality inspection, safety compliance, agricultural assessment, retail analytics, and infrastructure monitoring — seeing the invisible.</p>
        <a href="{{ route('contact') }}" style="display:inline-block;margin-top:16px;font-size:13px;font-weight:600;color:var(--teal);text-decoration:none;">Learn more →</a>
      </div>
      <div class="card">
        <div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg></div>
        <h3>Conversational AI</h3>
        <p>Multilingual chatbots, voice bots, and AI assistants that handle customer service, internal queries, sales qualification, and knowledge management.</p>
        <a href="{{ route('contact') }}" style="display:inline-block;margin-top:16px;font-size:13px;font-weight:600;color:var(--teal);text-decoration:none;">Learn more →</a>
      </div>
      <div class="card">
        <div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg></div>
        <h3>Data Analytics</h3>
        <p>End-to-end data engineering — pipelines, warehouses, and lake architecture. Clean, transform, and serve data reliably across your organisation.</p>
        <a href="{{ route('contact') }}" style="display:inline-block;margin-top:16px;font-size:13px;font-weight:600;color:var(--teal);text-decoration:none;">Learn more →</a>
      </div>
      <div class="card">
        <div class="card-icon"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
        <h3>Custom AI Solutions</h3>
        <p>Bespoke AI for unique challenges. We research, architect, build, and maintain custom models — fully owned by your organisation.</p>
        <a href="{{ route('contact') }}" style="display:inline-block;margin-top:16px;font-size:13px;font-weight:600;color:var(--teal);text-decoration:none;">Learn more →</a>
      </div>
    </div>
  </div>
</section>

<section class="section section-dark">
  <div class="section-inner" style="text-align:center;">
    <div class="section-badge">ROI</div>
    <h2 class="section-title">Measurable Results</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:40px;margin-top:48px;">
      <div><div style="font-size:48px;font-weight:700;color:#fff;letter-spacing:-0.03em;">70%</div><div style="font-size:15px;color:rgba(255,255,255,0.55);margin-top:8px;">Reduction in manual processes</div></div>
      <div><div style="font-size:48px;font-weight:700;color:#fff;letter-spacing:-0.03em;">3x</div><div style="font-size:15px;color:rgba(255,255,255,0.55);margin-top:8px;">Faster decision-making</div></div>
      <div><div style="font-size:48px;font-weight:700;color:#fff;letter-spacing:-0.03em;">45%</div><div style="font-size:15px;color:rgba(255,255,255,0.55);margin-top:8px;">Average cost reduction</div></div>
      <div><div style="font-size:48px;font-weight:700;color:#fff;letter-spacing:-0.03em;">6mo</div><div style="font-size:15px;color:rgba(255,255,255,0.55);margin-top:8px;">Average time to positive ROI</div></div>
    </div>
  </div>
</section>

<section class="cta-section"><div class="section-inner">
  <h2>Let's Build Your AI Advantage</h2>
  <p>Get a free AI readiness assessment and discover the highest-impact opportunities in your business.</p>
  <div style="display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap;">
    <a href="{{ route('contact') }}" class="btn btn-white btn-lg">Request Assessment</a>
    <a href="{{ route('case-studies') }}" class="btn btn-lg" style="border:1.5px solid rgba(255,255,255,0.4);color:rgba(255,255,255,0.9);background:transparent;">View Case Studies</a>
  </div>
</div></section>

<section class="cta-section"><div class="section-inner">
  <h2>{{ $bottomCta?->title ?? 'Ready to Leverage AI for Your Business?' }}</h2>
  <p>{{ $bottomCta?->text ?? 'Talk to our AI specialists and get a custom solution roadmap.' }}</p>
  <div style="display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap;">
    <a href="{{ $bottomCta?->button_url ?? route('contact') }}" class="btn btn-white btn-lg">{{ $bottomCta?->button_label ?? 'Start Your AI Journey' }}</a>
  </div>
</div></section>
</x-app-layout>
