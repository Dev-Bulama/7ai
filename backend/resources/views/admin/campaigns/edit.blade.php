<x-admin-layout title="Edit Campaign">
<style>
  .editor-layout{display:grid;grid-template-columns:1fr 300px;gap:24px;align-items:start;}
  .card{background:#fff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden;margin-bottom:20px;}
  .card-head{padding:18px 24px;border-bottom:1px solid #f3f4f6;}
  .card-head h3{font-size:15px;font-weight:600;color:#0d1b2a;}
  .card-body{padding:20px 24px;}
  label{display:block;font-size:13px;font-weight:500;color:#374151;margin-bottom:6px;}
  input[type=text],input[type=email],select,textarea{width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;outline:none;}
  input:focus,select:focus,textarea:focus{border-color:#0B4F6C;}
  textarea{resize:vertical;}
  .form-group{margin-bottom:20px;}
  .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
  .btn-primary{padding:11px 24px;background:#0B4F6C;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;}
  .btn-ghost{padding:11px 24px;background:#f9fafb;color:#374151;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-weight:500;cursor:pointer;font-family:inherit;text-decoration:none;}
</style>
<div style="margin-bottom:20px;"><a href="{{ route('admin.campaigns.show', $campaign) }}" style="font-size:13px;color:#6b7280;text-decoration:none;">← Back to Campaign</a></div>
<form method="POST" action="{{ route('admin.campaigns.update', $campaign) }}">
  @csrf @method('PUT')
  <div class="editor-layout">
    <div>
      <div class="card">
        <div class="card-head"><h3>Campaign Details</h3></div>
        <div class="card-body">
          <div class="form-group"><label>Campaign Name *</label><input type="text" name="name" value="{{ old('name',$campaign->name) }}" required></div>
          <div class="form-group"><label>Email Subject *</label><input type="text" name="subject" value="{{ old('subject',$campaign->subject) }}" required></div>
          <div class="form-group"><label>Preview Text</label><input type="text" name="preview_text" value="{{ old('preview_text',$campaign->preview_text) }}" placeholder="Short preview shown in inbox..."></div>
          <div class="grid-2">
            <div class="form-group"><label>From Name</label><input type="text" name="from_name" value="{{ old('from_name',$campaign->from_name) }}"></div>
            <div class="form-group"><label>From Email</label><input type="email" name="from_email" value="{{ old('from_email',$campaign->from_email) }}"></div>
          </div>
          <div class="form-group">
            <label>Email Content *</label>
            <textarea name="content" rows="18" required>{{ old('content',$campaign->content) }}</textarea>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="card">
        <div class="card-head"><h3>Settings</h3></div>
        <div class="card-body">
          <div class="form-group">
            <label>Campaign Type</label>
            <select name="type">
              @foreach(['newsletter','promotional','drip','transactional','automated'] as $t)
                <option value="{{ $t }}" {{ $campaign->type===$t?'selected':'' }}>{{ ucfirst($t) }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select name="status">
              @foreach(['draft','scheduled','paused','cancelled'] as $s)
                <option value="{{ $s }}" {{ $campaign->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Subscriber List</label>
            <select name="subscriber_list_id">
              <option value="">All subscribers</option>
              @foreach($lists as $list)
                <option value="{{ $list->id }}" {{ $campaign->subscriber_list_id==$list->id?'selected':'' }}>{{ $list->name }}</option>
              @endforeach
            </select>
          </div>
          <div style="display:flex;gap:12px;padding-top:8px;">
            <button type="submit" class="btn-primary" style="flex:1;">Update</button>
            <a href="{{ route('admin.campaigns.show', $campaign) }}" class="btn-ghost">Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
</x-admin-layout>
