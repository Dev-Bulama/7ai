<x-admin-layout title="Campaign Details">
<style>
  .back{font-size:13px;color:#6b7280;text-decoration:none;display:inline-block;margin-bottom:20px;}
  .page-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;}
  .page-title{font-size:22px;font-weight:700;color:#0d1b2a;}
  .layout{display:grid;grid-template-columns:1fr 280px;gap:24px;align-items:start;}
  .card{background:#fff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden;margin-bottom:20px;}
  .card-head{padding:18px 24px;border-bottom:1px solid #f3f4f6;}
  .card-head h3{font-size:15px;font-weight:600;color:#0d1b2a;}
  .card-body{padding:24px;}
  .stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;}
  .stat{background:#f9fafb;border-radius:10px;padding:16px;text-align:center;}
  .stat-val{font-size:22px;font-weight:700;color:#0d1b2a;}
  .stat-label{font-size:12px;color:#9ca3af;margin-top:4px;}
  .badge{display:inline-flex;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;}
  .badge-green{background:#dcfce7;color:#166534;}
  .badge-blue{background:#dbeafe;color:#1d4ed8;}
  .badge-yellow{background:#fef9c3;color:#854d0e;}
  .badge-gray{background:#f3f4f6;color:#6b7280;}
  .detail-row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #f9fafb;font-size:13px;}
  .detail-row:last-child{border-bottom:none;}
  .detail-label{color:#9ca3af;}
  .detail-val{color:#0d1b2a;font-weight:500;text-align:right;}
  .preview-box{background:#f9fafb;border-radius:8px;padding:16px;font-size:13px;color:#6b7280;max-height:200px;overflow-y:auto;line-height:1.5;}
  .btn-sm{padding:8px 16px;background:#0B4F6C;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;display:inline-block;}
</style>

<a href="{{ route('admin.campaigns.index') }}" class="back">← Back to Campaigns</a>

<div class="page-header">
  <div>
    <div class="page-title">{{ $campaign->name }}</div>
    <div style="font-size:14px;color:#9ca3af;margin-top:4px;">{{ $campaign->subject }}</div>
  </div>
  <div style="display:flex;gap:12px;">
    <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="btn-sm" style="background:#f9fafb;color:#374151;border:1.5px solid #e5e7eb;">Edit</a>
    @if($campaign->status === 'draft')
      <a href="#" class="btn-sm">Send Campaign</a>
    @endif
  </div>
</div>

<div class="stats-row">
  <div class="stat"><div class="stat-val">{{ number_format($campaign->total_sent) }}</div><div class="stat-label">Sent</div></div>
  <div class="stat"><div class="stat-val">{{ number_format($campaign->total_opened) }}</div><div class="stat-label">Opened</div></div>
  <div class="stat"><div class="stat-val">{{ $campaign->open_rate }}%</div><div class="stat-label">Open Rate</div></div>
  <div class="stat"><div class="stat-val">{{ $campaign->click_rate }}%</div><div class="stat-label">Click Rate</div></div>
</div>

<div class="layout">
  <div class="card">
    <div class="card-head"><h3>Email Preview</h3></div>
    <div class="card-body">
      <div style="margin-bottom:8px;font-size:13px;"><strong>Subject:</strong> {{ $campaign->subject }}</div>
      @if($campaign->preview_text)
        <div style="margin-bottom:12px;font-size:13px;color:#9ca3af;"><strong>Preview:</strong> {{ $campaign->preview_text }}</div>
      @endif
      <div class="preview-box">{!! $campaign->content !!}</div>
    </div>
  </div>

  <div class="card">
    <div class="card-head"><h3>Campaign Info</h3></div>
    <div class="card-body">
      <div class="detail-row"><span class="detail-label">Type</span><span class="detail-val">{{ ucfirst($campaign->type) }}</span></div>
      <div class="detail-row"><span class="detail-label">Status</span>
        <span class="detail-val">
          @php $sc=['draft'=>'badge-gray','scheduled'=>'badge-yellow','sending'=>'badge-blue','sent'=>'badge-green','paused'=>'badge-gray','cancelled'=>'badge-gray'][$campaign->status] ?? 'badge-gray' @endphp
          <span class="badge {{ $sc }}">{{ ucfirst($campaign->status) }}</span>
        </span>
      </div>
      <div class="detail-row"><span class="detail-label">From</span><span class="detail-val">{{ $campaign->from_name }}</span></div>
      <div class="detail-row"><span class="detail-label">List</span><span class="detail-val">{{ $campaign->subscriberList->name ?? 'All Subscribers' }}</span></div>
      <div class="detail-row"><span class="detail-label">Delivered</span><span class="detail-val">{{ number_format($campaign->total_delivered) }}</span></div>
      <div class="detail-row"><span class="detail-label">Bounced</span><span class="detail-val">{{ number_format($campaign->total_bounced) }}</span></div>
      <div class="detail-row"><span class="detail-label">Unsubscribed</span><span class="detail-val">{{ number_format($campaign->total_unsubscribed) }}</span></div>
      @if($campaign->sent_at)
        <div class="detail-row"><span class="detail-label">Sent At</span><span class="detail-val">{{ $campaign->sent_at->format('M d, Y') }}</span></div>
      @endif
      @if($campaign->scheduled_at)
        <div class="detail-row"><span class="detail-label">Scheduled</span><span class="detail-val">{{ $campaign->scheduled_at->format('M d, Y g:i A') }}</span></div>
      @endif
    </div>
  </div>
</div>
</x-admin-layout>
