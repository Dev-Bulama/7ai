<x-app-layout title="Contact — 7AI" description="Get in touch with the 7AI team.">
<div class="page-hero">
  <div class="section-inner" style="max-width:1280px;margin:0 auto;">
    <div class="section-badge" style="display:inline-flex;">Contact</div>
    <h1 style="font-size:clamp(32px,4vw,52px);font-weight:700;color:var(--dark);letter-spacing:-0.025em;margin-bottom:16px;">Let's Build Something<br>Intelligent Together</h1>
    <p style="font-size:18px;color:var(--gray-600);max-width:500px;line-height:1.7;">Book a consultation, request a quote, or just reach out. Our team responds within 24 hours.</p>
  </div>
</div>

<section class="section">
  <div class="section-inner">
    <div style="display:grid;grid-template-columns:1fr 1.2fr;gap:80px;align-items:start;">

      <!-- CONTACT INFO -->
      <div>
        <h2 style="font-size:24px;font-weight:700;color:var(--dark);margin-bottom:32px;">Reach Us Directly</h2>

        <div style="display:flex;flex-direction:column;gap:32px;">
          <div style="display:flex;gap:16px;align-items:flex-start;">
            <div style="width:44px;height:44px;border-radius:10px;background:rgba(11,79,108,0.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--teal);">
              <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div>
              <div style="font-size:13px;font-weight:600;color:var(--gray-400);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Offices</div>
              <div style="font-size:15px;color:var(--dark);line-height:1.7;">Lagos, Nigeria · Accra, Ghana<br>Nairobi, Kenya · Johannesburg, SA</div>
            </div>
          </div>

          <div style="display:flex;gap:16px;align-items:flex-start;">
            <div style="width:44px;height:44px;border-radius:10px;background:rgba(11,79,108,0.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--teal);">
              <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 0h3a2 2 0 012 1.72c.127 1.004.361 1.99.7 2.94a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.14-1.14a2 2 0 012.11-.45c.95.339 1.936.573 2.94.7A2 2 0 0122 14.92z"/></svg>
            </div>
            <div>
              <div style="font-size:13px;font-weight:600;color:var(--gray-400);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Phone</div>
              <div style="font-size:15px;color:var(--dark);">+234 800 7AI TECH<br>+233 302 000 7AI</div>
            </div>
          </div>

          <div style="display:flex;gap:16px;align-items:flex-start;">
            <div style="width:44px;height:44px;border-radius:10px;background:rgba(11,79,108,0.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--teal);">
              <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <div>
              <div style="font-size:13px;font-weight:600;color:var(--gray-400);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Email</div>
              <div style="font-size:15px;color:var(--dark);">hello@7ai.africa<br>enterprise@7ai.africa</div>
            </div>
          </div>

          <div style="display:flex;gap:16px;align-items:flex-start;">
            <div style="width:44px;height:44px;border-radius:10px;background:rgba(11,79,108,0.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--teal);">
              <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
              <div style="font-size:13px;font-weight:600;color:var(--gray-400);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Business Hours</div>
              <div style="font-size:15px;color:var(--dark);">Monday – Friday: 8am – 6pm WAT<br>Saturday: 9am – 2pm WAT</div>
            </div>
          </div>
        </div>

        <div style="margin-top:48px;padding:24px;background:var(--gray-50);border-radius:16px;border:1px solid var(--gray-200);">
          <h3 style="font-size:16px;font-weight:600;color:var(--dark);margin-bottom:8px;">Need Urgent Support?</h3>
          <p style="font-size:14px;color:var(--gray-600);line-height:1.6;margin-bottom:16px;">Existing clients with urgent issues can access 24/7 priority support through the client portal.</p>
          <a href="{{ route('support') }}" class="btn btn-outline btn-sm">Go to Support Portal</a>
        </div>
      </div>

      <!-- CONTACT FORM -->
      <div style="background:var(--white);border:1px solid var(--gray-200);border-radius:20px;padding:40px;">
        <h2 style="font-size:22px;font-weight:700;color:var(--dark);margin-bottom:8px;">Book a Consultation</h2>
        <p style="font-size:14px;color:var(--gray-500);margin-bottom:32px;">Fill out the form and we'll get back to you within 24 hours.</p>

        <form id="contact-form" method="POST" action="{{ route('contact.submit') }}" onsubmit="handleSubmit(event)">
    @csrf
    @if(session('success'))<div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:16px 20px;border-radius:10px;margin-bottom:20px;font-size:15px;font-weight:500;">{{ session('success') }}</div>@endif
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
              <label class="form-label">First Name *</label>
              <input type="text" name="first_name" class="form-input" placeholder="John" required>
            </div>
            <div class="form-group">
              <label class="form-label">Last Name *</label>
              <input type="text" name="last_name" class="form-input" placeholder="Doe" required>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Email Address *</label>
            <input type="email" name="email" class="form-input" placeholder="you@company.com" required>
          </div>
          <div class="form-group">
            <label class="form-label">Phone Number</label>
            <input type="tel" name="phone" class="form-input" placeholder="+234 800 000 0000">
          </div>
          <div class="form-group">
            <label class="form-label">Country *</label>
            <select class="form-input" required>
              <option value="">Select your country</option>
              <option>Nigeria</option><option>Ghana</option><option>Kenya</option>
              <option>South Africa</option><option>Ethiopia</option><option>Tanzania</option>
              <option>Uganda</option><option>Rwanda</option><option>Senegal</option>
              <option>Côte d'Ivoire</option><option>Other</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">I'm interested in *</label>
            <select class="form-input" required>
              <option value="">Select a service</option>
              <option>Smart Home — Residential</option>
              <option>Smart Building — Commercial</option>
              <option>AI Solutions — Business</option>
              <option>AI Solutions — Enterprise</option>
              <option>Smart Energy / Solar Integration</option>
              <option>Custom Project</option>
              <option>General Inquiry</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Message</label>
            <textarea name="message" class="form-input" placeholder="Tell us about your project, goals, or questions..."></textarea>
          </div>
          <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">Send Message</button>
        </form>

        <div id="form-success" style="display:none;text-align:center;padding:32px 0;">
          <div style="font-size:48px;margin-bottom:16px;">✅</div>
          <h3 style="font-size:20px;font-weight:600;color:var(--dark);margin-bottom:8px;">Message Sent!</h3>
          <p style="font-size:15px;color:var(--gray-600);">Thank you for reaching out. We'll get back to you within 24 hours.</p>
        </div>
      </div>
    </div>
  </div>
</section>



<script>
function handleSubmit(e) {
  e.preventDefault();
  document.getElementById('contact-form').style.display = 'none';
  document.getElementById('form-success').style.display = 'block';
}
</script>
</x-app-layout>
