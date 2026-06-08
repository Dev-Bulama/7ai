<x-app-layout title="Pricing — 7AI" description="Transparent pricing for smart home and AI solutions.">
<div class="page-hero" style="padding-top:140px;">
  <div class="section-inner" style="max-width:1280px;margin:0 auto;text-align:center;">
    <div class="section-badge" style="display:inline-flex;margin-bottom:20px;">Pricing</div>
    <h1 style="font-size:clamp(36px,4.5vw,56px);font-weight:700;color:var(--dark);letter-spacing:-0.025em;margin-bottom:16px;">Simple, Transparent Pricing</h1>
    <p style="font-size:18px;color:var(--gray-600);max-width:500px;margin:0 auto;">No hidden fees, no surprises. Choose the plan that fits your needs and scale as you grow.</p>

    <!-- TABS -->
    <div style="display:inline-flex;background:var(--gray-100);border-radius:10px;padding:4px;margin-top:32px;">
      <button id="tab-home" onclick="switchTab('home')" style="padding:8px 24px;border-radius:7px;border:none;background:var(--teal);color:#fff;font-size:14px;font-weight:600;cursor:pointer;">Smart Home</button>
      <button id="tab-ai" onclick="switchTab('ai')" style="padding:8px 24px;border-radius:7px;border:none;background:transparent;color:var(--gray-600);font-size:14px;font-weight:600;cursor:pointer;">AI Services</button>
    </div>
  </div>
</div>

<!-- SMART HOME PRICING -->
<section class="section" id="plans-home">
  <div class="section-inner">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px;max-width:960px;margin:0 auto;">
      <div class="pricing-card">
        <div style="font-size:12px;font-weight:600;color:var(--teal);letter-spacing:0.08em;text-transform:uppercase;margin-bottom:12px;">Starter</div>
        <div class="price"><sup>$</sup>1,499</div>
        <div style="font-size:14px;color:var(--gray-400);margin-top:4px;">One-time installation</div>
        <p style="font-size:14px;color:var(--gray-600);margin-top:16px;line-height:1.6;">Perfect for apartments and small homes. Essential smart home features to get started.</p>
        <ul class="feature-list">
          <li><span class="check">✓</span>Smart lighting (up to 10 points)</li>
          <li><span class="check">✓</span>2 HD security cameras</li>
          <li><span class="check">✓</span>Smart door lock</li>
          <li><span class="check">✓</span>Basic energy monitoring</li>
          <li><span class="check">✓</span>Mobile app control</li>
          <li><span class="check">✓</span>1-year warranty</li>
          <li><span class="check">✓</span>Email support</li>
        </ul>
        <a href="{{ route('contact') }}" class="btn btn-outline" style="width:100%;text-align:center;">Get Started</a>
      </div>

      <div class="pricing-card featured">
        <div class="pricing-badge">Most Popular</div>
        <div style="font-size:12px;font-weight:600;color:var(--teal);letter-spacing:0.08em;text-transform:uppercase;margin-bottom:12px;">Professional</div>
        <div class="price"><sup>$</sup>4,999</div>
        <div style="font-size:14px;color:var(--gray-400);margin-top:4px;">One-time installation</div>
        <p style="font-size:14px;color:var(--gray-600);margin-top:16px;line-height:1.6;">Complete smart home experience for modern 3–5 bedroom homes and townhouses.</p>
        <ul class="feature-list">
          <li><span class="check">✓</span>Smart lighting (unlimited points)</li>
          <li><span class="check">✓</span>8 AI cameras + surveillance</li>
          <li><span class="check">✓</span>Full access control system</li>
          <li><span class="check">✓</span>Energy + solar integration</li>
          <li><span class="check">✓</span>Climate control (3 zones)</li>
          <li><span class="check">✓</span>Voice automation</li>
          <li><span class="check">✓</span>AI assistant setup</li>
          <li><span class="check">✓</span>3-year warranty</li>
          <li><span class="check">✓</span>24/7 priority support</li>
        </ul>
        <a href="{{ route('contact') }}" class="btn btn-primary" style="width:100%;text-align:center;">Get Started</a>
      </div>

      <div class="pricing-card">
        <div style="font-size:12px;font-weight:600;color:var(--teal);letter-spacing:0.08em;text-transform:uppercase;margin-bottom:12px;">Estate</div>
        <div class="price" style="font-size:36px;">Custom</div>
        <div style="font-size:14px;color:var(--gray-400);margin-top:4px;">Tailored to your property</div>
        <p style="font-size:14px;color:var(--gray-600);margin-top:16px;line-height:1.6;">Enterprise-grade smart home or residential estate. Fully bespoke design and installation.</p>
        <ul class="feature-list">
          <li><span class="check">✓</span>Everything in Professional</li>
          <li><span class="check">✓</span>Unlimited cameras and lighting</li>
          <li><span class="check">✓</span>Commercial-grade security</li>
          <li><span class="check">✓</span>Full energy management</li>
          <li><span class="check">✓</span>Custom IoT integrations</li>
          <li><span class="check">✓</span>Dedicated account manager</li>
          <li><span class="check">✓</span>On-site support SLA</li>
          <li><span class="check">✓</span>Lifetime warranty option</li>
        </ul>
        <a href="{{ route('contact') }}" class="btn btn-outline" style="width:100%;text-align:center;">Contact Us</a>
      </div>
    </div>

    <p style="text-align:center;font-size:14px;color:var(--gray-400);margin-top:32px;">All prices in USD. Local currency (NGN, GHS, KES, ZAR) available. Monthly monitoring plans from $49/mo.</p>
  </div>
</section>

<!-- AI PRICING (hidden by default) -->
<section class="section" id="plans-ai" style="display:none;">
  <div class="section-inner">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px;max-width:960px;margin:0 auto;">
      <div class="pricing-card">
        <div style="font-size:12px;font-weight:600;color:var(--teal);letter-spacing:0.08em;text-transform:uppercase;margin-bottom:12px;">Growth</div>
        <div class="price"><sup>$</sup>999<span>/mo</span></div>
        <p style="font-size:14px;color:var(--gray-600);margin-top:16px;line-height:1.6;">AI tools for growing businesses. Perfect for SMEs starting their AI journey.</p>
        <ul class="feature-list">
          <li><span class="check">✓</span>1 AI chatbot deployment</li>
          <li><span class="check">✓</span>Basic analytics dashboard</li>
          <li><span class="check">✓</span>5 automated workflows</li>
          <li><span class="check">✓</span>Monthly AI insights report</li>
          <li><span class="check">✓</span>Email + chat support</li>
          <li><span class="check">✓</span>Up to 10,000 AI calls/mo</li>
        </ul>
        <a href="{{ route('contact') }}" class="btn btn-outline" style="width:100%;text-align:center;">Start Trial</a>
      </div>
      <div class="pricing-card featured">
        <div class="pricing-badge">Most Popular</div>
        <div style="font-size:12px;font-weight:600;color:var(--teal);letter-spacing:0.08em;text-transform:uppercase;margin-bottom:12px;">Business</div>
        <div class="price"><sup>$</sup>3,499<span>/mo</span></div>
        <p style="font-size:14px;color:var(--gray-600);margin-top:16px;line-height:1.6;">Full AI capabilities for established businesses ready to scale intelligence operations.</p>
        <ul class="feature-list">
          <li><span class="check">✓</span>3 custom ML models</li>
          <li><span class="check">✓</span>Predictive analytics</li>
          <li><span class="check">✓</span>AI agent deployment</li>
          <li><span class="check">✓</span>Advanced BI dashboard</li>
          <li><span class="check">✓</span>Unlimited workflows</li>
          <li><span class="check">✓</span>API access</li>
          <li><span class="check">✓</span>Dedicated AI engineer</li>
          <li><span class="check">✓</span>Priority 24/7 support</li>
        </ul>
        <a href="{{ route('contact') }}" class="btn btn-primary" style="width:100%;text-align:center;">Get Started</a>
      </div>
      <div class="pricing-card">
        <div style="font-size:12px;font-weight:600;color:var(--teal);letter-spacing:0.08em;text-transform:uppercase;margin-bottom:12px;">Enterprise</div>
        <div class="price" style="font-size:36px;">Custom</div>
        <p style="font-size:14px;color:var(--gray-600);margin-top:16px;line-height:1.6;">Full-scale AI transformation. Dedicated team, custom development, and strategic partnership.</p>
        <ul class="feature-list">
          <li><span class="check">✓</span>Everything in Business</li>
          <li><span class="check">✓</span>Custom model development</li>
          <li><span class="check">✓</span>On-premise deployment option</li>
          <li><span class="check">✓</span>Data sovereignty guarantee</li>
          <li><span class="check">✓</span>Dedicated AI team</li>
          <li><span class="check">✓</span>Strategic AI roadmap</li>
          <li><span class="check">✓</span>SLA with uptime guarantee</li>
        </ul>
        <a href="{{ route('contact') }}" class="btn btn-outline" style="width:100%;text-align:center;">Contact Sales</a>
      </div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="section section-gray">
  <div class="section-inner" style="max-width:720px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:48px;">
      <div class="section-badge" style="display:inline-flex;">FAQ</div>
      <h2 class="section-title">Common Questions</h2>
    </div>
    <div class="accordion-item open">
      <button class="accordion-btn">Are there any monthly fees after installation? <span class="accordion-icon">+</span></button>
      <div class="accordion-content">Hardware installation is a one-time cost. Optional monthly monitoring plans start at $49/month and include 24/7 system monitoring, cloud storage, and remote support. These are entirely optional — your system works without them.</div>
    </div>
    <div class="accordion-item">
      <button class="accordion-btn">Do you offer financing or payment plans? <span class="accordion-icon">+</span></button>
      <div class="accordion-content">Yes. We offer flexible payment plans for installations above $2,000, including 3, 6, and 12-month installment options with 0% interest for qualified clients. Contact us for details.</div>
    </div>
    <div class="accordion-item">
      <button class="accordion-btn">What countries do you operate in? <span class="accordion-icon">+</span></button>
      <div class="accordion-content">We currently have offices and certified technicians in Nigeria, Ghana, Kenya, and South Africa. We service clients remotely and with partner networks in 12+ additional African countries.</div>
    </div>
    <div class="accordion-item">
      <button class="accordion-btn">How long does installation take? <span class="accordion-icon">+</span></button>
      <div class="accordion-content">Starter installations typically take 1-2 days. Professional packages take 3-5 days. Estate and commercial projects are scoped individually but typically range from 1-4 weeks.</div>
    </div>
    <div class="accordion-item">
      <button class="accordion-btn">What happens if there's a power outage? <span class="accordion-icon">+</span></button>
      <div class="accordion-content">Our systems are designed for African power conditions. Critical systems like security and access control include battery backup. Our energy management solutions include solar and battery integration to keep your home running during outages.</div>
    </div>
  </div>
</section>

<section class="cta-section"><div class="section-inner">
  <h2>Not Sure Which Plan Is Right?</h2>
  <p>Talk to our team and we'll help you find the perfect fit for your budget and goals.</p>
  <div style="display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap;">
    <a href="{{ route('contact') }}" class="btn btn-white btn-lg">Talk to an Expert</a>
  </div>
</div></section>



<script>
function switchTab(tab) {
  document.getElementById('plans-home').style.display = tab==='home' ? 'block' : 'none';
  document.getElementById('plans-ai').style.display = tab==='ai' ? 'block' : 'none';
  document.getElementById('tab-home').style.background = tab==='home' ? 'var(--teal)' : 'transparent';
  document.getElementById('tab-home').style.color = tab==='home' ? '#fff' : 'var(--gray-600)';
  document.getElementById('tab-ai').style.background = tab==='ai' ? 'var(--teal)' : 'transparent';
  document.getElementById('tab-ai').style.color = tab==='ai' ? '#fff' : 'var(--gray-600)';
}
</script>
</x-app-layout>
