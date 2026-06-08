<x-admin-layout title="New Campaign">
<div style="max-width:900px;">
  <div class="card" style="margin-bottom:20px;background:rgba(11,79,108,0.04);border-color:rgba(11,79,108,0.2);">
    <div style="font-size:14px;font-weight:700;color:var(--teal);margin-bottom:12px;">🤖 AI Campaign Generator</div>
    <div class="form-grid">
      <div class="form-group"><label class="form-label">Campaign Goal</label><input type="text" id="ai_goal" class="form-input" placeholder="e.g. Promote Smart Home Package"></div>
      <div class="form-group"><label class="form-label">Target Audience</label><input type="text" id="ai_audience" class="form-input" placeholder="e.g. Homeowners in Lagos"></div>
      <div class="form-group"><label class="form-label">Tone</label>
        <select id="ai_tone" class="form-input"><option>Professional</option><option>Friendly</option><option>Urgent</option><option>Educational</option></select>
      </div>
      <div class="form-group"><label class="form-label">Offer / Hook</label><input type="text" id="ai_offer" class="form-input" placeholder="e.g. Free consultation, 20% off"></div>
    </div>
    <div style="margin-bottom:12px;"><label class="form-label">Quick Prompts</label><div style="display:flex;flex-wrap:wrap;gap:8px;">
      <button type="button" class="btn btn-outline btn-sm" onclick="setPrompt('Promote AI Smart Home Package','Homeowners in Nigeria','Friendly','Free installation consultation')">Smart Home Package</button>
      <button type="button" class="btn btn-outline btn-sm" onclick="setPrompt('Generate lead nurturing sequence','B2B decision makers','Professional','Free AI assessment')">Lead Nurture</button>
      <button type="button" class="btn btn-outline btn-sm" onclick="setPrompt('Re-engage inactive subscribers','Past leads','Friendly','Special comeback offer')">Re-engagement</button>
      <button type="button" class="btn btn-outline btn-sm" onclick="setPrompt('Upsell premium subscription','Existing customers','Professional','Upgrade discount')">Upsell</button>
    </div></div>
    <button type="button" class="btn btn-primary" onclick="generateAI()" id="ai-btn">Generate with AI ✨</button>
    <span id="ai-status" style="margin-left:12px;font-size:13px;color:var(--gray-500);"></span>
  </div>

  <div class="card">
    <form method="POST" action="{{ route('admin.campaigns.store') }}">
      @csrf
      <div class="form-grid">
        <div class="form-group"><label class="form-label">Campaign Name *</label><input name="name" class="form-input" value="{{ old('name') }}" required></div>
        <div class="form-group"><label class="form-label">Type *</label>
          <select name="type" class="form-input">@foreach(['newsletter','promotional','drip','transactional','automated'] as $t)<option>{{ $t }}</option>@endforeach</select>
        </div>
        <div class="form-group"><label class="form-label">Subject Line *</label><input name="subject" id="f_subject" class="form-input" value="{{ old('subject') }}" required></div>
        <div class="form-group"><label class="form-label">Preview Text</label><input name="preview_text" id="f_preview" class="form-input" value="{{ old('preview_text') }}"></div>
        <div class="form-group"><label class="form-label">From Name *</label><input name="from_name" class="form-input" value="{{ old('from_name','7AI Technologies') }}" required></div>
        <div class="form-group"><label class="form-label">From Email *</label><input name="from_email" type="email" class="form-input" value="{{ old('from_email','hello@7ai.africa') }}" required></div>
        <div class="form-group"><label class="form-label">Subscriber List</label>
          <select name="subscriber_list_id" class="form-input"><option value="">— All Subscribers —</option>@foreach($lists as $l)<option value="{{ $l->id }}">{{ $l->name }}</option>@endforeach</select>
        </div>
        <div class="form-group"><label class="form-label">Status</label>
          <select name="status" class="form-input"><option value="draft">Draft</option><option value="scheduled">Scheduled</option></select>
        </div>
        <div class="form-group"><label class="form-label">Schedule Date/Time</label><input name="scheduled_at" type="datetime-local" class="form-input"></div>
      </div>
      <div class="form-group"><label class="form-label">Email Content *</label><textarea name="content" id="f_content" class="form-input" style="min-height:300px;" required>{{ old('content') }}</textarea></div>
      <div style="display:flex;gap:12px;margin-top:8px;">
        <button type="submit" class="btn btn-primary">Save Campaign</button>
        <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>
<script>
function setPrompt(goal,audience,tone,offer){
  document.getElementById('ai_goal').value=goal;
  document.getElementById('ai_audience').value=audience;
  document.getElementById('ai_tone').value=tone;
  document.getElementById('ai_offer').value=offer;
}
function generateAI(){
  const btn=document.getElementById('ai-btn');
  const status=document.getElementById('ai-status');
  btn.disabled=true; btn.textContent='Generating...'; status.textContent='Please wait...';
  fetch('{{ route("admin.campaigns.ai-generate") }}',{
    method:'POST',
    headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
    body:JSON.stringify({
      goal:document.getElementById('ai_goal').value,
      audience:document.getElementById('ai_audience').value,
      tone:document.getElementById('ai_tone').value,
      offer:document.getElementById('ai_offer').value
    })
  }).then(r=>r.json()).then(data=>{
    document.getElementById('f_subject').value=data.subject;
    document.getElementById('f_preview').value=data.preview;
    document.getElementById('f_content').value=data.body;
    btn.disabled=false; btn.textContent='Generate with AI ✨';
    status.textContent='✓ Content generated!'; status.style.color='#15803D';
  }).catch(()=>{btn.disabled=false;btn.textContent='Generate with AI ✨';status.textContent='Failed. Try again.';status.style.color='#B91C1C';});
}
</script>
</x-admin-layout>
