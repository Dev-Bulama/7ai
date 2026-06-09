<?php
namespace App\Http\Controllers;

use App\Models\Post;
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

class FrontendController extends Controller
{
    private function siteSettings(): array
    {
        return [
            'site_name'    => Setting::get('site_name', '7AI'),
            'contact_phone'=> Setting::get('contact_phone', ''),
            'contact_email'=> Setting::get('contact_email', ''),
            'address'      => Setting::get('address', ''),
            'footer_text'  => Setting::get('footer_text', 'African Intelligence, Amplified.'),
            'copyright'    => Setting::get('copyright_text', '© 2025 7AI Technologies. All rights reserved.'),
            'logo'         => Setting::get('logo', '/assets/images/logo-white.svg'),
        ];
    }

    public function home()
    {
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->limit(6)->get();
        $homeCards = Card::where('is_active', true)->where('group', 'smart-home')->orderBy('sort_order')->limit(9)->get();
        $aiCards = Card::where('is_active', true)->where('group', 'ai-solutions')->orderBy('sort_order')->limit(9)->get();
        $heroCta = Cta::where('is_active', true)->where('name', 'home_hero')->first();
        $bottomCta = Cta::where('is_active', true)->where('name', 'home_cta')->first();
        $latestPosts = Post::with('category')->where('status', 'published')->orderByDesc('published_at')->limit(3)->get();
        $settings = $this->siteSettings();
        return view('public.index', compact('testimonials', 'homeCards', 'aiCards', 'heroCta', 'bottomCta', 'latestPosts', 'settings'));
    }

    public function solutions()
    {
        $serviceCategories = ServiceCategory::with('services')->where('is_active', true)->orderBy('sort_order')->get();
        $settings = $this->siteSettings();
        return view('public.solutions', compact('serviceCategories', 'settings'));
    }

    public function smartHomes()
    {
        $category = ServiceCategory::where('slug', 'smart-homes')->first();
        $services = Service::where('status', 'published')
            ->when($category, fn($q) => $q->where('category_id', $category->id))
            ->orderBy('sort_order')->get();
        $cards = Card::where('is_active', true)->where('group', 'smart-home')->orderBy('sort_order')->get();
        $faqs = Faq::where('is_active', true)->where('category', 'Smart Home')->orderBy('sort_order')->limit(8)->get();
        $settings = $this->siteSettings();
        return view('public.smart-homes', compact('services', 'cards', 'faqs', 'settings'));
    }

    public function aiSolutions()
    {
        $category = ServiceCategory::where('slug', 'ai-solutions')->first();
        $services = Service::where('status', 'published')
            ->when($category, fn($q) => $q->where('category_id', $category->id))
            ->orderBy('sort_order')->get();
        $cards = Card::where('is_active', true)->where('group', 'ai-solutions')->orderBy('sort_order')->get();
        $faqs = Faq::where('is_active', true)->where('category', 'AI Solutions')->orderBy('sort_order')->limit(8)->get();
        $settings = $this->siteSettings();
        return view('public.ai-solutions', compact('services', 'cards', 'faqs', 'settings'));
    }

    public function pricing()
    {
        $settings = $this->siteSettings();
        return view('public.pricing', compact('settings'));
    }

    public function caseStudies()
    {
        $settings = $this->siteSettings();
        return view('public.case-studies', compact('settings'));
    }

    public function industries()
    {
        $cards = Card::where('is_active', true)->where('group', 'industries')->orderBy('sort_order')->get();
        $settings = $this->siteSettings();
        return view('public.industries', compact('cards', 'settings'));
    }

    public function about()
    {
        $testimonials = Testimonial::where('is_active', true)->where('is_featured', true)->orderBy('sort_order')->limit(3)->get();
        $settings = $this->siteSettings();
        return view('public.about', compact('testimonials', 'settings'));
    }

    public function careers()
    {
        $settings = $this->siteSettings();
        return view('public.careers', compact('settings'));
    }

    public function blog()
    {
        $posts = Post::with('author', 'category')
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->paginate(9);
        $categories = Category::all();
        $settings = $this->siteSettings();
        return view('public.blog', compact('posts', 'categories', 'settings'));
    }

    public function contact()
    {
        $contactForm = Form::where('slug', 'contact')->where('is_active', true)->with('fields')->first();
        $faqs = Faq::where('is_active', true)->where('category', 'Contact')->orderBy('sort_order')->limit(5)->get();
        $settings = $this->siteSettings();
        return view('public.contact', compact('contactForm', 'faqs', 'settings'));
    }

    public function support()
    {
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->limit(12)->get();
        $settings = $this->siteSettings();
        return view('public.support', compact('faqs', 'settings'));
    }

    public function docs()
    {
        $settings = $this->siteSettings();
        return view('public.docs', compact('settings'));
    }

    public function privacy()
    {
        $settings = $this->siteSettings();
        return view('public.privacy', compact('settings'));
    }

    public function terms()
    {
        $settings = $this->siteSettings();
        return view('public.terms', compact('settings'));
    }

    public function investors()
    {
        $settings = $this->siteSettings();
        return view('public.investors', compact('settings'));
    }

    public function submitForm(Request $request, Form $form)
    {
        if (!$form->is_active) {
            return back()->with('error', 'This form is not available.');
        }

        $rules = [];
        $data = [];
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

        if ($form->redirect_url) {
            return redirect($form->redirect_url)->with('success', $successMsg);
        }

        return back()->with('success', $successMsg);
    }
}
