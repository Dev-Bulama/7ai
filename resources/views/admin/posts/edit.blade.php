<x-admin-layout title="Edit Post">
<style>
  .editor-layout{display:grid;grid-template-columns:1fr 300px;gap:24px;align-items:start;}
  .card{background:#fff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden;margin-bottom:20px;}
  .card-head{padding:18px 24px;border-bottom:1px solid #f3f4f6;}
  .card-head h3{font-size:15px;font-weight:600;color:#0d1b2a;}
  .card-body{padding:20px 24px;}
  label{display:block;font-size:13px;font-weight:500;color:#374151;margin-bottom:6px;}
  input[type=text],input[type=number],select,textarea{width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;outline:none;}
  input:focus,select:focus,textarea:focus{border-color:#0B4F6C;}
  textarea{resize:vertical;}
  .form-group{margin-bottom:20px;}
  .btn-primary{padding:11px 24px;background:#0B4F6C;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;}
  .btn-ghost{padding:11px 24px;background:#f9fafb;color:#374151;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-weight:500;cursor:pointer;font-family:inherit;text-decoration:none;}
</style>

<div style="margin-bottom:20px;">
  <a href="{{ route('admin.posts.index') }}" style="font-size:13px;color:#6b7280;text-decoration:none;">← Back to Posts</a>
</div>

<form method="POST" action="{{ route('admin.posts.update', $post) }}">
  @csrf @method('PUT')
  <div class="editor-layout">
    <div>
      <div class="card">
        <div class="card-head"><h3>Post Content</h3></div>
        <div class="card-body">
          <div class="form-group">
            <label>Title *</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" required>
          </div>
          <div class="form-group">
            <label>Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $post->slug) }}">
          </div>
          <div class="form-group">
            <label>Excerpt</label>
            <textarea name="excerpt" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>
          </div>
          <div class="form-group">
            <label>Content *</label>
            <textarea name="content" rows="18" required>{{ old('content', $post->content) }}</textarea>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-head"><h3>SEO</h3></div>
        <div class="card-body">
          <div class="form-group">
            <label>Meta Title</label>
            <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}">
          </div>
          <div class="form-group">
            <label>Meta Description</label>
            <textarea name="meta_description" rows="2">{{ old('meta_description', $post->meta_description) }}</textarea>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="card">
        <div class="card-head"><h3>Publish</h3></div>
        <div class="card-body">
          <div class="form-group">
            <label>Status</label>
            <select name="status">
              @foreach(['draft','published','scheduled'] as $s)
                <option value="{{ $s }}" {{ $post->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
              @endforeach
            </select>
          </div>
          <div style="display:flex;gap:12px;">
            <button type="submit" class="btn-primary" style="flex:1;">Update</button>
            <a href="{{ route('admin.posts.index') }}" class="btn-ghost">Cancel</a>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-head"><h3>Settings</h3></div>
        <div class="card-body">
          <div class="form-group">
            <label>Category</label>
            <select name="category_id">
              <option value="">No category</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $post->category_id==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Featured Image URL</label>
            <input type="text" name="featured_image" value="{{ old('featured_image', $post->featured_image) }}">
          </div>
          <div class="form-group">
            <label>Read Time (minutes)</label>
            <input type="number" name="read_time" value="{{ old('read_time', $post->read_time) }}" min="1">
          </div>
          <div style="display:flex;flex-direction:column;gap:10px;">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
              <input type="checkbox" name="featured" value="1" {{ $post->featured?'checked':'' }}> Featured post
            </label>
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
              <input type="checkbox" name="allow_comments" value="1" {{ $post->allow_comments?'checked':'' }}> Allow comments
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
</x-admin-layout>
