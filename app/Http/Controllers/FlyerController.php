<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\ConferenceSetting;
use App\Http\Controllers\Admin\ConferenceController;
use Illuminate\Http\Request;

class FlyerController extends Controller
{
    public function show(string $slug)
    {
        $form = Form::where('slug', $slug)
            ->where('is_conference_form', true)
            ->where('is_active', true)
            ->firstOrFail();

        $settings = ConferenceSetting::where('form_id', $form->id)->first();

        // Build the server-side partial render (everything except NAME, ROLE, PHOTO)
        $accentColor = $settings?->badge_accent_color ?? '#3ee07f';
        $bgColor     = $settings?->badge_bg_color     ?? '#0a1628';
        $eventName   = $settings?->event_name         ?? $form->name;
        $eventDate   = $settings?->event_date?->format('jS F Y') ?? '';
        $venue       = $settings?->event_venue        ?? '';
        $hashtag     = $settings?->flyer_hashtag      ?? '#' . str_replace([' ', '-'], '', strtolower($eventName)) . date('Y');
        if ($settings?->badge_logo_path) {
            $logoHtml = '<img src="' . asset('storage/' . $settings->badge_logo_path) . '" style="height:44px;object-fit:contain;display:block;margin:0 auto 4px;" onerror="this.style.display=\'none\'">';
        } else {
            $logoHtml = '<div style="color:#ffffff;font-size:22px;font-weight:900;letter-spacing:.15em;line-height:1;">7AI</div>'
                      . '<div style="color:rgba(255,255,255,.45);font-size:7.5px;letter-spacing:.16em;text-transform:uppercase;margin-top:1px;">African Intelligence, Amplified</div>';
        }

        $rawTemplate = $settings?->flyer_html_template ?: ConferenceController::defaultFlyerTemplate();

        // Replace server-side placeholders (everything except NAME, ROLE, PHOTO)
        $serverKeys = ['{{EVENT_NAME}}','{{EVENT_DATE}}','{{EVENT_VENUE}}','{{HASHTAG}}',
                       '{{LOGO}}','{{ACCENT_COLOR}}','{{BG_COLOR}}'];
        $serverVals = [$eventName, $eventDate, $venue, $hashtag,
                       $logoHtml, $accentColor, $bgColor];

        $template = str_replace($serverKeys, $serverVals, $rawTemplate);

        return view('conference.flyer', compact('form', 'settings', 'template', 'eventName', 'hashtag', 'accentColor', 'bgColor'));
    }
}
