<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function index() {
        $settings = Setting::all()->keyBy('key');
        $socialLinks = SocialLink::orderBy('sort_order')->get();
        return view('admin.site-settings.index', compact('settings', 'socialLinks'));
    }

    public function update(Request $request) {
        $fields = [
            'site_name', 'site_tagline', 'logo', 'favicon', 'contact_phone',
            'whatsapp_number', 'contact_email', 'address', 'footer_text',
            'copyright_text', 'default_seo_title', 'default_seo_description',
            'primary_color', 'secondary_color',
        ];
        foreach ($fields as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key), 'general');
            }
        }
        return redirect()->route('admin.site-settings.index')->with('success', 'Settings saved.');
    }

    public function storeSocial(Request $request) {
        $data = $request->validate([
            'platform' => 'required|max:50',
            'url' => 'required|url|max:500',
            'icon' => 'nullable|max:100',
            'sort_order' => 'nullable|integer',
        ]);
        $data['is_active'] = true;
        SocialLink::create($data);
        return redirect()->route('admin.site-settings.index')->with('success', 'Social link added.');
    }

    public function destroySocial(SocialLink $socialLink) {
        $socialLink->delete();
        return redirect()->route('admin.site-settings.index')->with('success', 'Social link deleted.');
    }
}
