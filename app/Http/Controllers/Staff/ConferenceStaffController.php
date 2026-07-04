<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormSubmission;
use App\Models\ConferenceSetting;
use App\Models\ParticipantScanLog;
use Illuminate\Http\Request;

class ConferenceStaffController extends Controller
{
    // ── Front-desk portal ──────────────────────────────────────────────────
    public function frontDesk()
    {
        $forms = Form::where('is_conference_form', true)->where('is_active', true)->get();
        $formId = request('form_id', $forms->first()?->id);
        $form = $formId ? Form::find($formId) : null;

        $stats = null;
        if ($form) {
            $stats = [
                'total'      => $form->submissions()->count(),
                'checked_in' => $form->submissions()->where('attendance_verified', true)->count(),
                'pending'    => $form->submissions()->where('attendance_verified', false)->count(),
            ];
        }

        return view('staff.front-desk', compact('forms', 'form', 'stats'));
    }

    // ── QR scan for check-in ───────────────────────────────────────────────
    public function scanCheckIn(Request $request)
    {
        $request->validate(['qr_token' => 'required|string', 'form_id' => 'required|integer']);

        $submission = FormSubmission::where('qr_token', trim($request->qr_token))
            ->where('form_id', $request->form_id)
            ->first();

        if (!$submission) {
            return response()->json(['success' => false, 'message' => 'Participant not found. Invalid QR code.'], 404);
        }

        $alreadyCheckedIn = $submission->attendance_verified;

        if (!$alreadyCheckedIn) {
            $submission->update([
                'attendance_verified' => true,
                'checked_in_at'       => now(),
                'checked_in_by'       => auth()->id(),
            ]);

            ParticipantScanLog::create([
                'form_submission_id' => $submission->id,
                'scanned_by'         => auth()->id(),
                'action'             => 'check_in',
                'ip_address'         => $request->ip(),
            ]);
        }

        $data = $submission->data ?? [];
        $name = $data['full_name'] ?? $data['name'] ?? (($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')) ?: 'Participant';

        return response()->json([
            'success'          => true,
            'already_checked'  => $alreadyCheckedIn,
            'participant_id'   => $submission->participant_id,
            'name'             => trim($name),
            'checked_in_at'    => $submission->checked_in_at?->format('H:i d/m/Y'),
            'message'          => $alreadyCheckedIn
                ? "⚠ Already checked in at " . $submission->checked_in_at?->format('H:i')
                : "✓ Welcome, " . trim($name) . "!",
        ]);
    }

    // ── Manual lookup / check-in ───────────────────────────────────────────
    public function lookupParticipant(Request $request)
    {
        $request->validate(['query' => 'required|string|min:2', 'form_id' => 'required|integer']);

        $search = $request->query;

        $submissions = FormSubmission::where('form_id', $request->form_id)
            ->where(function ($q) use ($search) {
                $q->where('participant_id', 'like', "%{$search}%")
                  ->orWhereRaw("JSON_SEARCH(LOWER(data), 'one', LOWER(?)) IS NOT NULL", ["%{$search}%"]);
            })
            ->limit(10)
            ->get();

        $results = $submissions->map(function ($s) {
            $data = $s->data ?? [];
            $name = $data['full_name'] ?? $data['name'] ?? trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')) ?: 'Unknown';
            return [
                'id'             => $s->id,
                'participant_id' => $s->participant_id,
                'name'           => $name,
                'email'          => $data['email'] ?? '',
                'phone'          => $data['phone'] ?? '',
                'checked_in'     => $s->attendance_verified,
                'checked_in_at'  => $s->checked_in_at?->format('H:i d/m/Y'),
            ];
        });

        return response()->json(['results' => $results]);
    }

    public function checkInById(Request $request)
    {
        $request->validate(['submission_id' => 'required|integer']);

        $submission = FormSubmission::findOrFail($request->submission_id);

        if (!$submission->attendance_verified) {
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
        }

        return response()->json(['success' => true, 'message' => 'Participant checked in.']);
    }

    // ── Lunch scanner portal ───────────────────────────────────────────────
    public function lunchScanner()
    {
        $forms = Form::where('is_conference_form', true)->where('is_active', true)->get();
        $formId = request('form_id', $forms->first()?->id);
        $form   = $formId ? Form::find($formId) : null;

        $stats = null;
        if ($form) {
            $settings = ConferenceSetting::where('form_id', $form->id)->first();
            $stats = [
                'total'           => $form->submissions()->where('attendance_verified', true)->count(),
                'lunch_collected' => $form->submissions()->where('lunch_collected', true)->count(),
                'pending'         => $form->submissions()->where('attendance_verified', true)->where('lunch_collected', false)->count(),
            ];
        }

        return view('staff.lunch-scanner', compact('forms', 'form', 'stats', 'settings'));
    }

    // ── QR scan for lunch ─────────────────────────────────────────────────
    public function scanLunch(Request $request)
    {
        $request->validate(['qr_token' => 'required|string', 'form_id' => 'required|integer']);

        $submission = FormSubmission::where('qr_token', trim($request->qr_token))
            ->where('form_id', $request->form_id)
            ->first();

        if (!$submission) {
            return response()->json(['success' => false, 'message' => 'Participant not found.'], 404);
        }

        if (!$submission->attendance_verified) {
            return response()->json(['success' => false, 'message' => '⛔ Not checked in. Participant must check in first.'], 403);
        }

        $alreadyCollected = $submission->lunch_collected;

        $data = $submission->data ?? [];
        $name = $data['full_name'] ?? $data['name'] ?? trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')) ?: 'Participant';

        if ($alreadyCollected) {
            return response()->json([
                'success'        => true,
                'already_served' => true,
                'participant_id' => $submission->participant_id,
                'name'           => trim($name),
                'message'        => "⚠ Lunch already collected at " . $submission->lunch_collected_at?->format('H:i'),
            ]);
        }

        $submission->update([
            'lunch_collected'    => true,
            'lunch_collected_at' => now(),
            'lunch_collected_by' => auth()->id(),
        ]);

        ParticipantScanLog::create([
            'form_submission_id' => $submission->id,
            'scanned_by'         => auth()->id(),
            'action'             => 'lunch',
            'ip_address'         => $request->ip(),
        ]);

        return response()->json([
            'success'        => true,
            'already_served' => false,
            'participant_id' => $submission->participant_id,
            'name'           => trim($name),
            'message'        => "✓ Lunch served to " . trim($name),
        ]);
    }
}
