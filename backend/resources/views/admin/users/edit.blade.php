<x-admin-layout title="Edit User">
<style>
  .card{background:#fff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden;max-width:640px;}
  .card-head{padding:18px 24px;border-bottom:1px solid #f3f4f6;}
  .card-head h3{font-size:15px;font-weight:600;color:#0d1b2a;}
  .card-body{padding:24px;}
  label{display:block;font-size:13px;font-weight:500;color:#374151;margin-bottom:6px;}
  input[type=text],input[type=email],select{width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;outline:none;}
  input:focus,select:focus{border-color:#0B4F6C;}
  .form-group{margin-bottom:20px;}
  .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
  .btn-primary{padding:11px 24px;background:#0B4F6C;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;}
  .btn-ghost{padding:11px 24px;background:#f9fafb;color:#374151;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-weight:500;cursor:pointer;font-family:inherit;text-decoration:none;}
  .role-check{display:flex;flex-wrap:wrap;gap:12px;}
  .role-check label{display:flex;align-items:center;gap:6px;font-size:13px;color:#374151;cursor:pointer;margin:0;}
  .role-check input{width:auto;}
</style>

<div style="margin-bottom:20px;"><a href="{{ route('admin.users.show', $user) }}" style="font-size:13px;color:#6b7280;text-decoration:none;">← Back to User</a></div>

<div class="card">
  <div class="card-head"><h3>Edit {{ $user->name }}</h3></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
      @csrf @method('PUT')
      <div class="grid-2">
        <div class="form-group"><label>Name *</label><input type="text" name="name" value="{{ old('name',$user->name) }}" required></div>
        <div class="form-group"><label>Email *</label><input type="email" name="email" value="{{ old('email',$user->email) }}" required></div>
      </div>
      <div class="grid-2">
        <div class="form-group"><label>Phone</label><input type="text" name="phone" value="{{ old('phone',$user->phone) }}"></div>
        <div class="form-group"><label>Company</label><input type="text" name="company" value="{{ old('company',$user->company) }}"></div>
      </div>
      <div class="grid-2">
        <div class="form-group"><label>Country</label><input type="text" name="country" value="{{ old('country',$user->country) }}"></div>
        <div class="form-group">
          <label>Status</label>
          <select name="is_active">
            <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label>Roles</label>
        <div class="role-check">
          @foreach($roles as $role)
            <label>
              <input type="checkbox" name="roles[]" value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
              {{ ucfirst(str_replace('-',' ',$role->name)) }}
            </label>
          @endforeach
        </div>
      </div>
      <div style="display:flex;gap:12px;">
        <button type="submit" class="btn-primary">Save Changes</button>
        <a href="{{ route('admin.users.show', $user) }}" class="btn-ghost">Cancel</a>
      </div>
    </form>
  </div>
</div>
</x-admin-layout>
