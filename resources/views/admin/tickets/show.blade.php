<x-admin-layout title="Ticket #{{ $ticket->ticket_number }}">
<style>
  .back{font-size:13px;color:#6b7280;text-decoration:none;margin-bottom:20px;display:inline-block;}
  .layout{display:grid;grid-template-columns:1fr 300px;gap:24px;align-items:start;}
  .card{background:#fff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden;margin-bottom:20px;}
  .card-head{padding:18px 24px;border-bottom:1px solid #f3f4f6;display:flex;justify-content:space-between;align-items:center;}
  .card-head h3{font-size:15px;font-weight:600;color:#0d1b2a;}
  .card-body{padding:20px 24px;}
  .ticket-subject{font-size:18px;font-weight:700;color:#0d1b2a;margin-bottom:8px;}
  .ticket-desc{font-size:14px;color:#6b7280;line-height:1.6;white-space:pre-wrap;background:#f9fafb;border-radius:8px;padding:16px;margin-top:12px;}
  .reply-item{padding:16px 0;border-bottom:1px solid #f3f4f6;}
  .reply-item:last-child{border-bottom:none;}
  .reply-item.staff{background:#f0f9ff;margin:0 -24px;padding:16px 24px;border-left:3px solid #0B4F6C;}
  .reply-header{display:flex;justify-content:space-between;margin-bottom:8px;}
  .reply-author{font-size:13px;font-weight:600;color:#0d1b2a;}
  .reply-time{font-size:12px;color:#9ca3af;}
  .reply-body{font-size:14px;color:#374151;line-height:1.5;}
  .badge{display:inline-flex;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;}
  .badge-blue{background:#dbeafe;color:#1d4ed8;}
  .badge-green{background:#dcfce7;color:#166534;}
  .badge-yellow{background:#fef9c3;color:#854d0e;}
  .badge-red{background:#fee2e2;color:#991b1b;}
  .badge-gray{background:#f3f4f6;color:#6b7280;}
  label{display:block;font-size:13px;font-weight:500;color:#374151;margin-bottom:6px;}
  select,textarea{width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;outline:none;}
  select:focus,textarea:focus{border-color:#0B4F6C;}
  textarea{min-height:100px;resize:vertical;}
  .form-group{margin-bottom:16px;}
  .btn{padding:10px 20px;background:#0B4F6C;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;width:100%;}
  .btn:hover{background:#093d56;}
  .detail-row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #f9fafb;font-size:13px;}
  .detail-row:last-child{border-bottom:none;}
  .detail-label{color:#9ca3af;}
  .detail-val{color:#0d1b2a;font-weight:500;text-align:right;}
</style>

<a href="{{ route('admin.tickets.index') }}" class="back">← Back to Tickets</a>

<div class="layout">
  <div>
    <div class="card">
      <div class="card-head">
        <h3>{{ $ticket->ticket_number }}</h3>
        @php $sc=['open'=>'badge-blue','in_progress'=>'badge-yellow','waiting'=>'badge-yellow','resolved'=>'badge-green','closed'=>'badge-gray'][$ticket->status] ?? 'badge-gray' @endphp
        <span class="badge {{ $sc }}">{{ ucfirst(str_replace('_',' ',$ticket->status)) }}</span>
      </div>
      <div class="card-body">
        <div class="ticket-subject">{{ $ticket->subject }}</div>
        <div class="ticket-desc">{{ $ticket->description }}</div>
      </div>
    </div>

    @if($ticket->replies->count())
    <div class="card">
      <div class="card-head"><h3>Conversation ({{ $ticket->replies->count() }})</h3></div>
      <div class="card-body">
        @foreach($ticket->replies as $reply)
        <div class="reply-item {{ $reply->is_staff ? 'staff' : '' }}">
          <div class="reply-header">
            <div class="reply-author">
              {{ $reply->is_staff ? '7AI Support' : ($reply->user->name ?? 'Customer') }}
              @if($reply->is_staff)<span style="font-size:10px;background:#dbeafe;color:#1d4ed8;padding:2px 5px;border-radius:3px;margin-left:4px;">STAFF</span>@endif
            </div>
            <div class="reply-time">{{ $reply->created_at->format('M d, Y g:i A') }}</div>
          </div>
          <div class="reply-body">{{ $reply->content }}</div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    <div class="card">
      <div class="card-head"><h3>Reply to Customer</h3></div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.tickets.reply', $ticket) }}">
          @csrf
          <div class="form-group">
            <textarea name="content" placeholder="Type your response..." required></textarea>
          </div>
          <div style="display:flex;gap:12px;align-items:center;">
            <button type="submit" class="btn" style="width:auto;padding:10px 24px;">Send Reply</button>
            <label style="display:flex;align-items:center;gap:6px;font-size:13px;color:#6b7280;margin:0;">
              <input type="checkbox" name="is_internal" value="1"> Internal note only
            </label>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div>
    <div class="card">
      <div class="card-head"><h3>Ticket Details</h3></div>
      <div class="card-body">
        <div class="detail-row"><span class="detail-label">Submitted by</span><span class="detail-val">{{ $ticket->user->name ?? $ticket->guest_name ?? 'Guest' }}</span></div>
        <div class="detail-row"><span class="detail-label">Email</span><span class="detail-val" style="font-size:12px;">{{ $ticket->user->email ?? $ticket->guest_email ?? '—' }}</span></div>
        <div class="detail-row"><span class="detail-label">Priority</span>
          <span class="detail-val">
            @php $pc=['low'=>'badge-gray','medium'=>'badge-blue','high'=>'badge-yellow','urgent'=>'badge-red'][$ticket->priority] ?? 'badge-gray' @endphp
            <span class="badge {{ $pc }}">{{ ucfirst($ticket->priority) }}</span>
          </span>
        </div>
        <div class="detail-row"><span class="detail-label">Category</span><span class="detail-val">{{ $ticket->category ?? '—' }}</span></div>
        <div class="detail-row"><span class="detail-label">Created</span><span class="detail-val">{{ $ticket->created_at->format('M d, Y') }}</span></div>
      </div>
    </div>

    <div class="card">
      <div class="card-head"><h3>Update Status</h3></div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.tickets.update', $ticket) }}">
          @csrf @method('PUT')
          <div class="form-group">
            <label>Status</label>
            <select name="status">
              @foreach(['open','in_progress','waiting','resolved','closed'] as $s)
                <option value="{{ $s }}" {{ $ticket->status===$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>
</x-admin-layout>
