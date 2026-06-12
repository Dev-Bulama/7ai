<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Page;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Card;
use App\Models\Cta;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class FrontendController extends Controller
{
    private function siteSettings(): array
    {
        return [
            'site_name'         => Setting::get('site_name', '7AI Technologies'),
            'site_tagline'      => Setting::get('site_tagline', 'African Intelligence, Amplified.'),
            'contact_phone'     => Setting::get('contact_phone', ''),
            'contact_email'     => Setting::get('contact_email', ''),
            'address'           => Setting::get('address', ''),
            'footer_text'       => Setting::get('footer_text', 'African Intelligence, Amplified.'),
            'copyright'         => Setting::get('copyright_text', '© 2025 7AI Technologies. All rights reserved.'),
            'logo'              => Setting::get('logo', '/assets/images/logo-white.svg'),
            'homes_automated'   => Setting::get('homes_automated', '500+'),
            'business_clients'  => Setting::get('business_clients', '120+'),
            'satisfaction_rate' => Setting::get('satisfaction_rate', '98%'),
            'african_countries' => Setting::get('african_countries', '12+'),
            'whatsapp_number'   => Setting::get('whatsapp_number', ''),
        ];
    }

    private function page(string $slug): ?Page
    {
        return Page::where('slug', $slug)->where('status', 'published')->first();
    }

    public function home()
    {
        $page         = $this->page('home');
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->limit(6)->get();
        $homeCards    = Card::where('is_active', true)->where('group', 'smart-home')->orderBy('sort_order')->limit(9)->get();
        $aiCards      = Card::where('is_active', true)->where('group', 'ai-solutions')->orderBy('sort_order')->limit(9)->get();
        $processCards = Card::where('is_active', true)->where('group', 'process')->orderBy('sort_order')->limit(6)->get();
        $heroCta      = Cta::where('is_active', true)->where('name', 'home_hero')->first();
        $bottomCta    = Cta::where('is_active', true)->where('name', 'home_cta')->first();
        $latestPosts  = Post::with('category')->where('status', 'published')->orderByDesc('published_at')->limit(3)->get();
        $settings     = $this->siteSettings();
        return view('public.index', compact('page', 'testimonials', 'homeCards', 'aiCards', 'processCards', 'heroCta', 'bottomCta', 'latestPosts', 'settings'));
    }

    public function solutions()
    {
        $page             = $this->page('solutions');
        $serviceCategories = ServiceCategory::with('services')->where('is_active', true)->orderBy('sort_order')->get();
        $heroCta          = Cta::where('is_active', true)->where('name', 'solutions_hero')->first();
        $settings         = $this->siteSettings();
        return view('public.solutions', compact('page', 'serviceCategories', 'heroCta', 'settings'));
    }

    public function smartHomes()
    {
        $page     = $this->page('smart-homes');
        $category = ServiceCategory::where('slug', 'smart-homes')->first();
        $services = Service::where('status', 'published')
            ->when($category, fn($q) => $q->where('category_id', $category->id))
            ->orderBy('sort_order')->get();
        $cards    = Card::where('is_active', true)->where('group', 'smart-home')->orderBy('sort_order')->get();
        $faqs     = Faq::where('is_active', true)->where('category', 'Smart Home')->orderBy('sort_order')->limit(8)->get();
        $heroCta  = Cta::where('is_active', true)->where('name', 'smart_homes_hero')->first();
        $bottomCta = Cta::where('is_active', true)->where('name', 'smart_homes_cta')->first();
        $settings = $this->siteSettings();
        return view('public.smart-homes', compact('page', 'services', 'cards', 'faqs', 'heroCta', 'bottomCta', 'settings'));
    }

    public function aiSolutions()
    {
        $page     = $this->page('ai-solutions');
        $category = ServiceCategory::where('slug', 'ai-solutions')->first();
        $services = Service::where('status', 'published')
            ->when($category, fn($q) => $q->where('category_id', $category->id))
            ->orderBy('sort_order')->get();
        $cards    = Card::where('is_active', true)->where('group', 'ai-solutions')->orderBy('sort_order')->get();
        $faqs     = Faq::where('is_active', true)->where('category', 'AI Solutions')->orderBy('sort_order')->limit(8)->get();
        $heroCta  = Cta::where('is_active', true)->where('name', 'ai_solutions_hero')->first();
        $bottomCta = Cta::where('is_active', true)->where('name', 'ai_solutions_cta')->first();
        $settings = $this->siteSettings();
        return view('public.ai-solutions', compact('page', 'services', 'cards', 'faqs', 'heroCta', 'bottomCta', 'settings'));
    }

    public function pricing()
    {
        $page      = $this->page('pricing');
        $cards     = Card::where('is_active', true)->where('group', 'pricing')->orderBy('sort_order')->get();
        $heroCta   = Cta::where('is_active', true)->where('name', 'pricing_cta')->first();
        $faqs      = Faq::where('is_active', true)->where('category', 'Pricing')->orderBy('sort_order')->limit(8)->get();
        $settings  = $this->siteSettings();
        return view('public.pricing', compact('page', 'cards', 'heroCta', 'faqs', 'settings'));
    }

    public function caseStudies()
    {
        $page     = $this->page('case-studies');
        $settings = $this->siteSettings();
        return view('public.case-studies', compact('page', 'settings'));
    }

    public function industries()
    {
        $page     = $this->page('industries');
        $cards    = Card::where('is_active', true)->where('group', 'industries')->orderBy('sort_order')->get();
        $heroCta  = Cta::where('is_active', true)->where('name', 'solutions_hero')->first();
        $settings = $this->siteSettings();
        return view('public.industries', compact('page', 'cards', 'heroCta', 'settings'));
    }

    public function about()
    {
        $page         = $this->page('about');
        $testimonials = Testimonial::where('is_active', true)->where('is_featured', true)->orderBy('sort_order')->limit(3)->get();
        $heroCta      = Cta::where('is_active', true)->where('name', 'about_cta')->first();
        $settings     = $this->siteSettings();
        return view('public.about', compact('page', 'testimonials', 'heroCta', 'settings'));
    }

    public function careers()
    {
        $page     = $this->page('careers');
        $heroCta  = Cta::where('is_active', true)->where('name', 'careers_hero')->first();
        $settings = $this->siteSettings();
        return view('public.careers', compact('page', 'heroCta', 'settings'));
    }

    public function blog()
    {
        $page       = $this->page('blog');
        $posts      = Post::with('author', 'category')->where('status', 'published')->orderByDesc('published_at')->paginate(9);
        $categories = Category::all();
        $heroCta    = Cta::where('is_active', true)->where('name', 'blog_cta')->first();
        $settings   = $this->siteSettings();
        return view('public.blog', compact('page', 'posts', 'categories', 'heroCta', 'settings'));
    }

    public function blogPost(Post $post)
    {
        if ($post->status !== 'published') abort(404);
        $related  = Post::with('category')->where('status', 'published')->where('id', '!=', $post->id)->orderByDesc('published_at')->limit(3)->get();
        $settings = $this->siteSettings();
        return view('public.blog-post', compact('post', 'related', 'settings'));
    }

    public function contact()
    {
        $page        = $this->page('contact');
        $contactForm = Form::where('slug', 'contact')->where('is_active', true)->with('fields')->first();
        $faqs        = Faq::where('is_active', true)->where('category', 'Contact')->orderBy('sort_order')->limit(5)->get();
        $heroCta     = Cta::where('is_active', true)->where('name', 'contact_hero')->first();
        $settings    = $this->siteSettings();
        return view('public.contact', compact('page', 'contactForm', 'faqs', 'heroCta', 'settings'));
    }

    public function support()
    {
        $page     = $this->page('support');
        $faqs     = Faq::where('is_active', true)->orderBy('sort_order')->limit(12)->get();
        $heroCta  = Cta::where('is_active', true)->where('name', 'support_hero')->first();
        $settings = $this->siteSettings();
        return view('public.support', compact('page', 'faqs', 'heroCta', 'settings'));
    }

    public function docs()
    {
        $page     = $this->page('docs');
        $settings = $this->siteSettings();
        return view('public.docs', compact('page', 'settings'));
    }

    public function privacy()
    {
        $page     = $this->page('privacy');
        $settings = $this->siteSettings();
        return view('public.privacy', compact('page', 'settings'));
    }

    public function terms()
    {
        $page     = $this->page('terms');
        $settings = $this->siteSettings();
        return view('public.terms', compact('page', 'settings'));
    }

    public function smartHome()
    {
        $page     = $this->page('smart-home');
        $features = Card::where('is_active', true)->where('group', 'smart-home-features')->orderBy('sort_order')->get();
        $faqs     = Faq::where('is_active', true)->where('category', 'Smart Home')->orderBy('sort_order')->limit(8)->get();
        $settings = $this->siteSettings();
        return view('public.smart-home', compact('page', 'features', 'faqs', 'settings'));
    }

    public function businessAutomation()
    {
        $page     = $this->page('business-automation');
        $features = Card::where('is_active', true)->where('group', 'business-automation-features')->orderBy('sort_order')->get();
        $sectors  = Card::where('is_active', true)->where('group', 'business-sectors')->orderBy('sort_order')->get();
        $faqs     = Faq::where('is_active', true)->where('category', 'Business Automation')->orderBy('sort_order')->limit(8)->get();
        $settings = $this->siteSettings();
        return view('public.business-automation', compact('page', 'features', 'sectors', 'faqs', 'settings'));
    }

    public function personalAi()
    {
        $page     = $this->page('personal-ai');
        $modules  = Card::where('is_active', true)->where('group', 'personal-ai-modules')->orderBy('sort_order')->get();
        $faqs     = Faq::where('is_active', true)->where('category', 'Personal AI')->orderBy('sort_order')->limit(8)->get();
        $settings = $this->siteSettings();
        return view('public.personal-ai', compact('page', 'modules', 'faqs', 'settings'));
    }

    public function advisory()
    {
        $page     = $this->page('advisory');
        $services = Card::where('is_active', true)->where('group', 'advisory-services')->orderBy('sort_order')->get();
        $faqs     = Faq::where('is_active', true)->where('category', 'Advisory')->orderBy('sort_order')->limit(8)->get();
        $settings = $this->siteSettings();
        return view('public.advisory', compact('page', 'services', 'faqs', 'settings'));
    }

    public function investors()
    {
        $page            = $this->page('investors');
        $investorForm    = Form::where('slug', 'investor-registration')->where('is_active', true)->with('fields')->first();
        $heroCta         = Cta::where('is_active', true)->where('name', 'investors_hero')->first();
        $settings        = $this->siteSettings();
        return view('public.investors', compact('page', 'investorForm', 'heroCta', 'settings'));
    }

    public function showForm(Form $form)
    {
        if (!$form->is_active) abort(404);
        $form->load('fields');
        $settings = $this->siteSettings();
        return view('public.form-page', compact('form', 'settings'));
    }

    public function dynamicFormPage(string $formPath)
    {
        $form = Form::where('public_path', '/'.$formPath)->where('is_active', true)->with('fields')->first();
        if (!$form) abort(404);
        $settings = $this->siteSettings();
        return view('public.form-page', compact('form', 'settings'));
    }

    public function submitForm(Request $request, Form $form)
    {
        if (!$form->is_active) {
            return back()->with('error', 'This form is not available.');
        }

        $rules = [];
        $data  = [];
        foreach ($form->fields as $field) {
            if (!$field->is_active) continue;
            $fieldRules = [];
            if ($field->is_required) $fieldRules[] = 'required';
            if ($field->field_type === 'email') $fieldRules[] = 'email';
            if ($field->field_type === 'number') $fieldRules[] = 'numeric';
            $rules[$field->name] = $fieldRules ?: 'nullable';
        }

        $validated = $request->validate($rules);

        foreach ($form->fields as $field) {
            if ($field->is_active) {
                $data[$field->name] = $validated[$field->name] ?? null;
            }
        }

        if ($form->store_submissions) {
            FormSubmission::create([
                'form_id'    => $form->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'data'       => $data,
            ]);
        }

        $successMsg = $form->success_message ?: 'Thank you! Your message has been received.';

        // Send welcome email if enabled
        if ($form->welcome_email_enabled && $form->welcome_email_body) {
            $toEmail = null;
            if ($form->welcome_email_field && isset($data[$form->welcome_email_field])) {
                $toEmail = $data[$form->welcome_email_field];
            } else {
                // Auto-detect first email field
                foreach ($data as $val) {
                    if (is_string($val) && filter_var($val, FILTER_VALIDATE_EMAIL)) {
                        $toEmail = $val;
                        break;
                    }
                }
            }

            if ($toEmail) {
                try {
                    $this->configureMailer();
                    $subject = $form->welcome_email_subject ?: 'Welcome!';
                    $fromName = $form->welcome_email_from_name ?: Setting::get('mail_from_name', config('mail.from.name'));
                    $fromAddr = $form->welcome_email_from_address ?: Setting::get('mail_from_address', config('mail.from.address'));
                    $htmlBody = $form->welcome_email_body;

                    Mail::html($htmlBody, function ($msg) use ($toEmail, $subject, $fromName, $fromAddr) {
                        $msg->to($toEmail)
                            ->subject($subject)
                            ->from($fromAddr, $fromName);
                    });
                } catch (\Throwable $e) {
                    \Log::error('Welcome email failed: ' . $e->getMessage());
                }
            }
        }

        if ($form->redirect_url) {
            return redirect($form->redirect_url)->with('success', $successMsg);
        }

        return back()->with('success', $successMsg);
    }

    private function configureMailer(): void
    {
        $host = Setting::get('mail_host');
        if (!$host) return;
        Config::set('mail.mailers.smtp.host', $host);
        Config::set('mail.mailers.smtp.port', Setting::get('mail_port', 587));
        Config::set('mail.mailers.smtp.username', Setting::get('mail_username'));
        Config::set('mail.mailers.smtp.password', Setting::get('mail_password'));
        Config::set('mail.mailers.smtp.encryption', Setting::get('mail_encryption', 'tls'));
        Config::set('mail.from.name', Setting::get('mail_from_name', '7AI'));
        Config::set('mail.from.address', Setting::get('mail_from_address', 'hello@7ai.africa'));
        Config::set('mail.default', 'smtp');
    }

    public function cmsPage(string $slug)
    {
        $page = \App\Models\Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
        return view('public.cms-page', compact('page'));
    }
}
