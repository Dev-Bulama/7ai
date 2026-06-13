<x-admin-layout title="Edit Team Member">
<div class="section-header">
  <span class="section-title">Edit: {{ $team->name }}</span>
  <a href="{{ route('admin.team.index') }}" class="btn btn-outline btn-sm">← All Members</a>
</div>

<div class="card" style="max-width:760px;">
  <form method="POST" action="{{ route('admin.team.update', $team) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.team._form', ['team' => $team])
    <div style="display:flex;gap:12px;align-items:center;">
      <button type="submit" class="btn btn-primary">Save Changes</button>
      <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('delete-team-form').submit()">Delete</button>
    </div>
  </form>
</div>

<form id="delete-team-form" method="POST" action="{{ route('admin.team.destroy', $team) }}"
      onsubmit="return confirm('Delete this team member?')" style="display:none;">
  @csrf @method('DELETE')
</form>
</x-admin-layout>
