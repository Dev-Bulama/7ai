<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormSubmission;
use App\Models\ConferenceSetting;
use App\Models\ParticipantScanLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class ConferenceController extends Controller
{
    // ── Dashboard ──────────────────────────────────────────────────────────
    public function index()
    {
        $forms = Form::where('is_conference_form', true)->withCount('submissions')->get();
        return view('admin.conference.index', compact('forms'));
    }

    // ── Participants list ──────────────────────────────────────────────────
    public function participants(Form $form)
    {
        abort_unless($form->is_conference_form, 404);

        $settings = ConferenceSetting::firstOrCreate(
            ['form_id' => $form->id],
            ['event_name' => $form->name]
        );

        $search = request('search');
        $filter = request('filter', 'all');

        $query = $form->submissions()->with('checkedInBy', 'lunchCollectedBy');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('participant_id', 'like', "%{$search}%")
                  ->orWhereRaw("JSON_SEARCH(LOWER(data), 'one', LOWER(?)) IS NOT NULL", ["%{$search}%"]);
            });
        }

        if ($filter === 'checked_in') {
            $query->where('attendance_verified', true);
        } elseif ($filter === 'not_checked_in') {
            $query->where('attendance_verified', false);
        } elseif ($filter === 'lunch_collected') {
            $query->where('lunch_collected', true);
        } elseif ($filter === 'no_qr') {
            $query->whereNull('qr_token');
        }

        $participants = $query->orderByDesc('id')->paginate(50);

        $stats = [
            'total'          => $form->submissions()->count(),
            'checked_in'     => $form->submissions()->where('attendance_verified', true)->count(),
            'lunch_collected'=> $form->submissions()->where('lunch_collected', true)->count(),
            'with_qr'        => $form->submissions()->whereNotNull('qr_token')->count(),
        ];

        return view('admin.conference.participants', compact('form', 'settings', 'participants', 'stats'));
    }

    // ── Participant card (printable badge) ─────────────────────────────────
    public function participantCard(Form $form, FormSubmission $submission)
    {
        abort_unless($form->is_conference_form && $submission->form_id === $form->id, 404);
        $settings = ConferenceSetting::where('form_id', $form->id)->first();
        return view('admin.conference.participant-card', compact('form', 'submission', 'settings'));
    }

    // ── Conference settings form ───────────────────────────────────────────
    public function settings(Form $form)
    {
        abort_unless($form->is_conference_form, 404);
        $settings = ConferenceSetting::firstOrCreate(['form_id' => $form->id], ['event_name' => $form->name]);
        return view('admin.conference.settings', compact('form', 'settings'));
    }

    public function updateSettings(Request $request, Form $form)
    {
        abort_unless($form->is_conference_form, 404);
        $data = $request->validate([
            'event_name'           => 'required|string|max:200',
            'event_date'           => 'nullable|date',
            'event_venue'          => 'nullable|string|max:255',
            'participant_id_prefix'=> 'required|string|max:10',
            'lunch_enabled'        => 'boolean',
            'lunch_rounds'         => 'integer|min:1|max:5',
            'badge_enabled'        => 'boolean',
            'badge_bg_color'       => 'nullable|string|max:7',
            'badge_accent_color'   => 'nullable|string|max:7',
            'badge_logo'           => 'nullable|image|max:2048',
        ]);

        $settings = ConferenceSetting::firstOrCreate(['form_id' => $form->id], ['event_name' => $form->name]);

        if ($request->hasFile('badge_logo')) {
            $path = $request->file('badge_logo')->store('conference/logos', 'public');
            $data['badge_logo_path'] = $path;
        }

        $data['lunch_enabled'] = $request->boolean('lunch_enabled');
        $data['badge_enabled'] = $request->boolean('badge_enabled');
        unset($data['badge_logo']);

        $settings->update($data);

        return redirect()->route('admin.conference.settings', $form)->with('success', 'Conference settings saved.');
    }

    // ── Toggle conference mode on a form ──────────────────────────────────
    public function toggleConference(Form $form)
    {
        $form->update(['is_conference_form' => !$form->is_conference_form]);
        $msg = $form->is_conference_form ? 'Conference mode enabled.' : 'Conference mode disabled.';
        return back()->with('success', $msg);
    }

    // ── Manual check-in / undo ─────────────────────────────────────────────
    public function manualCheckIn(Request $request, Form $form, FormSubmission $submission)
    {
        abort_unless($form->is_conference_form && $submission->form_id === $form->id, 404);

        if ($submission->attendance_verified) {
            $submission->update([
                'attendance_verified' => false,
                'checked_in_at'       => null,
                'checked_in_by'       => null,
            ]);
            $msg = 'Check-in reversed.';
        } else {
            $submission->update([
                'attendance_verified' => true,
                'checked_in_at'       => now(),
                'checked_in_by'       => auth()->id(),
            ]);
            ParticipantScanLog::create([
                'form_submission_id' => $submission->id,
                'scanned_by'         => auth()->id(),
                'action'             => 'manual_verify',
                'ip_address'         => $request->ip(),
            ]);
            $msg = 'Participant checked in.';
        }

        return back()->with('success', $msg);
    }

    // ── Export participants (CSV) ──────────────────────────────────────────
    public function exportParticipants(Form $form)
    {
        abort_unless($form->is_conference_form, 404);

        $submissions = $form->submissions()->with('checkedInBy')->get();
        $fields      = $form->fields()->where('is_active', true)->pluck('label', 'name')->toArray();

        $filename = 'participants-' . $form->slug . '-' . now()->format('Ymd') . '.csv';

        $headers = array_merge(
            ['Participant ID', 'QR Token', 'Checked In', 'Checked In At', 'Checked In By', 'Lunch Collected', 'Lunch At'],
            array_values($fields),
            ['Submitted At']
        );

        $callback = function () use ($submissions, $fields, $headers) {
            $fh = fopen('php://output', 'w');
            fputcsv($fh, $headers);
            foreach ($submissions as $sub) {
                $data = $sub->data ?? [];
                $row  = [
                    $sub->participant_id ?? '',
                    $sub->qr_token ?? '',
                    $sub->attendance_verified ? 'Yes' : 'No',
                    $sub->checked_in_at?->format('Y-m-d H:i') ?? '',
                    $sub->checkedInBy?->name ?? '',
                    $sub->lunch_collected ? 'Yes' : 'No',
                    $sub->lunch_collected_at?->format('Y-m-d H:i') ?? '',
                ];
                foreach (array_keys($fields) as $name) {
                    $row[] = $data[$name] ?? '';
                }
                $row[] = $sub->created_at->format('Y-m-d H:i');
                fputcsv($fh, $row);
            }
            fclose($fh);
        };

        return response()->stream($callback, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    // ── Staff management ───────────────────────────────────────────────────
    public function staff()
    {
        $staff = User::role(['front-desk-staff', 'lunch-staff'])->get();
        return view('admin.conference.staff', compact('staff'));
    }

    public function createStaff()
    {
        return view('admin.conference.create-staff');
    }

    public function storeStaff(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:front-desk-staff,lunch-staff',
        ]);

        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'is_active' => true,
        ]);
        $user->assignRole($data['role']);

        // Send credentials email
        $this->sendStaffCredentials($user, $data['password']);

        return redirect()->route('admin.conference.staff')->with('success', "Staff account created for {$user->name}.");
    }

    public function editStaff(User $user)
    {
        return view('admin.conference.edit-staff', compact('user'));
    }

    public function updateStaff(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'role'     => 'required|in:front-desk-staff,lunch-staff',
            'password' => 'nullable|string|min:8|confirmed',
            'is_active'=> 'boolean',
        ]);

        $user->update([
            'name'      => $data['name'],
            'is_active' => $request->boolean('is_active'),
        ]);

        if (!empty($data['password'])) {
            $user->update(['password' => Hash::make($data['password'])]);
        }

        $user->syncRoles([$data['role']]);

        return redirect()->route('admin.conference.staff')->with('success', "Staff account updated.");
    }

    public function destroyStaff(User $user)
    {
        $user->syncRoles([]);
        $user->delete();
        return redirect()->route('admin.conference.staff')->with('success', 'Staff account removed.');
    }

    // ── Scan logs ─────────────────────────────────────────────────────────
    public function scanLogs(Form $form)
    {
        abort_unless($form->is_conference_form, 404);
        $logs = ParticipantScanLog::whereHas('submission', fn($q) => $q->where('form_id', $form->id))
            ->with('submission', 'scanner')
            ->orderByDesc('scanned_at')
            ->paginate(100);
        return view('admin.conference.scan-logs', compact('form', 'logs'));
    }

    // ── Private helpers ───────────────────────────────────────────────────
    private function sendStaffCredentials(User $user, string $plainPassword): void
    {
        try {
            \App\Services\SmtpMailService::configure();
            \Illuminate\Support\Facades\Mail::html(
                view('emails.staff-credentials', [
                    'user'          => $user,
                    'plain_password'=> $plainPassword,
                    'login_url'     => url('/login'),
                ])->render(),
                function ($msg) use ($user) {
                    $msg->to($user->email, $user->name)
                        ->subject('Your Staff Portal Credentials');
                }
            );
        } catch (\Throwable $e) {
            \Log::warning('[CONFERENCE] Could not send staff credentials: ' . $e->getMessage());
        }
    }
}
