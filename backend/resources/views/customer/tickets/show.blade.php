<x-customer-layout title="Ticket #{{ $ticket->ticket_number }}">
<style>
  .ticket-header{background:#fff;border-radius:12px;border:1px solid #e5e7eb;padding:24px;margin-bottom:24px;}
  .ticket-subject{font-size:20px;font-weight:700;color:#0d1b2a;margin-bottom:12px;}
  .ticket-meta{display:flex;gap:20px;flex-wrap:wrap;font-size:13px;color:#9ca3af;}
  .badge{display:inline-flex;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;}
  .badge-green{background:#dcfce7;color:#166534;}
  .badge-blue{background:#dbeafe;color:#1d4ed8;}
  .badge-yellow{background:#fef9c3;color:#854d0e;}
  .badge-red{background:#fee2e2;color:#991b1b;}
  .badge-gray{background:#f3f4f6;color:#6b7280;}
  .replies-list{display:flex;flex-direction:column;gap:16px;margin-bottom:24px;}
  .reply-item{background:#fff;border-radius:12px;border:1px solid #e5e7eb;padding:20px;}
  .reply-item.staff{border-left:3px solid #0B4F6C;}
  .reply-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;}
  .reply-author{font-size:13px;font-weight:600;color:#0d1b2a;}
  .reply-time{font-size:12px;color:#9ca3af;}
  .reply-body{font-size:14px;color:#374151;line-height:1.6;white-space:pre-wrap;}
  .reply-form{background:#fff;border-radius:12px;border:1px solid #e5e7eb;padding:24px;}
  .reply-form h3{font-size:15px;font-weight:600;margin-bottom:16px;}
  textarea{width:100%;padding:12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;min-height:120px;resize:vertical;outline:none;}
  textarea:focus{border-color:#0B4F6C;}
  .btn-primary{padding:10px 24px;background:#0B4F6C;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;margin-top:12px;}
  .btn-primary:hover{background:#093d56;}
  .original{background:#f9fafb;border-radius:8px;padding:16px;margin-top:16px;font-size:14px;color:#6b7280;line-height:1.6;}
</style>

<div style="margin-bottom:16px;">
  <a href="{{ route('customer.tickets.index') }}" style="font-size:13px;color:#6b7280;text-decoration:none;">← Back to tickets</a>
</div>

<div class="ticket-header">
  <div class="ticket-subject">{{ $ticket->subject }}</div>
  <div class="ticket-meta">
    <span>Ticket: <strong style="color:#0d1b2a;">{{ $ticket->ticket_number }}</strong></span>
    <span>
      @php $pc=['low'=>'badge-gray','medium'=>'badge-blue','high'=>'badge-yellow','urgent'=>'badge-red'][$ticket->priority] ?? 'badge-gray' @endphp
      <span class="badge {{ $pc }}">{{ ucfirst($ticket->priority) }} Priority</span>
    </span>
    <span>
      @php $sc=['open'=>'badge-blue','in_progress'=>'badge-yellow','waiting'=>'badge-yellow','resolved'=>'badge-green','closed'=>'badge-gray'][$ticket->status] ?? 'badge-gray' @endphp
      <span class="badge {{ $sc }}">{{ ucfirst(str_replace('_',' ',$ticket->status)) }}</span>
    </span>
    <span>Opened {{ $ticket->created_at->diffForHumans() }}</span>
  </div>
  <div class="original">{{ $ticket->description }}</div>
</div>

@if($ticket->replies->count())
<div class="replies-list">
  @foreach($ticket->replies as $reply)
  <div class="reply-item {{ $reply->is_staff ? 'staff' : '' }}">
    <div class="reply-header">
      <div class="reply-author">
        {{ $reply->is_staff ? '7AI Support' : auth()->user()->name }}
        @if($reply->is_staff) <span style="font-size:11px;background:#dbeafe;color:#1d4ed8;padding:2px 6px;border-radius:4px;margin-left:6px;font-weight:600;">Staff</span> @endif
      </div>
      <div class="reply-time">{{ $reply->created_at->format('M d, Y g:i A') }}</div>
    </div>
    <div class="reply-body">{{ $reply->content }}</div>
  </div>
  @endforeach
</div>
@endif

@if(!in_array($ticket->status, ['resolved','closed']))
<div class="reply-form">
  <h3>Add Reply</h3>
  <form method="POST" action="{{ route('customer.tickets.reply', $ticket) }}">
    @csrf
    <textarea name="content" placeholder="Type your message..." required></textarea>
    <br>
    <button type="submit" class="btn-primary">Send Reply</button>
  </form>
</div>
@else
  <div style="text-align:center;padding:24px;color:#9ca3af;font-size:14px;background:#f9fafb;border-radius:12px;">
    This ticket is {{ $ticket->status }}. <a href="{{ route('customer.tickets.create') }}" style="color:#0B4F6C;">Open a new ticket</a> if you need further help.
  </div>
@endif
</x-customer-layout>
