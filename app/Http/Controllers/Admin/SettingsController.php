<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SmtpMailService;
use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings  = Setting::all()->keyBy('key');
        $socialLinks = SocialLink::orderBy('sort_order')->get();
        return view('admin.settings.index', compact('settings', 'socialLinks'));
    }

    public function update(Request $request)
    {
        $groups = [
            'general'  => ['site_name','site_tagline','default_timezone','default_language'],
            'brand'    => ['logo','favicon','footer_logo','primary_color','secondary_color'],
            'contact'  => ['contact_email','support_email','contact_phone','whatsapp_number','address','location'],
            'mail'     => ['mail_host','mail_port','mail_username','mail_password','mail_encryption','mail_from_name','mail_from_address'],
            'seo'      => ['meta_title','meta_description','meta_keywords','og_image','default_seo_title','default_seo_description'],
            'social'   => ['facebook_url','instagram_url','twitter_url','linkedin_url','youtube_url','tiktok_url'],
            'scripts'  => ['header_scripts','footer_scripts','google_analytics','meta_pixel','chatbot_script'],
            'system'   => ['footer_text','copyright_text','maintenance_mode','registration_enabled','email_notifications'],
            'nav'      => ['nav_cta_text','nav_cta_url','nav_secondary_text','nav_secondary_url'],
        ];

        foreach ($groups as $group => $keys) {
            foreach ($keys as $key) {
                if ($request->has($key)) {
                    $val = $request->input($key);
                    // Don't overwrite password field if left blank
                    if ($key === 'mail_password' && $val === '') continue;
                    Setting::set($key, $val ?? '', $group);
                }
            }
        }

        // Also handle settings[] array format for backward compat
        foreach ($request->settings ?? [] as $key => $value) {
            Setting::set($key, $value);
        }

        $tab = $request->input('_tab', 'general');
        return redirect()->route('admin.settings.index', ['tab' => $tab])->with('success', 'Settings saved.');
    }

    public function sendTestEmail(Request $request)
    {
        $request->validate(['test_email' => 'required|email']);
        $result = SmtpMailService::sendTestEmail($request->test_email);

        if ($result['ok']) {
            return redirect()->route('admin.settings.index', ['tab' => 'smtp'])
                ->with('success', $result['message'])
                ->with('smtp_test_ok', true);
        }

        return redirect()->route('admin.settings.index', ['tab' => 'smtp'])
            ->with('error', 'Test email failed: ' . $result['message'])
            ->with('smtp_error', $result['message']);
    }

    public function smtpDiagnostics(Request $request)
    {
        $diag   = SmtpMailService::diagnostics();
        $testTo = $request->input('send_to');
        $result = null;

        if ($testTo && filter_var($testTo, FILTER_VALIDATE_EMAIL)) {
            $result = SmtpMailService::sendTestEmail($testTo);
        }

        return view('admin.settings.smtp-diagnostics', compact('diag', 'result', 'testTo'));
    }

    public function storeSocial(Request $request)
    {
        $data = $request->validate([
            'platform'   => 'required|max:50',
            'url'        => 'required|url|max:500',
            'sort_order' => 'nullable|integer',
        ]);
        $data['is_active'] = true;
        SocialLink::create($data);
        return redirect()->route('admin.settings.index', ['tab' => 'social'])
            ->with('success', 'Social link added.');
    }

    public function destroySocial(SocialLink $socialLink)
    {
        $socialLink->delete();
        return redirect()->route('admin.settings.index', ['tab' => 'social'])
            ->with('success', 'Social link deleted.');
    }
}
