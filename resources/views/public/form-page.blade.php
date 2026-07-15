<x-app-layout :title="($form->title ?: $form->name).' — '.($settings['site_name'] ?? '7AI')" :description="$form->description ?? ''">

@php
  $paystackKey = \App\Models\Setting::get('paystack_public_key');
  $hasOptionPrices = $form->fields->where('is_active', true)->contains(fn($f) => !empty($f->option_prices) && in_array($f->field_type, ['select','radio']));
  $paymentEnabled = $form->payment_enabled && $paystackKey && ($form->payment_amount > 0 || $hasOptionPrices);
  $amountKobo = (int)($form->payment_amount * 100);
  $currency = $form->payment_currency ?: 'NGN';
  $currencySymbol = ['NGN'=>'₦','GHS'=>'₵','KES'=>'KSh','USD'=>'$','ZAR'=>'R'][$currency] ?? $currency;

  // Bank transfer details
  $bankName    = \App\Models\Setting::get('bank_name','');
  $bankAccNum  = \App\Models\Setting::get('bank_account_number','');
  $bankAccName = \App\Models\Setting::get('bank_account_name','');
  $showPaystack = \App\Models\Setting::get('show_paystack_option','1') !== '0';
  $showTransfer = $bankName && $bankAccNum && $bankAccName;

  // LearnAI content from settings
  $la = fn($k,$d='') => \App\Models\Setting::get($k,$d);
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
    @if($paymentEnabled && $form->payment_amount > 0)
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
    {{ $la('learnai_tagline','TWO COURSES. TWO DAYS. ONE DECISION.') }}
  </h2>
  <p style="font-size:clamp(15px,2vw,17px);color:rgba(255,255,255,0.65);line-height:1.8;max-width:620px;margin:0 auto 28px;">
    {!! nl2br(e($la('learnai_intro','Are you still doing everything manually? AI is already doing the work of an entire team for creators and business owners who know how to use it. In just 3 hours, we will show you exactly how.'))) !!}
  </p>
  <a href="#register"
    style="display:inline-block;padding:15px 36px;background:#3ee07f;color:#0a1628;font-family:'DM Mono',monospace;font-size:11px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;border-radius:2px;text-decoration:none;transition:background 0.2s;"
    onmouseover="this.style.background='#62e896'" onmouseout="this.style.background='#3ee07f'">
    Register for a Course →
  </a>
</div>

{{-- Course cards --}}
<div style="background:#060e1c;padding:64px 6vw;">
  <div style="max-width:1100px;margin:0 auto;display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,480px),1fr));gap:28px;">

    {{-- COURSE 1 --}}
    @php
      $c1Items = array_filter(array_map('trim', explode("\n", $la('learnai_c1_items',"Generate 30 days of content in one session\nWrite captions, scripts, and hooks with AI\nCreate stunning visuals without a designer\nSchedule, repurpose, and automate your content pipeline\nBuild your personal content brand faster than ever"))));
    @endphp
    <div style="border:0.5px solid rgba(62,224,127,0.25);border-radius:4px;overflow:hidden;display:flex;flex-direction:column;">
      <div style="background:linear-gradient(135deg,rgba(62,224,127,0.12),rgba(62,224,127,0.04));padding:32px 32px 24px;border-bottom:0.5px solid rgba(62,224,127,0.2);">
        <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.2em;color:#3ee07f;margin-bottom:14px;text-transform:uppercase;">Course 1</div>
        <h3 style="font-family:'Playfair Display',serif;font-size:clamp(22px,3vw,30px);font-weight:800;color:#fff;margin:0 0 6px;line-height:1.15;">{{ $la('learnai_c1_name','AI for Content Creators') }}</h3>
        <p style="font-size:13px;font-weight:400;color:rgba(255,255,255,0.5);margin:0;font-style:italic;">{{ $la('learnai_c1_subtitle','From Blank Page to Viral Post — With AI') }}</p>
      </div>
      <div style="padding:28px 32px;flex:1;display:flex;flex-direction:column;gap:24px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <div style="background:rgba(255,255,255,0.03);border:0.5px solid rgba(255,255,255,0.07);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(255,255,255,0.35);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">DATE</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.85);font-weight:500;">{{ $la('learnai_c1_date','Friday, 24th July 2026') }}</div>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:0.5px solid rgba(255,255,255,0.07);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(255,255,255,0.35);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">TIME</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.85);font-weight:500;">{{ $la('learnai_c1_time','5:00 PM – 8:00 PM') }}</div>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:0.5px solid rgba(255,255,255,0.07);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(255,255,255,0.35);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">FORMAT</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.85);font-weight:500;">{{ $la('learnai_c1_format','100% Virtual') }}</div>
          </div>
          <div style="background:rgba(62,224,127,0.08);border:0.5px solid rgba(62,224,127,0.3);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(62,224,127,0.6);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">FEE</div>
            <div style="font-size:16px;color:#3ee07f;font-weight:800;font-family:'DM Mono',monospace;">{{ $la('learnai_c1_fee','₦100,000') }}</div>
          </div>
        </div>
        <div>
          <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.18em;color:rgba(255,255,255,0.35);text-transform:uppercase;margin-bottom:14px;">What You Will Learn</div>
          <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
            @foreach($c1Items as $item)
            <li style="display:flex;align-items:flex-start;gap:10px;font-size:14px;color:rgba(255,255,255,0.7);line-height:1.5;">
              <span style="color:#3ee07f;font-size:12px;margin-top:3px;flex-shrink:0;">—</span>{{ $item }}
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>

    {{-- COURSE 2 --}}
    @php
      $c2Items = array_filter(array_map('trim', explode("\n", $la('learnai_c2_items',"Automate customer service, follow-ups, and lead generation\nUse AI to write proposals, invoices, and business documents\nBuild workflows that run your business while you sleep\nCut costs, save time, and grow revenue with AI tools\nPractical tools you can deploy in your business from Monday"))));
    @endphp
    <div style="border:0.5px solid rgba(168,205,184,0.2);border-radius:4px;overflow:hidden;display:flex;flex-direction:column;">
      <div style="background:linear-gradient(135deg,rgba(168,205,184,0.1),rgba(168,205,184,0.03));padding:32px 32px 24px;border-bottom:0.5px solid rgba(168,205,184,0.18);">
        <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.2em;color:#a8cdb8;margin-bottom:14px;text-transform:uppercase;">Course 2</div>
        <h3 style="font-family:'Playfair Display',serif;font-size:clamp(22px,3vw,30px);font-weight:800;color:#fff;margin:0 0 6px;line-height:1.15;">{{ $la('learnai_c2_name','AI for Business Owners') }}</h3>
        <p style="font-size:13px;font-weight:400;color:rgba(255,255,255,0.5);margin:0;font-style:italic;">{{ $la('learnai_c2_subtitle','Automate Your Business. Multiply Your Output.') }}</p>
      </div>
      <div style="padding:28px 32px;flex:1;display:flex;flex-direction:column;gap:24px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <div style="background:rgba(255,255,255,0.03);border:0.5px solid rgba(255,255,255,0.07);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(255,255,255,0.35);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">DATE</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.85);font-weight:500;">{{ $la('learnai_c2_date','Friday, 31st July 2026') }}</div>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:0.5px solid rgba(255,255,255,0.07);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(255,255,255,0.35);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">TIME</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.85);font-weight:500;">{{ $la('learnai_c2_time','5:00 PM – 8:00 PM') }}</div>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:0.5px solid rgba(255,255,255,0.07);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(255,255,255,0.35);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">FORMAT</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.85);font-weight:500;">{{ $la('learnai_c2_format','100% Virtual') }}</div>
          </div>
          <div style="background:rgba(168,205,184,0.08);border:0.5px solid rgba(168,205,184,0.3);border-radius:3px;padding:12px 14px;">
            <div style="font-size:10px;color:rgba(168,205,184,0.6);font-family:'DM Mono',monospace;letter-spacing:0.1em;margin-bottom:4px;">FEE</div>
            <div style="font-size:16px;color:#a8cdb8;font-weight:800;font-family:'DM Mono',monospace;">{{ $la('learnai_c2_fee','₦140,000') }}</div>
          </div>
        </div>
        <div>
          <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.18em;color:rgba(255,255,255,0.35);text-transform:uppercase;margin-bottom:14px;">What You Will Learn</div>
          <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
            @foreach($c2Items as $item)
            <li style="display:flex;align-items:flex-start;gap:10px;font-size:14px;color:rgba(255,255,255,0.7);line-height:1.5;">
              <span style="color:#a8cdb8;font-size:12px;margin-top:3px;flex-shrink:0;">—</span>{{ $item }}
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
    @php $benefits = array_filter(array_map('trim', explode("\n", $la('learnai_benefits',"Live virtual session with expert facilitators\nRecording access after the class\n7Ai Academy Certificate of Completion\nPrivate community access for ongoing support")))); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;text-align:left;">
      @foreach($benefits as $benefit)
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
    <p style="font-size:13px;font-weight:700;color:#3ee07f;letter-spacing:0.06em;text-transform:uppercase;margin:0 0 18px;">{{ $la('learnai_contact_note','Seats are strictly limited. Early registration is advised.') }}</p>
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
    {{-- Success handled by popup below --}}
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
              @if($paymentEnabled && $field->option_prices) data-price-driver="1" data-option-prices="{{ json_encode($field->option_prices) }}" @endif
              style="width:100%;padding:14px 16px;background:rgba(255,255,255,0.04);border:0.5px solid rgba(122,174,142,0.3);border-radius:2px;color:#fff;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:300;outline:none;transition:border-color 0.2s;appearance:none;"
              onfocus="this.style.borderColor='#a8cdb8'" onblur="this.style.borderColor='rgba(122,174,142,0.3)'"
              onchange="updatePrice(this)">
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
              @if($field->field_type === 'email' && $form->discount_enabled) data-discount-email="1" @endif
              style="width:100%;padding:14px 16px;background:rgba(255,255,255,0.04);border:0.5px solid rgba(122,174,142,0.3);border-radius:2px;color:#fff;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:300;outline:none;transition:border-color 0.2s;box-sizing:border-box;"
              onfocus="this.style.borderColor='#a8cdb8'" onblur="this.style.borderColor='rgba(122,174,142,0.3)'">
            @if($field->field_type === 'email' && $form->discount_enabled)
            <div id="discount-notice" style="display:none;margin-top:8px;padding:10px 14px;background:rgba(62,224,127,0.1);border:0.5px solid rgba(62,224,127,0.35);border-radius:3px;font-size:13px;color:#3ee07f;"></div>
            @endif
            @endif
          </div>
          @endforeach
        </div>

        @if($paymentEnabled)
        {{-- PAYMENT BUTTON --}}
        <input type="hidden" name="_payment_method" id="payment-method-field" value="paystack">
        <div style="margin-top:36px;">
          <div style="background:rgba(62,224,127,0.06);border:0.5px solid rgba(62,224,127,0.2);border-radius:4px;padding:16px 20px;margin-bottom:20px;font-size:13px;color:rgba(255,255,255,0.6);">
            🔒 Complete your registration by paying
            <strong id="price-display" style="color:#3ee07f;">{{ $hasOptionPrices && $form->payment_amount == 0 ? 'Select a course above' : $currencySymbol.number_format($form->payment_amount, 0) }}</strong>
            <span id="discount-price-note" style="display:none;font-size:12px;color:rgba(255,255,255,0.4);"></span>
          </div>
          <button type="button" id="paystack-btn" onclick="openPaymentModal()"
            style="width:100%;padding:16px 32px;background:#3ee07f;color:#0a1628;font-family:'DM Mono',monospace;font-size:11px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;border:none;border-radius:2px;cursor:pointer;transition:background 0.2s;"
            onmouseover="this.style.background='#62e896'" onmouseout="this.style.background='#3ee07f'">
            Pay <span id="btn-price-label">{{ $hasOptionPrices && $form->payment_amount == 0 ? '...' : $currencySymbol.number_format($form->payment_amount, 0) }}</span> & Submit →
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
@endif

<script>
// ── Dynamic pricing ────────────────────────────────────────────────────────
var BASE_AMOUNT_KOBO   = {{ $paymentEnabled ? $amountKobo : 0 }};
var CURRENCY_SYMBOL    = '{{ $currencySymbol }}';
var ACTIVE_AMOUNT_KOBO = BASE_AMOUNT_KOBO;
var DISCOUNT_PCT       = 0; // set by real-time discount check

function formatAmount(kobo) {
  return CURRENCY_SYMBOL + Number(kobo / 100).toLocaleString('en-NG', {minimumFractionDigits:0,maximumFractionDigits:0});
}

function refreshPriceDisplay() {
  var effectiveKobo = ACTIVE_AMOUNT_KOBO;
  var discountedKobo = effectiveKobo;
  if (DISCOUNT_PCT > 0 && effectiveKobo > 0) {
    discountedKobo = Math.round(effectiveKobo * (1 - DISCOUNT_PCT / 100));
  }

  var disp = document.getElementById('price-display');
  var lbl  = document.getElementById('btn-price-label');
  var note = document.getElementById('discount-price-note');

  if (DISCOUNT_PCT > 0 && effectiveKobo > 0) {
    var txt = formatAmount(discountedKobo);
    if (disp) disp.textContent = txt;
    if (lbl)  lbl.textContent  = txt;
    if (note) { note.textContent = ' ('+DISCOUNT_PCT+'% conference discount applied — original: '+formatAmount(effectiveKobo)+')'; note.style.display='inline'; }
  } else {
    var txt2 = effectiveKobo > 0 ? formatAmount(effectiveKobo) : 'Select a course above';
    if (disp) disp.textContent = txt2;
    if (lbl)  lbl.textContent  = effectiveKobo > 0 ? formatAmount(effectiveKobo) : '...';
    if (note) note.style.display = 'none';
  }
}

function updatePrice(selectEl) {
  if (!selectEl.dataset.priceDriver) return;
  var prices = {};
  try { prices = JSON.parse(selectEl.dataset.optionPrices || '{}'); } catch(e) {}
  var selected = selectEl.value;
  var price = prices[selected];
  ACTIVE_AMOUNT_KOBO = (price && price > 0) ? Math.round(price * 100) : BASE_AMOUNT_KOBO;
  refreshPriceDisplay();
}

document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('[data-price-driver]').forEach(function(sel) {
    if (sel.value) updatePrice(sel);
  });
});

@if($paymentEnabled)
// ── Payment method modal ───────────────────────────────────────────────────
var BANK_NAME    = '{{ addslashes($bankName) }}';
var BANK_ACC_NUM = '{{ addslashes($bankAccNum) }}';
var BANK_ACC_NAME= '{{ addslashes($bankAccName) }}';
var SHOW_PAYSTACK= {{ $showPaystack ? 'true' : 'false' }};
var SHOW_TRANSFER= {{ $showTransfer ? 'true' : 'false' }};
var FORM_ID      = {{ $form->id }};

function validateForm() {
  var form = document.getElementById('main-form');
  var required = form.querySelectorAll('[required]');
  for (var i = 0; i < required.length; i++) {
    if (!required[i].value.trim()) {
      required[i].focus();
      required[i].style.borderColor = '#f4a0a0';
      alert('Please fill in all required fields first.');
      return false;
    }
  }
  if (ACTIVE_AMOUNT_KOBO <= 0 && BASE_AMOUNT_KOBO <= 0) {
    alert('Please select a course before proceeding to payment.');
    return false;
  }
  return true;
}

function getEffectiveKobo() {
  var k = ACTIVE_AMOUNT_KOBO > 0 ? ACTIVE_AMOUNT_KOBO : BASE_AMOUNT_KOBO;
  if (DISCOUNT_PCT > 0) k = Math.round(k * (1 - DISCOUNT_PCT / 100));
  return k;
}

function openPaymentModal() {
  if (!validateForm()) return;

  // If only Paystack (no transfer details) go straight to Paystack
  if (SHOW_PAYSTACK && !SHOW_TRANSFER) { initiatePayment(); return; }
  // If only transfer (Paystack hidden) show modal with transfer only
  buildAndShowModal();
}

function buildAndShowModal() {
  var kobo = getEffectiveKobo();
  var amtFmt = formatAmount(kobo);

  var paystackCard = SHOW_PAYSTACK ? '<div onclick="closePaymentModal();initiatePayment();" style="cursor:pointer;border:1.5px solid rgba(62,224,127,0.4);border-radius:6px;padding:24px;background:rgba(62,224,127,0.04);transition:border-color 0.2s;" onmouseover="this.style.borderColor=\'#3ee07f\'" onmouseout="this.style.borderColor=\'rgba(62,224,127,0.4)\'">'
    + '<div style="font-family:\'DM Mono\',monospace;font-size:9px;letter-spacing:0.18em;color:#3ee07f;margin-bottom:10px;text-transform:uppercase;">Pay with Card</div>'
    + '<div style="font-size:22px;font-weight:800;color:#fff;margin-bottom:4px;">'+amtFmt+'</div>'
    + '<div style="font-size:13px;color:rgba(255,255,255,0.5);">Debit / credit card via Paystack</div>'
    + '<div style="margin-top:16px;padding:10px 20px;background:#3ee07f;color:#0a1628;font-family:\'DM Mono\',monospace;font-size:10px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;border-radius:2px;text-align:center;">Pay Now →</div>'
    + '</div>' : '';

  var transferCard = SHOW_TRANSFER ? '<div style="border:1.5px solid rgba(168,205,184,0.3);border-radius:6px;padding:24px;background:rgba(168,205,184,0.04);">'
    + '<div style="font-family:\'DM Mono\',monospace;font-size:9px;letter-spacing:0.18em;color:#a8cdb8;margin-bottom:10px;text-transform:uppercase;">Pay via Bank Transfer</div>'
    + '<div style="font-size:22px;font-weight:800;color:#fff;margin-bottom:16px;">'+amtFmt+'</div>'
    + '<div style="display:flex;flex-direction:column;gap:10px;margin-bottom:20px;">'
    + '<div style="display:flex;justify-content:space-between;font-size:13px;"><span style="color:rgba(255,255,255,0.4);">Bank</span><span style="color:#fff;font-weight:500;">'+BANK_NAME+'</span></div>'
    + '<div style="display:flex;justify-content:space-between;font-size:13px;"><span style="color:rgba(255,255,255,0.4);">Account Number</span><span style="color:#fff;font-weight:700;font-family:\'DM Mono\',monospace;font-size:15px;letter-spacing:0.08em;">'+BANK_ACC_NUM+'</span></div>'
    + '<div style="display:flex;justify-content:space-between;font-size:13px;"><span style="color:rgba(255,255,255,0.4);">Account Name</span><span style="color:#fff;font-weight:500;">'+BANK_ACC_NAME+'</span></div>'
    + '</div>'
    + '<button onclick="submitTransfer()" style="width:100%;padding:12px 20px;background:rgba(168,205,184,0.15);color:#a8cdb8;border:0.5px solid rgba(168,205,184,0.4);border-radius:2px;font-family:\'DM Mono\',monospace;font-size:10px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;cursor:pointer;">I\'ve Sent the Transfer →</button>'
    + '<p style="font-size:11px;color:rgba(255,255,255,0.3);margin:8px 0 0;text-align:center;">Use your name as the transfer narration. We will confirm and activate your access.</p>'
    + '</div>' : '';

  var cols = (SHOW_PAYSTACK && SHOW_TRANSFER) ? 'grid-template-columns:1fr 1fr;' : 'grid-template-columns:1fr;max-width:380px;';

  var modal = document.createElement('div');
  modal.id = 'payment-modal';
  modal.style.cssText = 'position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:24px;';
  modal.innerHTML = '<div style="position:absolute;inset:0;background:rgba(6,14,28,0.88);backdrop-filter:blur(6px);" onclick="closePaymentModal()"></div>'
    + '<div style="position:relative;background:#0a1628;border:0.5px solid rgba(122,174,142,0.25);border-radius:8px;padding:36px 32px;width:100%;max-width:700px;box-shadow:0 24px 64px rgba(0,0,0,0.6);">'
    + '<button onclick="closePaymentModal()" style="position:absolute;top:16px;right:16px;background:none;border:none;color:rgba(255,255,255,0.4);font-size:20px;cursor:pointer;padding:4px 8px;">✕</button>'
    + '<h3 style="font-family:\'Playfair Display\',serif;font-size:22px;font-weight:800;color:#fff;margin:0 0 6px;">Choose Payment Method</h3>'
    + '<p style="font-size:13px;color:rgba(255,255,255,0.45);margin:0 0 24px;">Select how you would like to pay for your registration.</p>'
    + '<div style="display:grid;'+cols+'gap:16px;margin:0 auto;">'
    + paystackCard + transferCard
    + '</div></div>';

  document.body.appendChild(modal);
  document.addEventListener('keydown', escCloseModal);
}

function closePaymentModal() {
  var m = document.getElementById('payment-modal');
  if (m) { m.style.opacity='0'; m.style.transition='opacity .2s'; setTimeout(function(){ m.remove(); }, 210); }
  document.removeEventListener('keydown', escCloseModal);
}

function escCloseModal(e) { if (e.key === 'Escape') closePaymentModal(); }

function submitTransfer() {
  document.getElementById('payment-method-field').value = 'transfer';
  closePaymentModal();
  var form = document.getElementById('main-form');
  form.submit();
}

function initiatePayment() {
  var form      = document.getElementById('main-form');
  var emailField = form.querySelector('input[type="email"]') || form.querySelector('[name="email"]');
  var userEmail  = emailField ? emailField.value.trim() : '';
  if (!userEmail) { alert('Please enter your email address first.'); if (emailField) emailField.focus(); return; }

  var btn = document.getElementById('paystack-btn');
  btn.disabled = true;
  var savedHTML = btn.innerHTML;
  btn.innerHTML = 'Opening payment...';

  var kobo = getEffectiveKobo();

  var handler = PaystackPop.setup({
    key:      '{{ $paystackKey }}',
    email:    userEmail,
    amount:   kobo,
    currency: '{{ $currency }}',
    ref:      'PS-' + Date.now() + '-' + Math.floor(Math.random() * 99999),
    label:    '{{ addslashes($form->payment_description ?: $form->name) }}',
    metadata: { form_id: FORM_ID, form_name: '{{ addslashes($form->name) }}' },
    callback: function(response) {
      var refInput   = document.createElement('input');
      refInput.type  = 'hidden'; refInput.name = '_paystack_ref'; refInput.value = response.reference;
      form.appendChild(refInput);
      document.getElementById('payment-method-field').value = 'paystack';
      btn.innerHTML = '✓ Payment confirmed — submitting...';
      form.submit();
    },
    onClose: function() {
      btn.disabled = false;
      btn.innerHTML = savedHTML;
    }
  });
  handler.openIframe();
}
@endif

// ── Real-time discount check ───────────────────────────────────────────────
@if($form->discount_enabled && $form->discount_check_form_id)
var discountCheckTimer = null;
function checkDiscount(emailVal) {
  clearTimeout(discountCheckTimer);
  var notice = document.getElementById('discount-notice');
  if (!emailVal || emailVal.indexOf('@') < 0) {
    DISCOUNT_PCT = 0; refreshPriceDisplay();
    if (notice) notice.style.display = 'none';
    return;
  }
  discountCheckTimer = setTimeout(function() {
    fetch('/api/check-discount?email=' + encodeURIComponent(emailVal) + '&form_id={{ $form->id }}')
      .then(function(r){ return r.json(); })
      .then(function(d) {
        if (d.eligible) {
          DISCOUNT_PCT = d.discount_pct;
          if (notice) {
            notice.textContent = '🎉 Conference attendee discount: ' + d.discount_pct + '% off applied automatically!';
            notice.style.display = 'block';
          }
        } else {
          DISCOUNT_PCT = 0;
          if (notice) notice.style.display = 'none';
        }
        refreshPriceDisplay();
      }).catch(function(){ DISCOUNT_PCT = 0; refreshPriceDisplay(); });
  }, 600);
}

document.addEventListener('DOMContentLoaded', function() {
  var emailEl = document.querySelector('[data-discount-email]');
  if (emailEl) {
    emailEl.addEventListener('input', function(){ checkDiscount(this.value.trim()); });
    emailEl.addEventListener('blur',  function(){ checkDiscount(this.value.trim()); });
  }
});
@endif
</script>

{{-- ── Success popup modal ───────────────────────────────────────────────── --}}
@if(session('success'))
<div id="success-modal" style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:24px;">
  <div style="position:absolute;inset:0;background:rgba(6,14,28,0.85);backdrop-filter:blur(6px);" onclick="closeSuccessModal()"></div>
  <div style="position:relative;background:#0a1628;border:0.5px solid rgba(62,224,127,0.4);border-radius:8px;padding:48px 40px;max-width:480px;width:100%;text-align:center;box-shadow:0 24px 64px rgba(0,0,0,0.6);">
    <div style="width:56px;height:56px;border-radius:50%;background:rgba(62,224,127,0.12);border:1.5px solid #3ee07f;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:24px;">✓</div>
    <h2 style="font-family:'Playfair Display',serif;font-size:26px;font-weight:800;color:#fff;margin:0 0 12px;">You're registered!</h2>
    <p style="font-size:15px;color:rgba(255,255,255,0.65);line-height:1.7;margin:0 0 28px;">{{ session('success') }}</p>
    <button onclick="closeSuccessModal()"
      style="padding:13px 36px;background:#3ee07f;color:#0a1628;border:none;border-radius:2px;font-family:'DM Mono',monospace;font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;cursor:pointer;">
      Done
    </button>
  </div>
</div>
<script>
function closeSuccessModal() {
  var m = document.getElementById('success-modal');
  if (m) { m.style.opacity='0'; m.style.transition='opacity .25s'; setTimeout(function(){ m.remove(); }, 260); }
}
// Close on Escape
document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeSuccessModal(); });
</script>
@endif

@if(session('error'))
<div id="error-modal" style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:24px;">
  <div style="position:absolute;inset:0;background:rgba(6,14,28,0.85);backdrop-filter:blur(6px);" onclick="closeErrorModal()"></div>
  <div style="position:relative;background:#0a1628;border:0.5px solid rgba(244,160,160,0.4);border-radius:8px;padding:48px 40px;max-width:480px;width:100%;text-align:center;box-shadow:0 24px 64px rgba(0,0,0,0.6);">
    <div style="width:56px;height:56px;border-radius:50%;background:rgba(200,80,80,0.12);border:1.5px solid #f4a0a0;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:24px;">✗</div>
    <h2 style="font-family:'Playfair Display',serif;font-size:24px;font-weight:800;color:#fff;margin:0 0 12px;">Something went wrong</h2>
    <p style="font-size:15px;color:rgba(255,255,255,0.65);line-height:1.7;margin:0 0 28px;">{{ session('error') }}</p>
    <button onclick="closeErrorModal()"
      style="padding:13px 36px;background:rgba(244,160,160,0.15);color:#f4a0a0;border:0.5px solid rgba(244,160,160,0.4);border-radius:2px;font-family:'DM Mono',monospace;font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;cursor:pointer;">
      Close
    </button>
  </div>
</div>
<script>
function closeErrorModal() {
  var m = document.getElementById('error-modal');
  if (m) { m.style.opacity='0'; m.style.transition='opacity .25s'; setTimeout(function(){ m.remove(); }, 260); }
}
document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeErrorModal(); });
</script>
@endif

</x-app-layout>
