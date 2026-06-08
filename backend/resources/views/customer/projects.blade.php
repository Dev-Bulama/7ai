<x-customer-layout title="My Projects">
<style>
  .projects-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:24px;}
  .project-card{background:#fff;border-radius:12px;border:1px solid #e5e7eb;padding:24px;}
  .project-card h3{font-size:16px;font-weight:600;color:#0d1b2a;margin-bottom:6px;}
  .project-type{font-size:12px;color:#9ca3af;margin-bottom:12px;}
  .project-desc{font-size:14px;color:#6b7280;margin-bottom:16px;line-height:1.5;}
  .project-meta{display:flex;gap:16px;font-size:12px;color:#9ca3af;border-top:1px solid #f3f4f6;padding-top:12px;}
  .badge{display:inline-flex;align-items:center;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;}
  .badge-green{background:#dcfce7;color:#166534;}
  .badge-blue{background:#dbeafe;color:#1d4ed8;}
  .badge-yellow{background:#fef9c3;color:#854d0e;}
  .badge-gray{background:#f3f4f6;color:#6b7280;}
  .empty-state{text-align:center;padding:80px 20px;background:#fff;border-radius:12px;border:1px solid #e5e7eb;}
  .empty-state h3{font-size:18px;font-weight:600;color:#0d1b2a;margin-bottom:8px;}
  .empty-state p{font-size:14px;color:#9ca3af;}
  .progress-bar{height:6px;background:#f3f4f6;border-radius:3px;margin-top:8px;}
  .progress-fill{height:100%;background:#3EE07F;border-radius:3px;}
</style>

@if($projects->count())
<div class="projects-grid">
  @foreach($projects as $p)
  <div class="project-card">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
      <h3>{{ $p->name }}</h3>
      @php $sc=['planning'=>'badge-blue','in_progress'=>'badge-yellow','completed'=>'badge-green','on_hold'=>'badge-gray','installation'=>'badge-yellow'][$p->status] ?? 'badge-gray' @endphp
      <span class="badge {{ $sc }}">{{ ucfirst(str_replace('_',' ',$p->status)) }}</span>
    </div>
    <div class="project-type">{{ $p->type ?? 'General Project' }}</div>
    @if($p->description)
      <div class="project-desc">{{ Str::limit($p->description, 100) }}</div>
    @endif
    @if($p->location)
      <div style="font-size:12px;color:#6b7280;margin-bottom:12px;">📍 {{ $p->location }}</div>
    @endif
    <div class="project-meta">
      @if($p->start_date) <span>Start: {{ \Carbon\Carbon::parse($p->start_date)->format('M Y') }}</span> @endif
      @if($p->end_date) <span>End: {{ \Carbon\Carbon::parse($p->end_date)->format('M Y') }}</span> @endif
      @if($p->budget) <span>Budget: ${{ number_format($p->budget, 0) }}</span> @endif
    </div>
  </div>
  @endforeach
</div>
@else
<div class="empty-state">
  <div style="font-size:48px;margin-bottom:16px;">🏗️</div>
  <h3>No projects yet</h3>
  <p>Once your project begins, you'll be able to track its progress here.</p>
</div>
@endif
</x-customer-layout>
