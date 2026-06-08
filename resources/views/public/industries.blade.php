<x-app-layout title="Industries — 7AI" description="7AI solutions for every industry across Africa.">
<div class="page-hero">
  <div class="section-inner" style="max-width:1280px;margin:0 auto;">
    <div class="section-badge" style="display:inline-flex;">Industries</div>
    <h1 style="font-size:clamp(32px,4vw,52px);font-weight:700;color:var(--dark);letter-spacing:-0.025em;margin-bottom:16px;">Intelligence for<br>Every Sector</h1>
    <p style="font-size:18px;color:var(--gray-600);max-width:500px;line-height:1.7;">7AI solutions adapt to the unique needs, regulations, and challenges of every African industry.</p>
  </div>
</div>

<section class="section">
  <div class="section-inner">
    <div style="display:flex;flex-direction:column;gap:80px;">

      <!-- RESIDENTIAL -->
      <div class="feature-split" id="residential">
        <div>
          <div class="section-badge">Residential</div>
          <h2 class="section-title" style="font-size:34px;">Smart Living for<br>Modern African Homes</h2>
          <p style="font-size:16px;color:var(--gray-600);line-height:1.75;margin-bottom:24px;">From compact city apartments to sprawling family estates, our residential smart home solutions bring intelligent automation tailored for African lifestyles, climates, and power conditions.</p>
          <ul style="list-style:none;display:flex;flex-direction:column;gap:10px;margin-bottom:32px;">
            <li style="display:flex;align-items:center;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--green-dark);">✓</span>Complete home automation systems</li>
            <li style="display:flex;align-items:center;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--green-dark);">✓</span>Solar and battery backup integration</li>
            <li style="display:flex;align-items:center;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--green-dark);">✓</span>AI security and surveillance</li>
            <li style="display:flex;align-items:center;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--green-dark);">✓</span>Voice control in local languages</li>
          </ul>
          <a href="{{ route('smart-homes') }}" class="btn btn-primary">Explore Residential</a>
        </div>
        <div class="feature-visual" style="min-height:320px;background:linear-gradient(135deg,var(--gray-50),var(--gray-200));"><div style="text-align:center;color:var(--gray-400);font-size:64px;">🏠</div></div>
      </div>

      <!-- COMMERCIAL -->
      <div class="feature-split reverse" id="commercial">
        <div>
          <div class="section-badge">Commercial</div>
          <h2 class="section-title" style="font-size:34px;">Intelligent Buildings<br>for Business</h2>
          <p style="font-size:16px;color:var(--gray-600);line-height:1.75;margin-bottom:24px;">Smart office buildings, retail spaces, and commercial complexes — reducing operating costs, improving security, and enhancing the workplace experience through comprehensive AI automation.</p>
          <ul style="list-style:none;display:flex;flex-direction:column;gap:10px;margin-bottom:32px;">
            <li style="display:flex;align-items:center;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--green-dark);">✓</span>HVAC and energy management</li>
            <li style="display:flex;align-items:center;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--green-dark);">✓</span>Access control and visitor management</li>
            <li style="display:flex;align-items:center;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--green-dark);">✓</span>Occupancy analytics and space optimisation</li>
            <li style="display:flex;align-items:center;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--green-dark);">✓</span>Predictive maintenance alerts</li>
          </ul>
          <a href="{{ route('contact') }}" class="btn btn-primary">Get Commercial Quote</a>
        </div>
        <div class="feature-visual feature-visual-dark" style="min-height:320px;"><div style="text-align:center;color:rgba(255,255,255,0.15);font-size:64px;">🏢</div></div>
      </div>

      <!-- HOSPITALITY -->
      <div class="feature-split" id="hospitality">
        <div>
          <div class="section-badge">Hospitality</div>
          <h2 class="section-title" style="font-size:34px;">Smart Hotels &<br>Guest Experiences</h2>
          <p style="font-size:16px;color:var(--gray-600);line-height:1.75;margin-bottom:24px;">Elevate guest experiences with AI-powered room automation, personalised preferences, and predictive service — while cutting energy costs by up to 40%.</p>
          <ul style="list-style:none;display:flex;flex-direction:column;gap:10px;margin-bottom:32px;">
            <li style="display:flex;align-items:center;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--green-dark);">✓</span>Smart room control systems</li>
            <li style="display:flex;align-items:center;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--green-dark);">✓</span>AI concierge chatbot</li>
            <li style="display:flex;align-items:center;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--green-dark);">✓</span>Predictive maintenance</li>
            <li style="display:flex;align-items:center;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--green-dark);">✓</span>Guest preference learning</li>
          </ul>
          <a href="{{ route('contact') }}" class="btn btn-primary">Explore Hospitality</a>
        </div>
        <div class="feature-visual" style="min-height:320px;"><div style="text-align:center;color:var(--gray-400);font-size:64px;">🏨</div></div>
      </div>
    </div>
  </div>
</section>

<!-- MORE INDUSTRIES GRID -->
<section class="section section-gray">
  <div class="section-inner">
    <div class="section-header" style="text-align:center;"><div class="section-badge">More Sectors</div><h2 class="section-title">We Serve Every Industry</h2></div>
    <div class="grid-4">
      <div class="card" style="text-align:center;">
        <div style="font-size:40px;margin-bottom:16px;">⚕️</div>
        <h3>Healthcare</h3>
        <p>Smart facility management, AI diagnostics support, patient monitoring, and clinical workflow automation.</p>
      </div>
      <div class="card" style="text-align:center;">
        <div style="font-size:40px;margin-bottom:16px;">🌾</div>
        <h3>Agriculture</h3>
        <p>Precision farming AI, crop disease detection, irrigation automation, and yield prediction models.</p>
      </div>
      <div class="card" style="text-align:center;">
        <div style="font-size:40px;margin-bottom:16px;">🎓</div>
        <h3>Education</h3>
        <p>Smart campus automation, AI-powered learning systems, attendance tracking, and energy efficiency.</p>
      </div>
      <div class="card" style="text-align:center;">
        <div style="font-size:40px;margin-bottom:16px;">🏭</div>
        <h3>Manufacturing</h3>
        <p>Predictive maintenance, quality control vision AI, production monitoring, and supply chain intelligence.</p>
      </div>
      <div class="card" style="text-align:center;">
        <div style="font-size:40px;margin-bottom:16px;">🏦</div>
        <h3>Finance</h3>
        <p>AI fraud detection, credit risk scoring, customer service automation, and regulatory compliance AI.</p>
      </div>
      <div class="card" style="text-align:center;">
        <div style="font-size:40px;margin-bottom:16px;">🚚</div>
        <h3>Logistics</h3>
        <p>Route optimisation, demand forecasting, warehouse automation, and fleet intelligence systems.</p>
      </div>
      <div class="card" style="text-align:center;">
        <div style="font-size:40px;margin-bottom:16px;">🛒</div>
        <h3>Retail</h3>
        <p>Computer vision analytics, smart store automation, inventory AI, and personalised recommendation engines.</p>
      </div>
      <div class="card" style="text-align:center;">
        <div style="font-size:40px;margin-bottom:16px;">⚡</div>
        <h3>Energy & Utilities</h3>
        <p>Grid optimisation AI, predictive fault detection, smart metering, and renewable energy management.</p>
      </div>
    </div>
  </div>
</section>

<section class="cta-section"><div class="section-inner">
  <h2>Your Industry, Intelligently Transformed</h2>
  <p>Talk to our sector specialists and discover the highest-impact opportunities for your organisation.</p>
  <div style="display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap;">
    <a href="{{ route('contact') }}" class="btn btn-white btn-lg">Book Industry Consultation</a>
  </div>
</div></section>
</x-app-layout>
