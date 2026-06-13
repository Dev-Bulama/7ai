<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
        $members = TeamMember::withTrashed()->orderBy('sort_order')->orderBy('name')->paginate(30);
        return view('admin.team.index', compact('members'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data = $this->handlePhoto($request, $data);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);
        TeamMember::create($data);
        return redirect()->route('admin.team.index')->with('success', 'Team member added.');
    }

    public function edit(TeamMember $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    public function update(Request $request, TeamMember $team)
    {
        $data = $this->validated($request, $team->id);
        $data = $this->handlePhoto($request, $data, $team);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);
        $team->update($data);
        return redirect()->route('admin.team.edit', $team)->with('success', 'Team member updated.');
    }

    public function destroy(TeamMember $team)
    {
        if ($team->photo && !str_starts_with($team->photo, 'http')) {
            Storage::disk('public')->delete($team->photo);
        }
        $team->delete();
        return redirect()->route('admin.team.index')->with('success', 'Team member deleted.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name'       => 'required|max:255',
            'job_title'  => 'nullable|max:255',
            'subtitle'   => 'nullable|max:500',
            'bio'        => 'nullable',
            'photo'      => 'nullable|image|max:4096',
            'email'      => 'nullable|email|max:255',
            'phone'      => 'nullable|max:50',
            'facebook'   => 'nullable|url|max:500',
            'instagram'  => 'nullable|url|max:500',
            'twitter'    => 'nullable|url|max:500',
            'linkedin'   => 'nullable|url|max:500',
            'github'     => 'nullable|url|max:500',
            'website'    => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer',
        ]);
    }

    private function handlePhoto(Request $request, array $data, ?TeamMember $existing = null): array
    {
        if ($request->hasFile('photo')) {
            if ($existing?->photo && !str_starts_with($existing->photo, 'http')) {
                Storage::disk('public')->delete($existing->photo);
            }
            $data['photo'] = $request->file('photo')->store('team', 'public');
        } else {
            unset($data['photo']);
        }
        return $data;
    }
}
