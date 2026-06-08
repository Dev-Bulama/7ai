<x-admin-layout title="Media Library">
<div class="section-header">
  <div class="section-title">Media Library</div>
  <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" style="display:flex;gap:8px;">@csrf
    <input type="file" name="file" class="form-input" style="width:auto;" required>
    <button type="submit" class="btn btn-primary">Upload</button>
  </form>
</div>
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:16px;">
  @forelse($media as $item)
  <div class="card" style="padding:16px;text-align:center;position:relative;">
    @if(str_starts_with($item->mime_type,'image/'))
    <img src="{{ asset('storage/'.$item->path) }}" style="width:100%;height:120px;object-fit:cover;border-radius:6px;margin-bottom:10px;" onerror="this.src='https://via.placeholder.com/180x120?text=Image'">
    @else
    <div style="height:120px;background:var(--gray-100);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:32px;margin-bottom:10px;">📄</div>
    @endif
    <div style="font-size:12px;font-weight:500;color:var(--dark);word-break:break-all;margin-bottom:4px;">{{ Str::limit($item->name,20) }}</div>
    <div style="font-size:11px;color:var(--gray-400);">{{ number_format($item->size/1024,1) }} KB</div>
    <form method="POST" action="{{ route('admin.media.destroy',$item) }}" style="margin-top:8px;">@csrf @method('DELETE')
      <button type="submit" class="btn btn-danger btn-sm" style="width:100%;" onclick="return confirm('Delete?')">Delete</button>
    </form>
  </div>
  @empty
  <div style="grid-column:1/-1;text-align:center;color:var(--gray-400);padding:48px;">No media uploaded yet.</div>
  @endforelse
</div>
</x-admin-layout>
