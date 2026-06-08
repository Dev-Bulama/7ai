<x-customer-layout title="New Support Ticket">
<style>
  .form-card{background:#fff;border-radius:12px;border:1px solid #e5e7eb;padding:32px;max-width:720px;}
  label{display:block;font-size:13px;font-weight:500;color:#374151;margin-bottom:6px;}
  input[type=text],select,textarea{width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-family:inherit;outline:none;transition:border-color 0.2s;}
  input:focus,select:focus,textarea:focus{border-color:#0B4F6C;}
  textarea{resize:vertical;min-height:140px;}
  .form-group{margin-bottom:20px;}
  .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
  .form-actions{display:flex;gap:12px;padding-top:8px;}
  .btn-primary{padding:11px 24px;background:#0B4F6C;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;}
  .btn-primary:hover{background:#093d56;}
  .btn-secondary{padding:11px 24px;background:#f9fafb;color:#374151;border:1.5px solid #e5e7eb;border-radius:8px;font-size:14px;font-weight:500;cursor:pointer;font-family:inherit;text-decoration:none;}
</style>
<div class="form-card">
  <form method="POST" action="{{ route('customer.tickets.store') }}">
    @csrf
    <div class="form-group">
      <label>Subject *</label>
      <input type="text" name="subject" value="{{ old('subject') }}" required placeholder="Brief description of your issue">
      @error('subject')<div style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
    </div>
    <div class="grid-2">
      <div class="form-group">
        <label>Category</label>
        <select name="category">
          <option value="">Select category</option>
          <option value="technical">Technical Issue</option>
          <option value="billing">Billing & Payments</option>
          <option value="installation">Installation</option>
          <option value="general">General Enquiry</option>
        </select>
      </div>
      <div class="form-group">
        <label>Priority</label>
        <select name="priority">
          <option value="low">Low</option>
          <option value="medium" selected>Medium</option>
          <option value="high">High</option>
          <option value="urgent">Urgent</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label>Description *</label>
      <textarea name="description" required placeholder="Please describe your issue in detail...">{{ old('description') }}</textarea>
      @error('description')<div style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
    </div>
    <div class="form-actions">
      <button type="submit" class="btn-primary">Submit Ticket</button>
      <a href="{{ route('customer.tickets.index') }}" class="btn-secondary">Cancel</a>
    </div>
  </form>
</div>
</x-customer-layout>
