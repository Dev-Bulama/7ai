<x-customer-layout title="Invoices">
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
  @if($invoices->count())
  <table>
    <thead><tr><th>Invoice #</th><th>Date</th><th>Due Date</th><th>Amount</th><th>Status</th><th></th></tr></thead>
    <tbody>
    @foreach($invoices as $inv)
    <tr>
      <td style="font-weight:600;font-size:13px;">{{ $inv->invoice_number }}</td>
      <td style="color:#9ca3af;">{{ $inv->created_at->format('M d, Y') }}</td>
      <td style="color:#9ca3af;">{{ $inv->due_date ? \Carbon\Carbon::parse($inv->due_date)->format('M d, Y') : '—' }}</td>
      <td style="font-weight:600;">${{ number_format($inv->total, 2) }} {{ $inv->currency }}</td>
      <td>
        @php $sc=['draft'=>'badge-gray','sent'=>'badge-blue','paid'=>'badge-green','overdue'=>'badge-red','cancelled'=>'badge-gray'][$inv->status] ?? 'badge-gray' @endphp
        <span class="badge {{ $sc }}">{{ ucfirst($inv->status) }}</span>
      </td>
      <td>
        @if($inv->status === 'sent')
          <a href="#" style="font-size:13px;color:#0B4F6C;text-decoration:none;font-weight:500;">Pay Now</a>
        @endif
      </td>
    </tr>
    @endforeach
    </tbody>
  </table>
  @else
    <div class="empty">No invoices yet.</div>
  @endif
</div>
</x-customer-layout>
