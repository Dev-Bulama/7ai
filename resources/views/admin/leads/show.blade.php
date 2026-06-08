<x-admin-layout title="Lead Details">
<style>
  .back{font-size:13px;color:#6b7280;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-bottom:20px;}
  .detail-grid{display:grid;grid-template-columns:1fr 360px;gap:24px;align-items:start;}
  .card{background:#fff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden;margin-bottom:0;}
  .card-head{padding:20px 24px;border-bottom:1px solid #f3f4f6;}
  .card-head h3{font-size:15px;font-weight:600;color:#0d1b2a;}
  .card-body{padding:24px;}
  .detail-row{display:flex;gap:16px;padding:12px 0;border-bottom:1px solid #f9fafb;font-size:14px;}
  .detail-row:last-child{border-bottom:none;}
  .detail-label{font-weight:500;color:#6b7280;min-width:140px;}
  .detail-val{color:#0d1b2a;}
  .badge{display:inline-flex;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;}
  .badge-blue{background:#dbeafe;color:#1d4ed8;}
  .badge-green{background:#dcfce7;color:#166534;}
  .badge-yellow{background:#fef9c3;color:#854d0e;}
  .badge-gray{background:#f3f4f6;color:#6b7280;}
  .message-box{background:#f9fafb;border-radius:8px;padding:16px;font-size:14px;color:#374151;line-height:1.6;white-space:pre-wrap;}
  label{display:block;font-size:13px;font-weight:500;color:#374151;margin-bottom:6px;}
  select,textarea{width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;outline:none;}
  select:focus,textarea:focus{border-color:#0B4F6C;}
  textarea{min-height:100px;resize:vertical;}
  .form-group{margin-bottom:16px;}
  .btn{padding:10px 20px;background:#0B4F6C;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;}
  .btn:hover{background:#093d56;}
</style>

<a href="{{ route('admin.leads.index') }}" class="back">← Back to Leads</a>

<div class="detail-grid">
  <div class="card">
    <div class="card-head"><h3>Lead Information</h3></div>
    <div class="card-body">
      <div class="detail-row"><span class="detail-label">Name</span><span class="detail-val">{{ $lead->first_name }} {{ $lead->last_name }}</span></div>
      <div class="detail-row"><span class="detail-label">Email</span><span class="detail-val"><a href="mailto:{{ $lead->email }}" style="color:#0B4F6C;">{{ $lead->email }}</a></span></div>
      <div class="detail-row"><span class="detail-label">Phone</span><span class="detail-val">{{ $lead->phone ?? '—' }}</span></div>
      <div class="detail-row"><span class="detail-label">Company</span><span class="detail-val">{{ $lead->company ?? '—' }}</span></div>
      <div class="detail-row"><span class="detail-label">Country</span><span class="detail-val">{{ $lead->country ?? '—' }}</span></div>
      <div class="detail-row"><span class="detail-label">Service Interest</span><span class="detail-val">{{ $lead->service_interest ?? '—' }}</span></div>
      <div class="detail-row"><span class="detail-label">Source</span><span class="detail-val">{{ $lead->source }}</span></div>
      <div class="detail-row"><span class="detail-label">IP Address</span><span class="detail-val">{{ $lead->ip_address ?? '—' }}</span></div>
      <div class="detail-row"><span class="detail-label">Received</span><span class="detail-val">{{ $lead->created_at->format('M d, Y g:i A') }}</span></div>
      @if($lead->message)
      <div style="margin-top:16px;">
        <div class="detail-label" style="margin-bottom:8px;">Message</div>
        <div class="message-box">{{ $lead->message }}</div>
      </div>
      @endif
    </div>
  </div>

  <div>
    <div class="card" style="margin-bottom:20px;">
      <div class="card-head"><h3>Update Status</h3></div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.leads.update', $lead) }}">
          @csrf @method('PUT')
          <div class="form-group">
            <label>Status</label>
            <select name="status">
              @foreach(['new','contacted','qualified','proposal','won','lost'] as $s)
                <option value="{{ $s }}" {{ $lead->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Notes</label>
            <textarea name="notes">{{ $lead->notes }}</textarea>
          </div>
          <button type="submit" class="btn">Update Lead</button>
        </form>
      </div>
    </div>
  </div>
</div>
</x-admin-layout>
