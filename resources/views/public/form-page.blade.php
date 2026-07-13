<x-app-layout :title="($form->title ?: $form->name).' — '.($settings['site_name'] ?? '7AI')" :description="$form->description ?? ''">

@php
  $paystackKey = \App\Models\Setting::get('paystack_public_key');
  $paymentEnabled = $form->payment_enabled && $paystackKey && $form->payment_amount > 0;
  $amountKobo = (int)($form->payment_amount * 100); // Paystack uses kobo/cents
  $currency = $form->payment_currency ?: 'NGN';
  $currencySymbol = ['NGN'=>'₦','GHS'=>'₵','KES'=>'KSh','USD'=>'$','ZAR'=>'R'][$currency] ?? $currency;
@endphp

<!-- HERO -->
<div style="min-height:40vh;padding:120px 6vw 60px;background:linear-gradient(160deg,#0b4f6c 0%,#0a1628 60%);display:flex;align-items:center;justify-content:center;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;inset:0;background:rgba(10,22,40,0.4);"></div>
  <div style="position:relative;z-index:2;max-width:640px;">
    <div style="display:inline-flex;align-items:center;gap:10px;margin-bottom:24px;">
      <div style="width:32px;height:1px;background:#3ee07f;"></div>
      <span style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:#3ee07f;">{{ $settings['site_name'] ?? '7AI' }}</span>
      <div style="width:32px;height:1px;background:#3ee07f;"></div>
    </div>
    <h1 style="font-family:'Playfair Display',serif;font-size:clamp(32px,5vw,56px);font-weight:900;color:#fff;line-height:1.05;margin-bottom:16px;">
      {{ $form->title ?: $form->name }}
    </h1>
    @if($form->subtitle)
    <p style="font-size:17px;font-weight:300;color:rgba(255,255,255,0.7);line-height:1.7;max-width:500px;margin:0 auto;">{{ $form->subtitle }}</p>
    @endif
    @if($paymentEnabled)
    <div style="margin-top:20px;display:inline-flex;align-items:center;gap:8px;background:rgba(62,224,127,0.1);border:1px solid rgba(62,224,127,0.3);border-radius:4px;padding:10px 20px;">
      <span style="color:#3ee07f;font-family:'DM Mono',monospace;font-size:11px;letter-spacing:0.1em;">REGISTRATION FEE</span>
      <span style="color:#fff;font-size:20px;font-weight:700;">{{ $currencySymbol }}{{ number_format($form->payment_amount, 0) }}</span>
    </div>
    @endif
  </div>
</div>

@if($form->slug === 'learnai')
{{-- ═══════════════════════════════════════════════════════════════════════
     LEARNAI COURSE DETAILS SECTION
════════════════════════════════════════════════════════════════════════ --}}

{{-- Tagline strip --}}
<div style="background:#0a1628;border-top:1px solid rgba(62,224,127,0.15);border-bottom:1px solid rgba(62,224,127,0.15);padding:40px 6vw;text-align:center;">
  <div style="display:inline-flex;align-items:center;gap:12px;margin-bottom:16px;">
    <div style="width:40px;height:1px;background:rgba(62,224,127,0.4);"></div>
    <span style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.22em;text-transform:uppercase;color:rgba(62,224,127,0.6);">Limited Seats Available</span>
    <div style="width:40px;height:1px;background:rgba(62,224,127,0.4);"></div>
  </div>
  <h2 style="font-family:'Playfair Display',serif;font-size:clamp(26px,4.5vw,46px);font-weight:900;color:#fff;line-height:1.1;margin:0 0 20px;">
    TWO COURSES. TWO DAYS. ONE DECISION.
  </h2>
  <p style="font-size:clamp(15px,2vw,17px);color:rgba(255,255,255,0.65);line-height:1.8;max-width:620px;margin:0 auto 0;">
    Are you still doing everything manually?<br>
    <span style="color:rgba(255,255,255,0.85);">AI is already doing the work of an entire team</span> for creators and business owners who know how to use it. In just 3 hours, we will show you exactly how.
  </p>
</div>

{{-- Course cards --}}
<div style="background:#060e1c;padding:64px 6vw;">
  <div style="max-width:1100px;margin:0 auto;display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,480px),1fr));gap:28px;">

    {{-- COURSE 1 --}}
    <div style="border:0.5px solid rgba(62,224,127,0.25);border-radius:4px;overflow:hidden;display:flex;flex-direction:column;">
      <div style="background:linear-gradient(135deg,rgba(62,224,127,0.12),rgba(62,224,127,0.04));padding:32px 32px 24px;border-bottom:0.5px solid rgba(62,224,127,0.2);">
        <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.2em;color:#3ee07f;margin-bottom:14px;text-transform:uppercase;">Course 1</div>
        <h3 style="font-family:'Playfair Display',serif;font-size:clamp(22px,3vw,30px);font-weight:800;color:#fff;margin:0 0 6px;line-height:1.15;">AI for Content Creators</h3>
        <p style="font-size:13px;font-weight:400;color:rgba(255,255,255,0.5);margin:0;font-style:italic;">From Blank Page to Viral Post — With AI</p>
      </div>
      <div style="padding:28px 32px;flex:1;display:flex;flex-direction:column;gap:24px;">
        {{-- Details row --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <div style="background:rgba(255,255,255,0.03);border:0.5px solid rgba(255,255,255,0.07);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(255,255,255,0.35);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">DATE</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.85);font-weight:500;">Friday, 24th July 2026</div>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:0.5px solid rgba(255,255,255,0.07);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(255,255,255,0.35);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">TIME</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.85);font-weight:500;">5:00 PM – 8:00 PM</div>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:0.5px solid rgba(255,255,255,0.07);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(255,255,255,0.35);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">FORMAT</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.85);font-weight:500;">100% Virtual</div>
          </div>
          <div style="background:rgba(62,224,127,0.08);border:0.5px solid rgba(62,224,127,0.3);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(62,224,127,0.6);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">FEE</div>
            <div style="font-size:16px;color:#3ee07f;font-weight:800;font-family:'DM Mono',monospace;">₦100,000</div>
          </div>
        </div>
        {{-- What you will learn --}}
        <div>
          <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.18em;color:rgba(255,255,255,0.35);text-transform:uppercase;margin-bottom:14px;">What You Will Learn</div>
          <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
            @foreach([
              'Generate 30 days of content in one session',
              'Write captions, scripts, and hooks with AI',
              'Create stunning visuals without a designer',
              'Schedule, repurpose, and automate your content pipeline',
              'Build your personal content brand faster than ever',
            ] as $item)
            <li style="display:flex;align-items:flex-start;gap:10px;font-size:14px;color:rgba(255,255,255,0.7);line-height:1.5;">
              <span style="color:#3ee07f;font-size:12px;margin-top:3px;flex-shrink:0;">—</span>
              {{ $item }}
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>

    {{-- COURSE 2 --}}
    <div style="border:0.5px solid rgba(168,205,184,0.2);border-radius:4px;overflow:hidden;display:flex;flex-direction:column;">
      <div style="background:linear-gradient(135deg,rgba(168,205,184,0.1),rgba(168,205,184,0.03));padding:32px 32px 24px;border-bottom:0.5px solid rgba(168,205,184,0.18);">
        <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.2em;color:#a8cdb8;margin-bottom:14px;text-transform:uppercase;">Course 2</div>
        <h3 style="font-family:'Playfair Display',serif;font-size:clamp(22px,3vw,30px);font-weight:800;color:#fff;margin:0 0 6px;line-height:1.15;">AI for Business Owners</h3>
        <p style="font-size:13px;font-weight:400;color:rgba(255,255,255,0.5);margin:0;font-style:italic;">Automate Your Business. Multiply Your Output.</p>
      </div>
      <div style="padding:28px 32px;flex:1;display:flex;flex-direction:column;gap:24px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <div style="background:rgba(255,255,255,0.03);border:0.5px solid rgba(255,255,255,0.07);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(255,255,255,0.35);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">DATE</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.85);font-weight:500;">Friday, 31st July 2026</div>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:0.5px solid rgba(255,255,255,0.07);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(255,255,255,0.35);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">TIME</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.85);font-weight:500;">5:00 PM – 8:00 PM</div>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:0.5px solid rgba(255,255,255,0.07);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(255,255,255,0.35);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">FORMAT</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.85);font-weight:500;">100% Virtual</div>
          </div>
          <div style="background:rgba(168,205,184,0.08);border:0.5px solid rgba(168,205,184,0.3);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(168,205,184,0.6);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">FEE</div>
            <div style="font-size:16px;color:#a8cdb8;font-weight:800;font-family:'DM Mono',monospace;">₦140,000</div>
          </div>
        </div>
        <div>
          <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.18em;color:rgba(255,255,255,0.35);text-transform:uppercase;margin-bottom:14px;">What You Will Learn</div>
          <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
            @foreach([
              'Automate customer service, follow-ups, and lead generation',
              'Use AI to write proposals, invoices, and business documents',
              'Build workflows that run your business while you sleep',
              'Cut costs, save time, and grow revenue with AI tools',
              'Practical tools you can deploy in your business from Monday',
            ] as $item)
            <li style="display:flex;align-items:flex-start;gap:10px;font-size:14px;color:rgba(255,255,255,0.7);line-height:1.5;">
              <span style="color:#a8cdb8;font-size:12px;margin-top:3px;flex-shrink:0;">—</span>
              {{ $item }}
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>

  </div>
</div>

{{-- Included in both courses --}}
<div style="background:#0a1628;padding:56px 6vw;border-top:1px solid rgba(255,255,255,0.06);border-bottom:1px solid rgba(255,255,255,0.06);">
  <div style="max-width:740px;margin:0 auto;text-align:center;">
    <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.2em;text-transform:uppercase;color:rgba(62,224,127,0.6);margin-bottom:14px;">Included in Both Courses</div>
    <h3 style="font-family:'Playfair Display',serif;font-size:clamp(20px,3vw,28px);font-weight:700;color:#fff;margin:0 0 32px;">Everything You Need to Get Started</h3>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;text-align:left;">
      @foreach([
        'Live virtual session with expert facilitators',
        'Recording access after the class',
        '7Ai Academy Certificate of Completion',
        'Private community access for ongoing support',
      ] as $benefit)
      <div style="display:flex;align-items:flex-start;gap:12px;background:rgba(62,224,127,0.05);border:0.5px solid rgba(62,224,127,0.15);border-radius:3px;padding:16px 18px;">
        <span style="color:#3ee07f;font-size:14px;flex-shrink:0;margin-top:1px;">✅</span>
        <span style="font-size:14px;color:rgba(255,255,255,0.75);line-height:1.5;">{{ $benefit }}</span>
      </div>
      @endforeach
    </div>
  </div>
</div>

{{-- Contact / urgency strip --}}
<div style="background:#060e1c;padding:40px 6vw;text-align:center;">
  <div style="max-width:560px;margin:0 auto;">
    <p style="font-size:13px;font-weight:700;color:#3ee07f;letter-spacing:0.06em;text-transform:uppercase;margin:0 0 18px;">Seats are strictly limited. Early registration is advised.</p>
    <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:20px;font-size:13px;color:rgba(255,255,255,0.55);">
      <span>📲 <a href="https://7ai.africa/learnai" style="color:rgba(255,255,255,0.55);text-decoration:none;">7ai.africa/learnai</a></span>
      <span>✉ <a href="mailto:info@7ai.africa" style="color:rgba(255,255,255,0.55);text-decoration:none;">info@7ai.africa</a></span>
      <span>📞 <a href="tel:+2348065931712" style="color:rgba(255,255,255,0.55);text-decoration:none;">+234 (0) 806 5931 712</a></span>
    </div>
  </div>
</div>

{{-- scroll-to-form anchor --}}
<div id="register" style="scroll-margin-top:80px;"></div>
@endif

<!-- FORM -->
<section style="padding:60px 6vw 100px;background:var(--navy);">
  <div style="max-width:600px;margin:0 auto;">

    @if(session('success'))
    <div style="background:rgba(62,224,127,0.12);border:0.5px solid #3ee07f;border-radius:6px;padding:24px;margin-bottom:32px;text-align:center;">
      <div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:#3ee07f;margin-bottom:8px;">✓ Submitted</div>
      <div style="font-size:15px;color:rgba(255,255,255,0.7);">{{ session('success') }}</div>
    </div>
    @endif

    @if(!session('success'))
    <div style="background:rgba(255,255,255,0.03);border:0.5px solid rgba(122,174,142,0.25);border-radius:6px;padding:40px 40px 48px;">

      @if($errors->any())
      <div style="background:rgba(200,80,80,0.1);border:0.5px solid rgba(200,80,80,0.4);border-radius:4px;padding:14px 20px;color:#f4a0a0;font-size:14px;margin-bottom:24px;">
        <ul style="list-style:none;display:flex;flex-direction:column;gap:4px;">
          @foreach($errors->all() as $error)<li>• {{ $error }}</li>@endforeach
        </ul>
      </div>
      @endif

      @if(session('error'))
      <div style="background:rgba(200,80,80,0.1);border:0.5px solid rgba(200,80,80,0.4);border-radius:4px;padding:14px 20px;color:#f4a0a0;font-size:14px;margin-bottom:24px;">
        ✗ {{ session('error') }}
      </div>
      @endif

      <form method="POST" action="{{ route('forms.submit', $form) }}" id="main-form">
        @csrf
        <div style="display:flex;flex-direction:column;gap:22px;">
          @foreach($form->fields->where('is_active', true) as $field)
          <div>
            <label style="display:block;font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.18em;text-transform:uppercase;color:#3ee07f;margin-bottom:8px;">
              {{ $field->label }}@if($field->is_required) <span style="color:#f4a0a0;">*</span>@endif
            </label>

            @if($field->field_type === 'textarea')
            <textarea name="{{ $field->name }}" rows="4"
              placeholder="{{ $field->placeholder }}"
              @if($field->is_required) required @endif
              style="width:100%;padding:14px 16px;background:rgba(255,255,255,0.04);border:0.5px solid rgba(122,174,142,0.3);border-radius:2px;color:#fff;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:300;outline:none;resize:vertical;transition:border-color 0.2s;"
              onfocus="this.style.borderColor='#a8cdb8'" onblur="this.style.borderColor='rgba(122,174,142,0.3)'">{{ old($field->name) }}</textarea>

            @elseif($field->field_type === 'select')
            <select name="{{ $field->name }}"
              @if($field->is_required) required @endif
              style="width:100%;padding:14px 16px;background:rgba(255,255,255,0.04);border:0.5px solid rgba(122,174,142,0.3);border-radius:2px;color:#fff;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:300;outline:none;transition:border-color 0.2s;appearance:none;"
              onfocus="this.style.borderColor='#a8cdb8'" onblur="this.style.borderColor='rgba(122,174,142,0.3)'">
              <option value="" style="background:#0a1628;">{{ $field->placeholder ?: 'Select '.$field->label }}</option>
              @foreach($field->getOptionsArrayAttribute() as $opt)
              <option value="{{ $opt }}" style="background:#0a1628;" @if(old($field->name) === $opt) selected @endif>{{ $opt }}</option>
              @endforeach
            </select>

            @elseif($field->field_type === 'radio')
            <div style="display:flex;flex-direction:column;gap:12px;padding-top:4px;">
              @foreach($field->getOptionsArrayAttribute() as $opt)
              <label style="display:flex;align-items:center;gap:12px;font-size:14px;color:rgba(255,255,255,0.7);cursor:pointer;font-weight:300;">
                <input type="radio" name="{{ $field->name }}" value="{{ $opt }}"
                  @if(old($field->name) === $opt) checked @endif
                  @if($field->is_required) required @endif
                  style="width:16px;height:16px;accent-color:#3ee07f;">
                {{ $opt }}
              </label>
              @endforeach
            </div>

            @elseif($field->field_type === 'checkbox')
            <div style="display:flex;flex-direction:column;gap:12px;padding-top:4px;">
              @foreach($field->getOptionsArrayAttribute() as $opt)
              <label style="display:flex;align-items:center;gap:12px;font-size:14px;color:rgba(255,255,255,0.7);cursor:pointer;font-weight:300;">
                <input type="checkbox" name="{{ $field->name }}[]" value="{{ $opt }}"
                  style="width:16px;height:16px;accent-color:#3ee07f;">
                {{ $opt }}
              </label>
              @endforeach
            </div>

            @else
            <input type="{{ $field->field_type === 'phone' ? 'tel' : ($field->field_type === 'text' ? 'text' : $field->field_type) }}"
              name="{{ $field->name }}"
              value="{{ old($field->name) }}"
              placeholder="{{ $field->placeholder }}"
              @if($field->is_required) required @endif
              style="width:100%;padding:14px 16px;background:rgba(255,255,255,0.04);border:0.5px solid rgba(122,174,142,0.3);border-radius:2px;color:#fff;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:300;outline:none;transition:border-color 0.2s;box-sizing:border-box;"
              onfocus="this.style.borderColor='#a8cdb8'" onblur="this.style.borderColor='rgba(122,174,142,0.3)'">
            @endif
          </div>
          @endforeach
        </div>

        @if($paymentEnabled)
        {{-- PAYSTACK PAYMENT BUTTON --}}
        <div style="margin-top:36px;">
          <div style="background:rgba(62,224,127,0.06);border:0.5px solid rgba(62,224,127,0.2);border-radius:4px;padding:16px 20px;margin-bottom:20px;font-size:13px;color:rgba(255,255,255,0.6);">
            🔒 Your registration will be confirmed after payment of
            <strong style="color:#3ee07f;">{{ $currencySymbol }}{{ number_format($form->payment_amount, 0) }}</strong>
            via Paystack. Your card details are secured by Paystack.
          </div>
          <button type="button" id="paystack-btn" onclick="initiatePayment()"
            style="width:100%;padding:16px 32px;background:#3ee07f;color:#0a1628;font-family:'DM Mono',monospace;font-size:11px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;border:none;border-radius:2px;cursor:pointer;transition:background 0.2s;"
            onmouseover="this.style.background='#62e896'" onmouseout="this.style.background='#3ee07f'">
            Pay {{ $currencySymbol }}{{ number_format($form->payment_amount, 0) }} & Submit →
          </button>
        </div>
        @else
        <button type="submit"
          style="width:100%;margin-top:36px;padding:16px 32px;background:#a8cdb8;color:#0a1628;font-family:'DM Mono',monospace;font-size:11px;font-weight:500;letter-spacing:0.14em;text-transform:uppercase;border:none;border-radius:2px;cursor:pointer;transition:background 0.2s;"
          onmouseover="this.style.background='#d4ece0'" onmouseout="this.style.background='#a8cdb8'">
          {{ $form->cta_text ?? 'Submit Registration' }} →
        </button>
        @endif
      </form>
    </div>
    @endif

  </div>
</section>

@if($paymentEnabled)
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
function initiatePayment() {
  var form = document.getElementById('main-form');

  // Validate required fields first
  var requiredFields = form.querySelectorAll('[required]');
  for (var i = 0; i < requiredFields.length; i++) {
    if (!requiredFields[i].value.trim()) {
      requiredFields[i].focus();
      requiredFields[i].style.borderColor = '#f4a0a0';
      alert('Please fill in all required fields before proceeding to payment.');
      return;
    }
  }

  // Get email from form
  var emailField = form.querySelector('input[type="email"]') || form.querySelector('[name="email"]');
  var userEmail  = emailField ? emailField.value.trim() : '';
  if (!userEmail) {
    alert('Please enter your email address first.');
    if (emailField) emailField.focus();
    return;
  }

  var btn = document.getElementById('paystack-btn');
  btn.disabled = true;
  btn.textContent = 'Opening payment...';

  var handler = PaystackPop.setup({
    key:      '{{ $paystackKey }}',
    email:    userEmail,
    amount:   {{ $amountKobo }},
    currency: '{{ $currency }}',
    ref:      'PS-' + Date.now() + '-' + Math.floor(Math.random() * 99999),
    label:    '{{ addslashes($form->payment_description ?: $form->name) }}',
    metadata: {
      form_id:   {{ $form->id }},
      form_name: '{{ addslashes($form->name) }}',
    },
    callback: function(response) {
      // Payment successful — inject reference and submit form
      var refInput = document.createElement('input');
      refInput.type  = 'hidden';
      refInput.name  = '_paystack_ref';
      refInput.value = response.reference;
      form.appendChild(refInput);

      btn.textContent = '✓ Payment confirmed — submitting...';
      form.submit();
    },
    onClose: function() {
      btn.disabled = false;
      btn.textContent = 'Pay {{ $currencySymbol }}{{ number_format($form->payment_amount, 0) }} & Submit →';
    }
  });

  handler.openIframe();
}
</script>
@endif

</x-app-layout>
