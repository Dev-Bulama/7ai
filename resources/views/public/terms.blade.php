<x-app-layout title="{{ $page?->seo_title ?? 'Terms of Service — '.($settings['site_name']) }}" description="{{ $page?->seo_description ?? '7AI terms of service.' }}">
<div class="page-hero">
  <div class="section-inner" style="max-width:1280px;margin:0 auto;">
    <div class="breadcrumb"><a href="{{ route('home') }}">Home</a><span class="sep">›</span>Terms of Service</div>
    <h1 style="font-size:clamp(28px,3.5vw,44px);font-weight:700;color:var(--dark);letter-spacing:-0.025em;margin-bottom:12px;">{{ $page?->hero_title ?? 'Terms of Service' }}</h1>
    <p style="font-size:16px;color:var(--gray-500);">Last updated: June 1, 2025</p>
  </div>
</div>

<section class="section">
  <div class="section-inner" style="max-width:760px;margin:0 auto;">
    <p style="font-size:16px;color:var(--gray-700);line-height:1.8;margin-bottom:40px;">By accessing or using 7AI Technologies' products and services, you agree to be bound by these Terms of Service. Please read them carefully.</p>

    <div style="display:flex;flex-direction:column;gap:40px;">
      <div>
        <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:12px;">1. Acceptance of Terms</h2>
        <p style="font-size:15px;color:var(--gray-700);line-height:1.8;">By accessing or using 7AI products, you confirm that you are at least 18 years old, have the authority to enter into these terms, and agree to be bound by these Terms of Service and our Privacy Policy.</p>
      </div>

      <div>
        <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:12px;">2. Services</h2>
        <p style="font-size:15px;color:var(--gray-700);line-height:1.8;">7AI provides smart home automation hardware, installation services, AI software services, and related platform services. Specific service terms, including SLAs, are set out in your service agreement or order form.</p>
      </div>

      <div>
        <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:12px;">3. Payment & Billing</h2>
        <p style="font-size:15px;color:var(--gray-700);line-height:1.8;">One-time installation fees are due upon completion of installation. Monthly subscription services are billed in advance. All fees are non-refundable except as required by law. We reserve the right to suspend services for non-payment after a 14-day grace period.</p>
      </div>

      <div>
        <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:12px;">4. Acceptable Use</h2>
        <p style="font-size:15px;color:var(--gray-700);line-height:1.8;margin-bottom:16px;">You agree not to:</p>
        <ul style="list-style:none;display:flex;flex-direction:column;gap:8px;">
          <li style="display:flex;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--teal);">•</span>Use our AI services to generate harmful, deceptive, or illegal content</li>
          <li style="display:flex;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--teal);">•</span>Attempt to reverse-engineer, copy, or redistribute our software</li>
          <li style="display:flex;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--teal);">•</span>Use our platform to infringe intellectual property rights</li>
          <li style="display:flex;gap:10px;font-size:15px;color:var(--gray-700);"><span style="color:var(--teal);">•</span>Interfere with the security or operation of our services</li>
        </ul>
      </div>

      <div>
        <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:12px;">5. Intellectual Property</h2>
        <p style="font-size:15px;color:var(--gray-700);line-height:1.8;">All 7AI software, AI models, platform code, and proprietary technology remain the exclusive property of 7AI Technologies. Custom AI models developed specifically for a client remain the property of that client upon full payment, unless otherwise agreed.</p>
      </div>

      <div>
        <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:12px;">6. Limitation of Liability</h2>
        <p style="font-size:15px;color:var(--gray-700);line-height:1.8;">To the maximum extent permitted by law, 7AI shall not be liable for indirect, incidental, or consequential damages. Our total liability for any claim shall not exceed the amount paid by you in the 12 months preceding the claim.</p>
      </div>

      <div>
        <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:12px;">7. Governing Law</h2>
        <p style="font-size:15px;color:var(--gray-700);line-height:1.8;">These terms are governed by the laws of the Federal Republic of Nigeria. Disputes shall first be subject to mediation; if unresolved, to arbitration in Lagos, Nigeria, under the Rules of the Lagos Court of Arbitration.</p>
      </div>

      <div>
        <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:12px;">8. Changes to Terms</h2>
        <p style="font-size:15px;color:var(--gray-700);line-height:1.8;">We may update these terms from time to time. We will notify you of material changes by email and update the date above. Continued use of our services after changes constitutes acceptance.</p>
      </div>

      <div>
        <h2 style="font-size:20px;font-weight:700;color:var(--dark);margin-bottom:12px;">9. Contact</h2>
        <p style="font-size:15px;color:var(--gray-700);line-height:1.8;">For questions about these Terms, contact <a href="mailto:legal@7ai.africa" style="color:var(--teal);">legal@7ai.africa</a> or write to: 7AI Technologies Legal Department, Lagos, Nigeria.</p>
      </div>
    </div>
  </div>
</section>
</x-app-layout>
