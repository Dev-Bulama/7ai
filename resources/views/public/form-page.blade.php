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
