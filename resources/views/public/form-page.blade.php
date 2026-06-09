<x-app-layout title="{{ $form->title ?? $form->name }} — {{ $settings['site_name'] }}" description="{{ $form->description }}">

<div class="page-hero" style="padding-top:120px;padding-bottom:60px;background:linear-gradient(135deg,var(--teal-dark) 0%,#0a3a52 100%);">
  <div class="section-inner" style="max-width:700px;margin:0 auto;text-align:center;">
    <div class="section-badge" style="display:inline-flex;margin-bottom:16px;">{{ $settings['site_name'] }}</div>
    <h1 style="font-size:clamp(28px,4vw,48px);font-weight:700;color:#fff;letter-spacing:-0.025em;margin-bottom:16px;">{{ $form->title ?? $form->name }}</h1>
    @if($form->subtitle)
    <p style="font-size:17px;color:rgba(255,255,255,0.75);line-height:1.7;max-width:520px;margin:0 auto;">{{ $form->subtitle }}</p>
    @endif
  </div>
</div>

<section class="section" style="padding-top:60px;padding-bottom:80px;background:var(--gray-50);">
  <div class="section-inner" style="max-width:640px;margin:0 auto;">

    @if(session('success'))
    <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:20px 24px;border-radius:12px;margin-bottom:32px;text-align:center;">
      <div style="font-size:20px;margin-bottom:8px;">✓</div>
      <div style="font-size:16px;font-weight:600;">{{ session('success') }}</div>
    </div>
    @endif

    @if(!session('success'))
    <div style="background:#fff;border:1px solid var(--gray-200);border-radius:20px;padding:40px;box-shadow:0 4px 24px rgba(0,0,0,0.06);">
      <form method="POST" action="{{ route('forms.submit', $form) }}">
        @csrf

        @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fca5a5;color:#b91c1c;padding:16px 20px;border-radius:10px;margin-bottom:24px;font-size:14px;">
          <ul style="list-style:none;display:flex;flex-direction:column;gap:4px;">
            @foreach($errors->all() as $error)
            <li>• {{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <div style="display:flex;flex-direction:column;gap:20px;">
          @foreach($form->fields->where('is_active', true) as $field)
          <div>
            <label style="display:block;font-size:14px;font-weight:600;color:var(--dark);margin-bottom:8px;">
              {{ $field->label }}@if($field->is_required)<span style="color:#ef4444;margin-left:2px;">*</span>@endif
            </label>

            @if($field->field_type === 'textarea')
            <textarea name="{{ $field->name }}" rows="4"
              placeholder="{{ $field->placeholder }}"
              style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;color:var(--dark);resize:vertical;font-family:inherit;outline:none;transition:border 0.2s;"
              onfocus="this.style.borderColor='var(--teal)'" onblur="this.style.borderColor='var(--gray-200)'"
              @if($field->is_required) required @endif>{{ old($field->name) }}</textarea>

            @elseif($field->field_type === 'select')
            <select name="{{ $field->name }}"
              style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;color:var(--dark);background:#fff;outline:none;transition:border 0.2s;appearance:none;background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%236b7280' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E\");background-repeat:no-repeat;background-position:right 14px center;"
              @if($field->is_required) required @endif>
              <option value="">Select {{ $field->label }}</option>
              @foreach($field->getOptionsArrayAttribute() as $opt)
              <option value="{{ $opt }}" @if(old($field->name) === $opt) selected @endif>{{ $opt }}</option>
              @endforeach
            </select>

            @elseif($field->field_type === 'radio')
            <div style="display:flex;flex-direction:column;gap:10px;">
              @foreach($field->getOptionsArrayAttribute() as $opt)
              <label style="display:flex;align-items:center;gap:10px;font-size:15px;color:var(--dark);cursor:pointer;">
                <input type="radio" name="{{ $field->name }}" value="{{ $opt }}" @if(old($field->name) === $opt) checked @endif style="width:18px;height:18px;accent-color:var(--teal);" @if($field->is_required) required @endif>
                {{ $opt }}
              </label>
              @endforeach
            </div>

            @elseif($field->field_type === 'checkbox')
            <div style="display:flex;flex-direction:column;gap:10px;">
              @foreach($field->getOptionsArrayAttribute() as $opt)
              <label style="display:flex;align-items:center;gap:10px;font-size:15px;color:var(--dark);cursor:pointer;">
                <input type="checkbox" name="{{ $field->name }}[]" value="{{ $opt }}" style="width:18px;height:18px;accent-color:var(--teal);">
                {{ $opt }}
              </label>
              @endforeach
            </div>

            @else
            <input type="{{ $field->field_type === 'phone' ? 'tel' : $field->field_type }}"
              name="{{ $field->name }}"
              value="{{ old($field->name) }}"
              placeholder="{{ $field->placeholder }}"
              style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;color:var(--dark);outline:none;transition:border 0.2s;box-sizing:border-box;"
              onfocus="this.style.borderColor='var(--teal)'" onblur="this.style.borderColor='var(--gray-200)'"
              @if($field->is_required) required @endif>
            @endif
          </div>
          @endforeach
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;margin-top:32px;padding:14px;font-size:16px;font-weight:600;border-radius:10px;">
          Submit Registration
        </button>
      </form>
    </div>
    @endif

  </div>
</section>

</x-app-layout>
