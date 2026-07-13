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
use App\Services\SmtpMailService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

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
        $teamMembers  = \App\Models\TeamMember::active()->orderByDesc('is_featured')->orderBy('sort_order')->orderBy('name')->limit(8)->get();
        return view('public.index', compact('page', 'testimonials', 'homeCards', 'aiCards', 'processCards', 'heroCta', 'bottomCta', 'latestPosts', 'settings', 'teamMembers'));
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
        $teamMembers  = \App\Models\TeamMember::active()->orderByDesc('is_featured')->orderBy('sort_order')->orderBy('name')->get();
        return view('public.about', compact('page', 'testimonials', 'heroCta', 'settings', 'teamMembers'));
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

        // ── 1. Validate form fields ────────────────────────────────────────────
        $rules = [];
        foreach ($form->fields as $field) {
            if (!$field->is_active) continue;
            $fieldRules = [];
            if ($field->is_required) $fieldRules[] = 'required';
            if ($field->field_type === 'email') $fieldRules[] = 'email';
            if ($field->field_type === 'number') $fieldRules[] = 'numeric';
            $rules[$field->name] = $fieldRules ?: 'nullable';
        }
        $validated = $request->validate($rules);

        $data = [];
        foreach ($form->fields as $field) {
            if ($field->is_active) {
                $data[$field->name] = $validated[$field->name] ?? null;
            }
        }

        // ── 2. Verify Paystack payment if required ─────────────────────────────
        if ($form->payment_enabled && $form->payment_amount > 0) {
            $ref = $request->input('_paystack_ref');
            if (!$ref) {
                return back()->with('error', 'Payment is required to complete this registration. Please click the Pay button.')->withInput();
            }
            $verified = $this->verifyPaystackPayment($ref);
            if (!$verified) {
                return back()->with('error', 'Payment could not be verified. Please try again or contact support.')->withInput();
            }
            // Store payment reference in submission data
            $data['_paystack_ref'] = $ref;
        }

        // ── 3. Duplicate prevention ────────────────────────────────────────────
        if ($form->prevent_duplicates && $form->store_submissions) {
            $dupFields = array_filter(array_map('trim', explode(',', $form->duplicate_check_fields ?? 'email')));
            foreach ($dupFields as $fieldName) {
                $submittedValue = $data[$fieldName] ?? null;
                if (!$submittedValue) continue;

                $exists = FormSubmission::where('form_id', $form->id)
                    ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.{$fieldName}')) = ?", [$submittedValue])
                    ->exists();

                if ($exists) {
                    $label = ucfirst(str_replace('_', ' ', $fieldName));
                    return back()
                        ->with('error', "You have already registered with this {$label}. Duplicate submissions are not allowed.")
                        ->withInput();
                }
            }
        }

        // ── 4. Save submission ─────────────────────────────────────────────────
        $submission = null;
        if ($form->store_submissions) {
            $submission = FormSubmission::create([
                'form_id'    => $form->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'data'       => $data,
            ]);
        }

        $successMsg = $form->success_message ?: 'Thank you! Your message has been received.';

        // ── 5. Send welcome email ──────────────────────────────────────────────
        if ($form->welcome_email_enabled) {
            $this->sendFormWelcomeEmail($form, $data);
        }

        // ── 6. Discount check ──────────────────────────────────────────────────
        if ($submission && $form->discount_enabled && $form->discount_check_form_id) {
            $this->applyDiscountIfEligible($form, $submission, $data);
        }

        if ($form->redirect_url) {
            return redirect($form->redirect_url)->with('success', $successMsg);
        }

        return back()->with('success', $successMsg);
    }

    private function verifyPaystackPayment(string $reference): bool
    {
        $secretKey = Setting::get('paystack_secret_key');
        if (!$secretKey) {
            \Log::error('[PAYMENT] Paystack secret key not configured');
            return false;
        }

        try {
            $response = \Illuminate\Support\Facades\Http::withToken($secretKey)
                ->get("https://api.paystack.co/transaction/verify/{$reference}");

            $body = $response->json();
            \Log::info('[PAYMENT] Paystack verification', [
                'ref'    => $reference,
                'status' => $body['data']['status'] ?? 'unknown',
                'amount' => $body['data']['amount'] ?? 0,
            ]);

            return $response->successful()
                && ($body['data']['status'] ?? '') === 'success';

        } catch (\Throwable $e) {
            \Log::error('[PAYMENT] Paystack verification failed', [
                'ref'   => $reference,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }


private function applyDiscountIfEligible(\App\Models\Form $form, \App\Models\FormSubmission $submission, array $data): void
    {
        // Resolve the submitter's email
        $email = null;
        foreach (['email', 'email_address', 'your_email'] as $key) {
            if (!empty($data[$key]) && filter_var($data[$key], FILTER_VALIDATE_EMAIL)) {
                $email = strtolower(trim($data[$key]));
                break;
            }
        }
        if (!$email) {
            foreach ($data as $val) {
                if (is_string($val) && filter_var($val, FILTER_VALIDATE_EMAIL)) {
                    $email = strtolower(trim($val));
                    break;
                }
            }
        }
        if (!$email) return;

        // Check if this email exists in the reference form
        $found = \App\Models\FormSubmission::where('form_id', $form->discount_check_form_id)
            ->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(data, '$.email'))) = ?", [$email])
            ->exists();

        if (!$found) return;

        // Mark discount on the submission
        $submission->update([
            'discount_applied' => true,
            'discount_pct'     => $form->discount_percent,
        ]);

        // Send discount notification email
        $this->sendDiscountEmail($form, $submission, $data, $email);
    }

    private function sendDiscountEmail(\App\Models\Form $form, \App\Models\FormSubmission $submission, array $data, string $toEmail): void
    {
        try {
            $configured = SmtpMailService::configure();
            if (!$configured) return;

            $siteName     = \App\Models\Setting::get('site_name', '7AI');
            $supportEmail = \App\Models\Setting::get('support_email') ?: \App\Models\Setting::get('contact_email', '');
            $percent      = number_format((float) $form->discount_percent, 0);

            $submittedName = $data['full_name'] ?? $data['name']
                ?? (trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')) ?: null)
                ?? '';

            $vars = array_merge($data, [
                'name'             => $submittedName,
                'email'            => $toEmail,
                'form_name'        => $form->name,
                'site_name'        => $siteName,
                'support_email'    => $supportEmail,
                'discount_percent' => $percent,
                'current_year'     => date('Y'),
            ]);

            $replace = fn(string $text) => preg_replace_callback(
                '/\{\{(\w+)\}\}/',
                fn($m) => $vars[$m[1]] ?? '',
                $text
            );

            $subject = $replace(
                $form->discount_email_subject
                ?: "🎉 You qualify for a {$percent}% discount — {$form->name}"
            );

            $defaultBody = <<<HTML
<div style="font-family:sans-serif;max-width:560px;margin:40px auto;padding:32px;background:#f9fafb;border-radius:10px;border:1px solid #e5e7eb;">
  <h2 style="color:#0b4f6c;margin-top:0;">Hello {$vars['name']},</h2>
  <p style="color:#374151;line-height:1.7;">Thank you for registering for <strong>{$vars['form_name']}</strong>.</p>
  <p style="color:#374151;line-height:1.7;">Because you previously registered for our conference, you qualify for a <strong style="color:#16a34a;">{$percent}% discount</strong> on this course!</p>
  <p style="color:#374151;line-height:1.7;">Our team will reach out to you shortly with payment details reflecting your discounted price.</p>
  <p style="color:#374151;line-height:1.7;">Thank you,<br><strong>{$vars['site_name']}</strong></p>
  <hr style="border:none;border-top:1px solid #e5e7eb;margin:24px 0;">
  <p style="font-size:12px;color:#9ca3af;">If you have questions, contact us at {$vars['support_email']}.</p>
  <p style="font-size:11px;color:#d1d5db;">© {$vars['current_year']} {$vars['site_name']}</p>
</div>
HTML;

            $htmlBody = $form->discount_email_body ? $replace($form->discount_email_body) : $defaultBody;

            $fromName = $form->discount_email_from_name    ?: \App\Models\Setting::get('mail_from_name', '7AI');
            $fromAddr = $form->discount_email_from_address ?: \App\Models\Setting::get('mail_from_address', 'hello@7ai.africa');

            Mail::html($htmlBody, fn($msg) => $msg->to($toEmail)->subject($subject)->from($fromAddr, $fromName));

            $submission->update(['discount_email_sent_at' => now()]);

            \Log::info('[DISCOUNT EMAIL] Sent', ['to' => $toEmail, 'form' => $form->id, 'pct' => $percent]);
        } catch (\Throwable $e) {
            \Log::error('[DISCOUNT EMAIL ERROR]', ['error' => $e->getMessage(), 'form' => $form->id]);
        }
    }

    private function sendFormWelcomeEmail(\App\Models\Form $form, array $data): void
    {
        \Log::info('[FORM EMAIL] Attempting welcome email', [
            'form'    => $form->id,
            'form_name' => $form->name,
        ]);

        // ── 1. Resolve recipient email ─────────────────────────────────────────
        $toEmail = null;

        // Priority 1: explicit field set in form settings
        if ($form->welcome_email_field && !empty($data[$form->welcome_email_field])
            && filter_var($data[$form->welcome_email_field], FILTER_VALIDATE_EMAIL)) {
            $toEmail = $data[$form->welcome_email_field];
        }

        // Priority 2: look for common email field names
        if (!$toEmail) {
            foreach (['email', 'email_address', 'your_email', 'registrant_email'] as $key) {
                if (!empty($data[$key]) && filter_var($data[$key], FILTER_VALIDATE_EMAIL)) {
                    $toEmail = $data[$key];
                    break;
                }
            }
        }

        // Priority 3: first field of type email in the form
        if (!$toEmail) {
            $emailField = $form->fields->where('field_type', 'email')->where('is_active', true)->first();
            if ($emailField && !empty($data[$emailField->name])) {
                $toEmail = $data[$emailField->name];
            }
        }

        // Priority 4: scan all submitted values for anything that looks like an email
        if (!$toEmail) {
            foreach ($data as $val) {
                if (is_string($val) && filter_var($val, FILTER_VALIDATE_EMAIL)) {
                    $toEmail = $val;
                    break;
                }
            }
        }

        if (!$toEmail) {
            \Log::warning('[FORM EMAIL] No recipient email found in submission', [
                'form'   => $form->id,
                'fields' => array_keys($data),
            ]);
            return;
        }

        \Log::info('[FORM EMAIL] Recipient resolved', ['to' => $toEmail, 'form' => $form->id]);

        // ── 2. Build template variables ────────────────────────────────────────
        $siteName     = Setting::get('site_name', '7AI');
        $supportEmail = Setting::get('support_email') ?: Setting::get('contact_email', '');

        // Try to resolve a human-readable name from submitted fields
        $submittedName = $data['name']
            ?? $data['full_name']
            ?? (trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')) ?: null)
            ?? $data['your_name']
            ?? '';

        $vars = array_merge($data, [
            'name'          => $submittedName,
            'email'         => $toEmail,
            'form_name'     => $form->name,
            'site_name'     => $siteName,
            'support_email' => $supportEmail,
            'current_year'  => date('Y'),
        ]);

        $replace = fn(string $text) => preg_replace_callback(
            '/\{\{(\w+)\}\}/',
            fn($m) => $vars[$m[1]] ?? '',
            $text
        );

        // ── 3. Subject & body (with defaults if admin left them blank) ─────────
        $subject = $replace(
            $form->welcome_email_subject
            ?: 'Thank you for registering — ' . $form->name
        );

        $defaultBody = <<<HTML
<div style="font-family:sans-serif;max-width:560px;margin:40px auto;padding:32px;background:#f9fafb;border-radius:10px;border:1px solid #e5e7eb;">
  <h2 style="color:#0b4f6c;margin-top:0;">Hello {$vars['name']},</h2>
  <p style="color:#374151;line-height:1.7;">Thank you for registering for <strong>{$vars['form_name']}</strong>.</p>
  <p style="color:#374151;line-height:1.7;">We have received your submission successfully. Our team will review your details and contact you if necessary.</p>
  <p style="color:#374151;line-height:1.7;">Thank you,<br><strong>{$vars['site_name']}</strong></p>
  <hr style="border:none;border-top:1px solid #e5e7eb;margin:24px 0;">
  <p style="font-size:12px;color:#9ca3af;">If you have questions, contact us at {$vars['support_email']}.</p>
  <p style="font-size:11px;color:#d1d5db;">© {$vars['current_year']} {$vars['site_name']}</p>
</div>
HTML;

        $htmlBody = $form->welcome_email_body
            ? $replace($form->welcome_email_body)
            : $defaultBody;

        $fromName = $form->welcome_email_from_name    ?: Setting::get('mail_from_name', '7AI');
        $fromAddr = $form->welcome_email_from_address ?: Setting::get('mail_from_address', 'hello@7ai.africa');

        // ── 4. Configure SMTP & send ───────────────────────────────────────────
        try {
            $configured = SmtpMailService::configure();

            if (!$configured) {
                \Log::warning('[FORM EMAIL] SMTP not configured — email not sent', ['form' => $form->id]);
                return;
            }

            Mail::html($htmlBody, function ($msg) use ($toEmail, $subject, $fromName, $fromAddr) {
                $msg->to($toEmail)->subject($subject)->from($fromAddr, $fromName);
            });

            \Log::info('[FORM EMAIL] Welcome email sent', [
                'to'   => $toEmail,
                'form' => $form->id,
                'subj' => $subject,
            ]);
        } catch (\Throwable $e) {
            \Log::error('[FORM EMAIL ERROR] Failed to send welcome email', [
                'to'    => $toEmail,
                'form'  => $form->id,
                'error' => $e->getMessage(),
                'file'  => $e->getFile() . ':' . $e->getLine(),
            ]);
            // Never break the form submission — silently continue
        }
    }

    public function cmsPage(string $slug)
    {
        $page = \App\Models\Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
        return view('public.cms-page', compact('page'));
    }
}
