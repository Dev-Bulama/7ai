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

        $globalStats = [
            'total_registrations' => FormSubmission::whereIn('form_id', $forms->pluck('id'))->count(),
            'total_checked_in'    => FormSubmission::whereIn('form_id', $forms->pluck('id'))->where('attendance_verified', true)->count(),
            'total_lunch'         => FormSubmission::whereIn('form_id', $forms->pluck('id'))->where('lunch_collected', true)->count(),
            'front_desk_staff'    => User::role('front-desk-staff')->count(),
            'lunch_staff'         => User::role('lunch-staff')->count(),
        ];

        $recentCheckIns = FormSubmission::whereIn('form_id', $forms->pluck('id'))
            ->where('attendance_verified', true)
            ->whereNotNull('checked_in_at')
            ->orderByDesc('checked_in_at')
            ->limit(5)
            ->get();

        $recentScans = ParticipantScanLog::whereHas('submission', fn($q) => $q->whereIn('form_id', $forms->pluck('id')))
            ->with('scanner', 'submission')
            ->orderByDesc('scanned_at')
            ->limit(5)
            ->get();

        return view('admin.conference.index', compact('forms', 'globalStats', 'recentCheckIns', 'recentScans'));
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
                  ->orWhereRaw("LOWER(CAST(data AS CHAR)) LIKE LOWER(?)", ["%{$search}%"]);
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
        $settings  = ConferenceSetting::where('form_id', $form->id)->first();
        $badgeHtml = $this->renderBadge($submission, $settings, 150);
        return view('admin.conference.participant-card', compact('form', 'submission', 'settings', 'badgeHtml'));
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
            'badge_html_template'  => 'nullable|string',
            'flyer_hashtag'        => 'nullable|string|max:100',
            'flyer_html_template'  => 'nullable|string',
        ]);

        if ($request->input('reset_badge_template')) {
            $data['badge_html_template'] = null;
        }

        if ($request->input('reset_flyer_template')) {
            $data['flyer_html_template'] = null;
        }

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

    // ── Bulk QR export (printable page) ──────────────────────────────────
    public function exportQrCodes(Form $form)
    {
        abort_unless($form->is_conference_form, 404);
        $settings    = ConferenceSetting::where('form_id', $form->id)->first();
        $submissions = $form->submissions()->whereNotNull('qr_token')->get();
        $badges = $submissions->map(fn($s) => $this->renderBadge($s, $settings, 110));
        return view('admin.conference.export-qr', compact('form', 'settings', 'submissions', 'badges'));
    }

    // ── Update badge role per participant ──────────────────────────────────
    public function updateBadgeRole(Request $request, Form $form, FormSubmission $submission)
    {
        abort_unless($form->is_conference_form && $submission->form_id === $form->id, 404);
        $request->validate(['badge_role' => 'nullable|string|max:60']);
        $submission->update(['badge_role' => $request->input('badge_role') ?: null]);
        return response()->json(['success' => true, 'badge_role' => $submission->badge_role]);
    }

    // ── Badge template renderer ────────────────────────────────────────────
    private function renderBadge(FormSubmission $submission, ?ConferenceSetting $settings, int $qrSize = 130): string
    {
        $data      = $submission->data ?? [];
        $name      = $data['full_name'] ?? $data['name'] ?? trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? '')) ?: 'Participant';
        $email     = $data['email'] ?? '';
        $phone     = $data['phone'] ?? '';
        $role      = $submission->badge_role
                     ?? $data['role'] ?? $data['course'] ?? $data['category']
                     ?? $data['designation'] ?? $data['title'] ?? 'Participant';
        $eventName = $settings?->event_name ?? 'Conference';
        $eventDate = $settings?->event_date?->format('d M Y') ?? '';
        $venue     = $settings?->event_venue ?? '';
        $accentColor = $settings?->badge_accent_color ?? '#3ee07f';
        $bgColor     = $settings?->badge_bg_color ?? '#0a1628';
        $pid         = $submission->participant_id ?? 'NO-ID';
        $qrValue     = $pid; // QR encodes participant ID — reprints work, one check-in enforced by DB

        try {
            $qrSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                ->size($qrSize)->errorCorrection('M')->generate($qrValue);
        } catch (\Throwable $e) {
            $qrSvg = '<div style="width:'.$qrSize.'px;height:'.$qrSize.'px;background:#eee;display:flex;align-items:center;justify-content:center;font-size:9px;font-family:monospace;">QR Error</div>';
        }

        $logoHtml = '';
        if ($settings?->badge_logo_path) {
            $logoHtml = '<img src="'.asset('storage/'.$settings->badge_logo_path).'" style="height:30px;object-fit:contain;display:block;margin:0 auto 4px;" onerror="this.style.display=\'none\'">';
        }

        $template = $settings?->badge_html_template ?: self::defaultBadgeTemplate();

        return str_replace(
            ['{{NAME}}','{{PARTICIPANT_ID}}','{{QR_CODE}}','{{EMAIL}}','{{PHONE}}','{{ROLE}}',
             '{{EVENT_NAME}}','{{EVENT_DATE}}','{{EVENT_VENUE}}','{{LOGO}}',
             '{{ACCENT_COLOR}}','{{BG_COLOR}}'],
            [$name, $pid, $qrSvg, $email, $phone, $role,
             $eventName, $eventDate, $venue, $logoHtml,
             $accentColor, $bgColor],
            $template
        );
    }

    public static function defaultBadgeTemplate(): string
    {
        return <<<'HTML'
<style>
* { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; color-adjust: exact !important; }
.badge-card {
  width:86mm; min-height:120mm;
  background:#ffffff !important;
  border-radius:10px;
  overflow:hidden;
  box-shadow:0 4px 20px rgba(0,0,0,0.2);
  font-family:Arial,Helvetica,sans-serif;
  page-break-inside:avoid;
  break-inside:avoid;
}
.bc-header {
  background:{{BG_COLOR}} !important;
  padding:12px 16px 10px;
  display:flex; align-items:center; gap:10px;
}
.bc-header-text { font-size:9px; font-weight:700; color:#fff !important; text-transform:uppercase; letter-spacing:0.06em; line-height:1.4; }
.bc-body { padding:16px; text-align:center; }
.bc-role { font-size:22px; font-weight:900; color:#1a1a1a !important; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:5px; }
.bc-accent { width:40px; height:3px; background:#e53e3e !important; margin:0 auto 14px; border-radius:2px; }
.bc-qr { display:flex; justify-content:center; margin-bottom:10px; }
.bc-qr svg { border:3px solid #fff; outline:1px solid #e2e8f0; border-radius:4px; }
.bc-name { font-size:14px; font-weight:700; color:#1a202c !important; margin-bottom:3px; line-height:1.2; }
.bc-id { font-family:monospace; font-size:15px; font-weight:900; color:{{BG_COLOR}} !important; letter-spacing:0.12em; margin-bottom:4px; }
.bc-detail { font-size:10px; color:#718096 !important; line-height:1.6; }
.bc-footer {
  background:{{BG_COLOR}} !important;
  padding:9px 16px; text-align:center;
}
.bc-footer-name { font-size:9px; font-weight:700; color:#fff !important; text-transform:uppercase; letter-spacing:0.08em; }
.bc-footer-sub { font-size:8px; color:rgba(255,255,255,0.75) !important; margin-top:2px; }
@media print {
  * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
  .badge-card { box-shadow:none; border:1px solid #ccc; }
}
</style>
<div class="badge-card">
  <div class="bc-header">
    {{LOGO}}
    <div class="bc-header-text">{{EVENT_NAME}}</div>
  </div>
  <div class="bc-body">
    <div class="bc-role">{{ROLE}}</div>
    <div class="bc-accent"></div>
    <div class="bc-qr">{{QR_CODE}}</div>
    <div class="bc-name">{{NAME}}</div>
    <div class="bc-id">{{PARTICIPANT_ID}}</div>
    <div class="bc-detail">{{EMAIL}}{{PHONE}}</div>
  </div>
  <div class="bc-footer">
    <div class="bc-footer-name">{{EVENT_NAME}}</div>
    <div class="bc-footer-sub">{{EVENT_DATE}}{{EVENT_VENUE}}</div>
  </div>
</div>
HTML;
    }

    public static function defaultFlyerTemplate(): string
    {
        return <<<'FLYERHTML'
<div style="width:540px;height:675px;position:relative;font-family:'Segoe UI',Arial,sans-serif;overflow:hidden;border-radius:0;background:#0A1628;">
<!-- ── Navy section: 0–355px ── -->
<div style="position:absolute;top:0;left:0;right:0;height:355px;background:{{BG_COLOR}};"></div>
<!-- ── White section: 355–675px ── -->
<div style="position:absolute;top:355px;left:0;right:0;bottom:0;background:#ffffff;"></div>
<!-- Dot grid top-right -->
<svg style="position:absolute;top:12px;right:14px;" width="56" height="44" viewBox="0 0 56 44" fill="none" xmlns="http://www.w3.org/2000/svg">
  <circle cx="6" cy="6" r="2.5" fill="rgba(255,255,255,0.22)"/><circle cx="18" cy="6" r="2.5" fill="rgba(255,255,255,0.22)"/><circle cx="30" cy="6" r="2.5" fill="rgba(255,255,255,0.22)"/><circle cx="42" cy="6" r="2.5" fill="rgba(255,255,255,0.22)"/><circle cx="54" cy="6" r="2.5" fill="rgba(255,255,255,0.22)"/>
  <circle cx="6" cy="18" r="2.5" fill="rgba(255,255,255,0.22)"/><circle cx="18" cy="18" r="2.5" fill="rgba(255,255,255,0.22)"/><circle cx="30" cy="18" r="2.5" fill="rgba(255,255,255,0.22)"/><circle cx="42" cy="18" r="2.5" fill="rgba(255,255,255,0.22)"/><circle cx="54" cy="18" r="2.5" fill="rgba(255,255,255,0.22)"/>
  <circle cx="6" cy="30" r="2.5" fill="rgba(255,255,255,0.22)"/><circle cx="18" cy="30" r="2.5" fill="rgba(255,255,255,0.22)"/><circle cx="30" cy="30" r="2.5" fill="rgba(255,255,255,0.22)"/><circle cx="42" cy="30" r="2.5" fill="rgba(255,255,255,0.22)"/><circle cx="54" cy="30" r="2.5" fill="rgba(255,255,255,0.22)"/>
</svg>
<!-- Dot grid left side -->
<svg style="position:absolute;top:208px;left:12px;" width="44" height="56" viewBox="0 0 44 56" fill="none" xmlns="http://www.w3.org/2000/svg">
  <circle cx="6" cy="6" r="2.5" fill="rgba(255,255,255,0.18)"/><circle cx="18" cy="6" r="2.5" fill="rgba(255,255,255,0.18)"/><circle cx="30" cy="6" r="2.5" fill="rgba(255,255,255,0.18)"/><circle cx="42" cy="6" r="2.5" fill="rgba(255,255,255,0.18)"/>
  <circle cx="6" cy="18" r="2.5" fill="rgba(255,255,255,0.18)"/><circle cx="18" cy="18" r="2.5" fill="rgba(255,255,255,0.18)"/><circle cx="30" cy="18" r="2.5" fill="rgba(255,255,255,0.18)"/><circle cx="42" cy="18" r="2.5" fill="rgba(255,255,255,0.18)"/>
  <circle cx="6" cy="30" r="2.5" fill="rgba(255,255,255,0.18)"/><circle cx="18" cy="30" r="2.5" fill="rgba(255,255,255,0.18)"/><circle cx="30" cy="30" r="2.5" fill="rgba(255,255,255,0.18)"/><circle cx="42" cy="30" r="2.5" fill="rgba(255,255,255,0.18)"/>
  <circle cx="6" cy="42" r="2.5" fill="rgba(255,255,255,0.18)"/><circle cx="18" cy="42" r="2.5" fill="rgba(255,255,255,0.18)"/><circle cx="30" cy="42" r="2.5" fill="rgba(255,255,255,0.18)"/><circle cx="42" cy="42" r="2.5" fill="rgba(255,255,255,0.18)"/>
</svg>
<!-- Decorative green circle bottom-left of white section -->
<div style="position:absolute;top:520px;left:-22px;width:80px;height:80px;border-radius:50%;background:rgba(62,224,127,0.18);"></div>
<!-- Decorative dark dot bottom-right -->
<div style="position:absolute;top:478px;right:22px;width:22px;height:22px;border-radius:50%;background:{{BG_COLOR}};opacity:.35;"></div>
<!-- ── Logo / brand ── -->
<div style="position:absolute;top:16px;left:0;right:0;text-align:center;padding-right:60px;">
{{LOGO}}
<div style="color:#ffffff;font-size:22px;font-weight:900;letter-spacing:.15em;line-height:1;">7AI</div>
<div style="color:rgba(255,255,255,.45);font-size:7.5px;letter-spacing:.16em;text-transform:uppercase;margin-top:1px;">African Intelligence, Amplified</div>
</div>
<!-- ── "I AM ATTENDING" label ── -->
<div style="position:absolute;top:70px;left:0;right:0;text-align:center;display:flex;align-items:center;justify-content:center;gap:8px;">
<svg width="8" height="8" viewBox="0 0 8 8"><polygon points="0,8 4,0 8,8" fill="{{ACCENT_COLOR}}"/></svg>
<span style="color:{{ACCENT_COLOR}};font-size:10px;font-weight:800;letter-spacing:.22em;text-transform:uppercase;">I AM ATTENDING</span>
<svg width="8" height="8" viewBox="0 0 8 8"><polygon points="0,8 4,0 8,8" fill="{{ACCENT_COLOR}}"/></svg>
</div>
<!-- ── Event name ── -->
<div style="position:absolute;top:84px;left:12px;right:12px;text-align:center;">
<div style="color:#ffffff;font-size:44px;font-weight:900;line-height:.98;letter-spacing:-.02em;text-transform:uppercase;word-break:break-word;">{{EVENT_NAME}}</div>
</div>
<!-- ── 2026 badge ── -->
<div style="position:absolute;top:210px;left:50%;transform:translateX(-50%);">
<div style="border:2px solid {{ACCENT_COLOR}};color:#ffffff;font-size:20px;font-weight:900;padding:3px 22px;letter-spacing:.12em;white-space:nowrap;">2026</div>
</div>
<!-- ── "Let's Shape" ribbon left ── -->
<div style="position:absolute;top:252px;left:0;background:rgba(62,224,127,.18);border-left:3px solid {{ACCENT_COLOR}};padding:7px 10px 7px 10px;max-width:148px;">
<div style="color:#ffffff;font-size:10px;font-style:italic;line-height:1.45;font-weight:500;">Let&#39;s Shape Africa&#39;s AI Future.</div>
</div>
<!-- ── Date bubble right ── -->
<div style="position:absolute;top:244px;right:14px;width:90px;height:90px;border-radius:50%;background:rgba(255,255,255,.1);border:1.5px solid rgba(255,255,255,.28);text-align:center;padding-top:10px;">
<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin:0 auto 2px;display:block;"><rect x="1" y="2" width="14" height="13" rx="2" stroke="rgba(255,255,255,.7)" stroke-width="1.2" fill="none"/><path d="M1 6h14" stroke="rgba(255,255,255,.7)" stroke-width="1.2"/><path d="M5 1v2M11 1v2" stroke="rgba(255,255,255,.7)" stroke-width="1.2" stroke-linecap="round"/></svg>
<div style="color:#ffffff;font-size:9px;font-weight:700;letter-spacing:.04em;line-height:1.2;">7TH JULY</div>
<div style="color:{{ACCENT_COLOR}};font-size:13px;font-weight:900;letter-spacing:.05em;line-height:1.2;">2026</div>
<div style="color:rgba(255,255,255,.6);font-size:7px;letter-spacing:.04em;line-height:1.3;">ABUJA<br>NIGERIA</div>
</div>
<!-- ── Photo circle: 190px, centered at 355px boundary → top:260px, bottom:450px ── -->
<div style="position:absolute;top:260px;left:175px;width:190px;height:190px;border-radius:50%;overflow:hidden;border:4px solid {{ACCENT_COLOR}};background:#1e3a5f;z-index:10;">
<img src="{{PHOTO}}" style="width:182px;height:182px;border-radius:50%;object-fit:cover;display:block;position:relative;z-index:2;" onerror="this.style.display='none'">
<svg xmlns="http://www.w3.org/2000/svg" width="182" height="182" viewBox="0 0 182 182" style="position:absolute;top:0;left:0;z-index:1;"><circle cx="91" cy="91" r="91" fill="#1e3a5f"/><circle cx="91" cy="72" r="32" fill="#4a6888"/><ellipse cx="91" cy="160" rx="56" ry="40" fill="#4a6888"/></svg>
</div>
<!-- ── White section: Name + role ── photo bottom: 450, content top: 458 -->
<div style="position:absolute;top:456px;left:0;right:0;text-align:center;padding:0 20px;">
<div style="color:#0A1628;font-size:18px;font-weight:800;line-height:1.1;margin-bottom:2px;word-break:break-word;">{{NAME}}</div>
<div style="color:#778899;font-size:9.5px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;min-height:12px;">{{ROLE}}</div>
</div>
<!-- ── "I AM / ATTENDING / THE FUTURE." stacked ── -->
<div style="position:absolute;top:494px;left:0;right:0;text-align:center;line-height:1.05;">
<div style="color:#0A1628;font-size:29px;font-weight:900;letter-spacing:.01em;">I AM</div>
<div style="color:{{ACCENT_COLOR}};font-size:29px;font-weight:900;letter-spacing:.01em;">ATTENDING</div>
<div style="color:#0A1628;font-size:29px;font-weight:900;letter-spacing:.01em;">THE FUTURE.</div>
</div>
<!-- ── Hashtag ── -->
<div style="position:absolute;top:584px;left:0;right:0;text-align:center;">
<div style="color:{{ACCENT_COLOR}};font-size:10px;font-weight:700;letter-spacing:.07em;">{{HASHTAG}}</div>
</div>
<!-- ── Icons row ── -->
<div style="position:absolute;bottom:30px;left:0;right:0;display:flex;align-items:center;justify-content:center;gap:0;">
<div style="text-align:center;padding:0 16px;border-right:1px solid #dde3ec;">
<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;margin:0 auto 3px;"><path d="M12 2C9.5 2 8 4 8 6c0 1.1.4 2.1 1 2.8C7.6 9.6 7 11.2 7 13h10c0-1.8-.6-3.4-2-4.2.6-.7 1-1.7 1-2.8C16 4 14.5 2 12 2z" stroke="#8899aa" stroke-width="1.4" stroke-linejoin="round" fill="none"/><path d="M9 13v5M15 13v5M7 18h10" stroke="#8899aa" stroke-width="1.4" stroke-linecap="round"/><circle cx="9" cy="13" r="1" fill="#8899aa"/><circle cx="15" cy="13" r="1" fill="#8899aa"/></svg>
<div style="color:#8899aa;font-size:6.5px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;">AI<br>INNOVATION</div>
</div>
<div style="text-align:center;padding:0 16px;border-right:1px solid #dde3ec;">
<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;margin:0 auto 3px;"><circle cx="12" cy="7" r="2.5" stroke="#8899aa" stroke-width="1.4" fill="none"/><circle cx="5" cy="17" r="2" stroke="#8899aa" stroke-width="1.4" fill="none"/><circle cx="19" cy="17" r="2" stroke="#8899aa" stroke-width="1.4" fill="none"/><path d="M12 9.5v3M12 12.5l-5.5 3M12 12.5l5.5 3" stroke="#8899aa" stroke-width="1.4" stroke-linecap="round"/></svg>
<div style="color:#8899aa;font-size:6.5px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;">NETWORK</div>
</div>
<div style="text-align:center;padding:0 16px;border-right:1px solid #dde3ec;">
<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;margin:0 auto 3px;"><path d="M12 2a6 6 0 0 1 4.5 10L15 14H9l-1.5-2A6 6 0 0 1 12 2z" stroke="#8899aa" stroke-width="1.4" stroke-linejoin="round" fill="none"/><path d="M9.5 14v2a2.5 2.5 0 0 0 5 0v-2" stroke="#8899aa" stroke-width="1.4" stroke-linejoin="round"/><path d="M10 22h4" stroke="#8899aa" stroke-width="1.4" stroke-linecap="round"/></svg>
<div style="color:#8899aa;font-size:6.5px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;">LEARN</div>
</div>
<div style="text-align:center;padding:0 16px;">
<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;margin:0 auto 3px;"><circle cx="12" cy="12" r="9.5" stroke="#8899aa" stroke-width="1.4" fill="none"/><path d="M2.5 12h19M12 2.5C10 6 9 9 9 12s1 6 3 9.5M12 2.5C14 6 15 9 15 12s-1 6-3 9.5" stroke="#8899aa" stroke-width="1.4"/></svg>
<div style="color:#8899aa;font-size:6.5px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;">IMPACT</div>
</div>
</div>
<!-- ── Footer ── -->
<div style="position:absolute;bottom:8px;left:0;right:0;text-align:center;display:flex;align-items:center;justify-content:center;gap:5px;">
<svg width="10" height="10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9.5" stroke="rgba(10,22,40,.35)" stroke-width="1.8" fill="none"/><path d="M2.5 12h19M12 2.5C10 6 9 9 9 12s1 6 3 9.5M12 2.5C14 6 15 9 15 12s-1 6-3 9.5" stroke="rgba(10,22,40,.35)" stroke-width="1.8"/></svg>
<div style="color:rgba(10,22,40,.35);font-size:8px;letter-spacing:.1em;">www.7ai.africa</div>
</div>
</div>
FLYERHTML;
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
        $portalUrl = match(true) {
            $user->hasRole('front-desk-staff') => route('staff.front-desk'),
            $user->hasRole('lunch-staff')      => route('staff.lunch-scanner'),
            default                            => route('admin.dashboard'),
        };

        try {
            \App\Services\SmtpMailService::configure();
            \Illuminate\Support\Facades\Mail::html(
                view('emails.staff-credentials', [
                    'user'          => $user,
                    'plain_password'=> $plainPassword,
                    'portal_url'    => $portalUrl,
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
