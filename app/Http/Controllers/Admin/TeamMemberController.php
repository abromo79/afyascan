<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    use HandlesUploads;

    public function index(): View
    {
        return view('admin.team.index', [
            'members' => TeamMember::ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.team.form', [
            'member' => new TeamMember,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->memberData($request);

        $data['is_active'] = $request->boolean('is_active');
        $data['photo'] = $this->storeImage($request->file('photo'), 'team');

        TeamMember::create($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member created.');
    }

    public function edit(TeamMember $team): View
    {
        return view('admin.team.form', [
            'member' => $team,
        ]);
    }

    public function update(Request $request, TeamMember $team): RedirectResponse
    {
        $data = $this->memberData($request);

        $data['is_active'] = $request->boolean('is_active');
        $data['photo'] = $this->storeImage($request->file('photo'), 'team', $team->photo);

        $team->update($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member updated.');
    }

    public function publish(TeamMember $team): RedirectResponse
    {
        $team->update(['is_active' => ! $team->is_active]);

        return back()->with('success', $team->is_active ? 'Team member activated.' : 'Team member deactivated.');
    }

    public function destroy(TeamMember $team): RedirectResponse
    {
        $this->deleteImage($team->photo);
        $team->delete();

        return redirect()->route('admin.team.index')->with('success', 'Team member deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function memberData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
        ]);
    }
}
