<x-customer-layout title="Support Tickets">
  <x-slot name="actions">
    <a href="{{ route('customer.tickets.create') }}" class="btn-sm">+ New Ticket</a>
  </x-slot>
<style>
  .section-card{background:#fff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden;}
  table{width:100%;border-collapse:collapse;}
  th{font-size:11px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:0.05em;padding:12px 24px;text-align:left;background:#f9fafb;}
  td{padding:14px 24px;font-size:14px;color:#374151;border-top:1px solid #f3f4f6;}
  .badge{display:inline-flex;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;}
  .badge-green{background:#dcfce7;color:#166534;}
  .badge-blue{background:#dbeafe;color:#1d4ed8;}
  .badge-yellow{background:#fef9c3;color:#854d0e;}
  .badge-red{background:#fee2e2;color:#991b1b;}
  .badge-gray{background:#f3f4f6;color:#6b7280;}
  .empty{padding:60px;text-align:center;color:#9ca3af;}
</style>
<div class="section-card">
  @if($tickets->count())
  <table>
    <thead><tr><th>Ticket #</th><th>Subject</th><th>Priority</th><th>Status</th><th>Last Updated</th></tr></thead>
    <tbody>
    @foreach($tickets as $t)
    <tr>
      <td style="font-family:monospace;font-size:12px;color:#9ca3af;">{{ $t->ticket_number }}</td>
      <td><a href="{{ route('customer.tickets.show',$t) }}" style="color:#0B4F6C;font-weight:500;text-decoration:none;">{{ $t->subject }}</a></td>
      <td>
        @php $pc=['low'=>'badge-gray','medium'=>'badge-blue','high'=>'badge-yellow','urgent'=>'badge-red'][$t->priority] ?? 'badge-gray' @endphp
        <span class="badge {{ $pc }}">{{ ucfirst($t->priority) }}</span>
      </td>
      <td>
        @php $sc=['open'=>'badge-blue','in_progress'=>'badge-yellow','waiting'=>'badge-yellow','resolved'=>'badge-green','closed'=>'badge-gray'][$t->status] ?? 'badge-gray' @endphp
        <span class="badge {{ $sc }}">{{ ucfirst(str_replace('_',' ',$t->status)) }}</span>
      </td>
      <td style="color:#9ca3af;font-size:13px;">{{ $t->updated_at->diffForHumans() }}</td>
    </tr>
    @endforeach
    </tbody>
  </table>
  @else
    <div class="empty">No tickets yet. <a href="{{ route('customer.tickets.create') }}" style="color:#0B4F6C;">Open your first ticket</a></div>
  @endif
</div>
</x-customer-layout>
