<x-admin-layout title="Add Team Member">
<div class="section-header">
  <span class="section-title">Add Team Member</span>
  <a href="{{ route('admin.team.index') }}" class="btn btn-outline btn-sm">← All Members</a>
</div>

<div class="card" style="max-width:760px;">
  <form method="POST" action="{{ route('admin.team.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.team._form')
    <button type="submit" class="btn btn-primary">Add Team Member</button>
  </form>
</div>
</x-admin-layout>
