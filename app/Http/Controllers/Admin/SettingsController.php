<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        $to = $request->test_email;

        try {
            $host = Setting::get('mail_host');
            if ($host) {
                Config::set('mail.mailers.smtp.transport', 'smtp');
                Config::set('mail.mailers.smtp.host', $host);
                Config::set('mail.mailers.smtp.port', (int) Setting::get('mail_port', 587));
                Config::set('mail.mailers.smtp.username', Setting::get('mail_username'));
                Config::set('mail.mailers.smtp.password', Setting::get('mail_password'));
                Config::set('mail.mailers.smtp.encryption', Setting::get('mail_encryption', 'tls'));
                Config::set('mail.from.name', Setting::get('mail_from_name', '7AI'));
                Config::set('mail.from.address', Setting::get('mail_from_address', 'hello@7ai.africa'));
                Config::set('mail.default', 'smtp');
                app('mail.manager')->purge('smtp');
            }

            $fromName = Setting::get('mail_from_name', '7AI');
            $fromAddr = Setting::get('mail_from_address', 'hello@7ai.africa');
            $siteName = Setting::get('site_name', '7AI');

            Mail::html(
                '<div style="font-family:sans-serif;max-width:500px;margin:40px auto;padding:32px;background:#f9fafb;border-radius:8px;border:1px solid #e5e7eb;">'
                . '<h2 style="color:#0b4f6c;margin-bottom:12px;">✓ SMTP Test Email</h2>'
                . '<p style="color:#374151;line-height:1.6;">This is a test email from <strong>' . e($siteName) . '</strong>.</p>'
                . '<p style="color:#374151;line-height:1.6;">If you received this, your SMTP settings are working correctly.</p>'
                . '<p style="font-size:12px;color:#9ca3af;margin-top:24px;">Sent from: ' . e($fromAddr) . '</p>'
                . '</div>',
                function ($msg) use ($to, $fromAddr, $fromName) {
                    $msg->to($to)->from($fromAddr, $fromName)->subject('7AI — SMTP Test Email');
                }
            );

            return redirect()->route('admin.settings.index', ['tab' => 'smtp'])
                ->with('success', "Test email sent successfully to {$to}.");
        } catch (\Throwable $e) {
            Log::error('SMTP test email failed', ['error' => $e->getMessage(), 'to' => $to]);
            return redirect()->route('admin.settings.index', ['tab' => 'smtp'])
                ->with('error', 'Test email failed: ' . $e->getMessage());
        }
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
