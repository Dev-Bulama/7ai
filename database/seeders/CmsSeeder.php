<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Card;
use App\Models\Cta;
use App\Models\Form;
use App\Models\FormField;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\SocialLink;
use App\Models\Setting;
use App\Models\User;
use App\Models\Page;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@7ai.africa')->first();

        // ── Service Categories ──────────────────────────────────────────
        $smartHome = ServiceCategory::firstOrCreate(['slug' => 'smart-homes'], [
            'name' => 'Smart Homes', 'description' => 'Complete smart home automation solutions', 'sort_order' => 1, 'is_active' => true,
        ]);
        $aiCat = ServiceCategory::firstOrCreate(['slug' => 'ai-solutions'], [
            'name' => 'AI Solutions', 'description' => 'Enterprise-grade AI and automation', 'sort_order' => 2, 'is_active' => true,
        ]);
        $energyCat = ServiceCategory::firstOrCreate(['slug' => 'energy'], [
            'name' => 'Energy & Solar', 'description' => 'Smart energy management', 'sort_order' => 3, 'is_active' => true,
        ]);
        $securityCat = ServiceCategory::firstOrCreate(['slug' => 'security'], [
            'name' => 'Security Systems', 'description' => 'AI-powered security solutions', 'sort_order' => 4, 'is_active' => true,
        ]);

        // ── Services ────────────────────────────────────────────────────
        $services = [
            [$smartHome->id, 'Smart Lighting', 'smart-lighting', 'Adaptive lighting that learns your routines and reduces energy by up to 60%.', 'smart-home'],
            [$smartHome->id, 'Smart Security', 'smart-security', 'AI-powered security with facial recognition, motion detection, and real-time alerts.', 'smart-home'],
            [$smartHome->id, 'Climate Control', 'climate-control', 'AI-driven climate management optimised for African temperatures.', 'smart-home'],
            [$smartHome->id, 'Smart Access', 'smart-access', 'Biometric locks, smart intercom, and keyless entry systems.', 'smart-home'],
            [$smartHome->id, 'IoT Integration', 'iot-integration', 'Connect all smart devices through one unified platform.', 'smart-home'],
            [$smartHome->id, 'Voice Automation', 'voice-automation', 'Voice control supporting English, French, Swahili, and African languages.', 'smart-home'],
            [$aiCat->id, 'Machine Learning', 'machine-learning', 'Custom ML models trained on local African datasets.', 'ai-solutions'],
            [$aiCat->id, 'Predictive Analytics', 'predictive-analytics', 'Turn raw data into forward-looking intelligence.', 'ai-solutions'],
            [$aiCat->id, 'AI Agents', 'ai-agents', 'Autonomous AI agents for complex workflows and customer interactions.', 'ai-solutions'],
            [$aiCat->id, 'Conversational AI', 'conversational-ai', 'Multilingual chatbots supporting customer service across Africa.', 'ai-solutions'],
            [$energyCat->id, 'Smart Energy', 'smart-energy', 'Solar integration and predictive energy monitoring.', 'smart-home'],
            [$securityCat->id, 'Smart Surveillance', 'smart-surveillance', 'HD cameras with AI analytics and person detection.', 'smart-home'],
        ];

        foreach ($services as $i => [$catId, $title, $slug, $desc, $group]) {
            Service::firstOrCreate(['slug' => $slug], [
                'title' => $title, 'category_id' => $catId,
                'short_description' => $desc,
                'full_description' => "<p>$desc</p><p>Our $title solution is designed specifically for African homes and businesses, providing reliable performance in local conditions. Contact us for a free consultation.</p>",
                'cta_text' => 'Learn More', 'cta_link' => '/contact',
                'status' => 'published', 'sort_order' => ($i + 1) * 10,
            ]);
        }

        // ── Cards (Smart Home) ──────────────────────────────────────────
        $smartHomeCards = [
            ['Smart Lighting', 'Adaptive lighting systems that reduce energy by 60% and set perfect ambiance automatically.', '<path d="M12 2L2 7v10a2 2 0 002 2h16a2 2 0 002-2V7L12 2z"/><path d="M9 22V12h6v10"/>'],
            ['Smart Security', 'AI-powered security with facial recognition, motion detection, and 24/7 real-time alerts.', '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>'],
            ['Smart Energy', 'Solar integration and load management — cut bills and maximise renewable energy use.', '<path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>'],
            ['Climate Control', 'AI-driven climate management adapted to African weather patterns and temperatures.', '<path d="M14 14.76V3.5a2.5 2.5 0 00-5 0v11.26A4.5 4.5 0 1014 14.76z"/>'],
            ['Smart Access', 'Biometric locks and keyless entry — grant or revoke access from anywhere in the world.', '<rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"/>'],
            ['IoT Integration', 'Connect all smart devices through one unified platform — from appliances to infrastructure.', '<circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/><path d="M2 12h20"/>'],
            ['Voice Automation', 'Seamless voice control supporting English, French, Swahili, and African languages.', '<path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/>'],
            ['AI Assistants', 'Personalised AI assistants that learn household patterns and anticipate your needs.', '<path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>'],
            ['Smart Surveillance', 'HD cameras with AI analytics, person detection, and cloud storage — full awareness.', '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>'],
        ];

        foreach ($smartHomeCards as $i => [$title, $desc, $svgPath]) {
            Card::firstOrCreate(['title' => $title, 'group' => 'smart-home'], [
                'description' => $desc,
                'icon' => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">' . $svgPath . '</svg>',
                'group' => 'smart-home', 'sort_order' => ($i + 1) * 10, 'is_active' => true,
            ]);
        }

        // ── Cards (AI Solutions) ────────────────────────────────────────
        $aiCards = [
            ['Machine Learning', 'Custom ML models trained on local African datasets for agriculture, finance, healthcare.'],
            ['Predictive Analytics', 'Turn raw data into forward-looking intelligence — forecast demand and detect anomalies.'],
            ['AI Agents', 'Autonomous AI agents that handle complex workflows and business processes around the clock.'],
            ['AI Automation', 'End-to-end process automation with intelligent decision-making capabilities.'],
            ['Business Intelligence', 'Real-time dashboards and automated reports giving teams instant actionable insights.'],
            ['Computer Vision', 'Visual AI for quality control, safety monitoring, agricultural assessment, and retail analytics.'],
            ['Conversational AI', 'Multilingual chatbots and voice assistants supporting customer service across Africa.'],
            ['Data Analytics', 'Comprehensive data engineering and analytics pipelines for your organisation.'],
            ['Custom AI Solutions', 'Bespoke AI development for unique business challenges — designed to your exact requirements.'],
        ];

        foreach ($aiCards as $i => [$title, $desc]) {
            Card::firstOrCreate(['title' => $title, 'group' => 'ai-solutions'], [
                'description' => $desc, 'group' => 'ai-solutions',
                'sort_order' => ($i + 1) * 10, 'is_active' => true,
            ]);
        }

        // ── Testimonials ────────────────────────────────────────────────
        $testimonials = [
            ['Adewale Okonkwo', 'CEO', 'Meridian Group — Lagos', '"7AI transformed our office building into a fully intelligent workspace. Energy costs dropped 45% in the first month. The AI is genuinely impressive."', 5, true],
            ['Fatima Mensah', 'Director', 'Solaris Estates — Accra', '"The smart security system and AI surveillance gave us total peace of mind. Setup was seamless and their support team is exceptional — truly world-class."', 5, true],
            ['Kwame Nkosi', 'Operations Head', 'PanAfrica Hub — Nairobi', '"We integrated 7AI\'s predictive analytics into our supply chain. Stockouts reduced by 70% and our planning is now data-driven. Outstanding results."', 5, true],
            ['Amara Diallo', 'Founder', 'TechCorp Africa — Dakar', '"The IoT integration platform connected all our devices seamlessly. Customer satisfaction scores have gone up significantly since deployment."', 5, false],
            ['Grace Kimani', 'CTO', 'NovaBuild — Nairobi', '"The custom AI solution 7AI built for our manufacturing line reduced waste by 35%. ROI was achieved in under 3 months."', 5, false],
        ];

        foreach ($testimonials as $i => [$name, $role, $company, $content, $rating, $featured]) {
            Testimonial::firstOrCreate(['author_name' => $name, 'author_company' => $company], [
                'author_role' => $role, 'content' => $content, 'rating' => $rating,
                'is_featured' => $featured, 'is_active' => true, 'sort_order' => ($i + 1) * 10,
            ]);
        }

        // ── FAQs ────────────────────────────────────────────────────────
        $faqs = [
            ['What areas do you service in Africa?', 'We currently operate in Nigeria, Ghana, Kenya, South Africa, and several other African countries. Contact us to check availability in your specific location.', 'General'],
            ['How long does a smart home installation take?', 'A standard smart home installation typically takes 2-5 days depending on the size and complexity of your home. We provide a detailed timeline during the initial consultation.', 'Installation'],
            ['Do your systems work during power outages?', 'Yes! Our systems include battery backup and UPS solutions to ensure continuous operation. We also integrate with solar power systems for complete energy independence.', 'Smart Home'],
            ['What AI platforms do you integrate with?', 'We integrate with leading AI platforms including Google AI, AWS AI services, Microsoft Azure AI, and also build custom AI solutions from scratch.', 'AI Solutions'],
            ['Do you offer ongoing support after installation?', 'Yes, we offer 24/7 technical support, regular system updates, and maintenance packages. We also provide remote monitoring to proactively address any issues.', 'Support'],
            ['How do I get started?', 'Simply book a free 30-minute consultation through our Contact page or call us directly. Our team will assess your needs and design a custom solution.', 'General'],
            ['Can I control my smart home remotely?', 'Absolutely! All our systems come with a mobile app that lets you control every device, monitor energy usage, and receive alerts from anywhere in the world.', 'Smart Home'],
            ['What is the minimum project size?', 'We work with both small residential projects and large enterprise deployments. Our smallest packages start from single-room automation.', 'General'],
        ];

        foreach ($faqs as $i => [$question, $answer, $category]) {
            Faq::firstOrCreate(['question' => $question], [
                'answer' => $answer, 'category' => $category,
                'sort_order' => ($i + 1) * 10, 'is_active' => true,
            ]);
        }

        // ── CTAs ─────────────────────────────────────────────────────────
        Cta::firstOrCreate(['name' => 'home_cta'], [
            'title' => 'Ready to Transform Your Home or Business?',
            'text' => 'Book a free 30-minute consultation with our experts and discover what AI automation can do for you.',
            'button_label' => 'Book Free Consultation',
            'button_url' => '/contact',
            'button2_label' => 'View Pricing',
            'button2_url' => '/pricing',
            'is_active' => true,
        ]);

        Cta::firstOrCreate(['name' => 'home_hero'], [
            'title' => 'African Intelligence, Amplified.',
            'text' => 'Transforming homes, businesses, and communities through AI-powered automation and intelligent technology solutions built for Africa\'s future.',
            'button_label' => 'Book Consultation',
            'button_url' => '/contact',
            'button2_label' => 'Register as Investor',
            'button2_url' => '/investors',
            'is_active' => true,
        ]);

        // ── Contact Form ─────────────────────────────────────────────────
        $contactForm = Form::firstOrCreate(['slug' => 'contact'], [
            'name' => 'Contact Form',
            'description' => 'Main contact form for lead generation',
            'success_message' => 'Thank you for reaching out! Our team will contact you within 24 hours.',
            'notification_email' => 'hello@7ai.africa',
            'store_submissions' => true,
            'is_active' => true,
        ]);

        if ($contactForm->wasRecentlyCreated) {
            $fields = [
                ['First Name', 'first_name', 'text', 'John', true, 10],
                ['Last Name', 'last_name', 'text', 'Doe', true, 20],
                ['Email Address', 'email', 'email', 'john@example.com', true, 30],
                ['Phone Number', 'phone', 'phone', '+234 800 000 0000', false, 40],
                ['Company / Organisation', 'company', 'text', 'Acme Corp', false, 50],
                ['Country', 'country', 'select', 'Select country...', false, 60],
                ['Service Interest', 'service_interest', 'select', 'Select service...', true, 70],
                ['Message', 'message', 'textarea', 'Tell us about your project...', true, 80],
            ];

            $countryOptions = implode("\n", ['Nigeria','Ghana','Kenya','South Africa','Egypt','Tanzania','Ethiopia','Uganda','Senegal','Other']);
            $serviceOptions = implode("\n", ['Smart Home Automation','AI Solutions','Energy Management','Security Systems','IoT Integration','Custom AI Development','Other']);

            foreach ($fields as [$label, $name, $type, $placeholder, $required, $sort]) {
                $opts = null;
                if ($name === 'country') $opts = $countryOptions;
                if ($name === 'service_interest') $opts = $serviceOptions;

                FormField::firstOrCreate(['form_id' => $contactForm->id, 'name' => $name], [
                    'label' => $label, 'field_type' => $type, 'placeholder' => $placeholder,
                    'is_required' => $required, 'options' => $opts,
                    'sort_order' => $sort, 'is_active' => true,
                ]);
            }
        }

        // ── Investor Form ────────────────────────────────────────────────
        $investorForm = Form::firstOrCreate(['slug' => 'investor-registration'], [
            'name' => 'Investor Registration',
            'success_message' => 'Thank you for your interest! Our investor relations team will contact you within 48 hours.',
            'store_submissions' => true,
            'is_active' => true,
        ]);

        if ($investorForm->wasRecentlyCreated) {
            $fields = [
                ['Full Name', 'full_name', 'text', 'Your full name', true, 10],
                ['Email Address', 'email', 'email', 'your@email.com', true, 20],
                ['Phone Number', 'phone', 'phone', '+1 234 567 8900', true, 30],
                ['Country', 'country', 'select', 'Select country', true, 40],
                ['Investment Range', 'investment_range', 'select', 'Select range', true, 50],
                ['Investor Type', 'investor_type', 'select', 'Select type', true, 60],
                ['Additional Notes', 'notes', 'textarea', 'Tell us about your investment interests...', false, 70],
            ];
            $investmentOptions = '$10K - $50K' . "\n$50K - $250K\n$250K - $1M\n$1M+";
            $investorTypeOptions = "Individual Investor\nInstitutional Investor\nVC / Angel Fund\nCorporate / Strategic\nOther";

            foreach ($fields as [$label, $name, $type, $placeholder, $required, $sort]) {
                $opts = null;
                if ($name === 'country') $opts = implode("\n", ['Nigeria','Ghana','Kenya','South Africa','UK','USA','UAE','Other']);
                if ($name === 'investment_range') $opts = $investmentOptions;
                if ($name === 'investor_type') $opts = $investorTypeOptions;

                FormField::firstOrCreate(['form_id' => $investorForm->id, 'name' => $name], [
                    'label' => $label, 'field_type' => $type, 'placeholder' => $placeholder,
                    'is_required' => $required, 'options' => $opts,
                    'sort_order' => $sort, 'is_active' => true,
                ]);
            }
        }

        // ── Menus ────────────────────────────────────────────────────────
        $headerMenu = Menu::firstOrCreate(['location' => 'header'], ['name' => 'Main Navigation']);
        if ($headerMenu->allItems()->count() === 0) {
            $solutionsItem = MenuItem::create([
                'menu_id' => $headerMenu->id, 'label' => 'Solutions', 'type' => 'custom',
                'url' => '/solutions', 'target' => '_self', 'order' => 10, 'is_active' => true,
            ]);
            MenuItem::create(['menu_id' => $headerMenu->id, 'parent_id' => $solutionsItem->id, 'label' => 'Smart Homes', 'type' => 'custom', 'url' => '/smart-homes', 'target' => '_self', 'order' => 10, 'is_active' => true]);
            MenuItem::create(['menu_id' => $headerMenu->id, 'parent_id' => $solutionsItem->id, 'label' => 'AI Solutions', 'type' => 'custom', 'url' => '/ai-solutions', 'target' => '_self', 'order' => 20, 'is_active' => true]);
            MenuItem::create(['menu_id' => $headerMenu->id, 'parent_id' => $solutionsItem->id, 'label' => 'Industries', 'type' => 'custom', 'url' => '/industries', 'target' => '_self', 'order' => 30, 'is_active' => true]);
            foreach ([['Pricing', '/pricing', 20], ['Case Studies', '/case-studies', 30], ['Blog', '/blog', 40], ['About', '/about', 50], ['Contact', '/contact', 60]] as [$label, $url, $order]) {
                MenuItem::create(['menu_id' => $headerMenu->id, 'label' => $label, 'type' => 'custom', 'url' => $url, 'target' => '_self', 'order' => $order, 'is_active' => true]);
            }
        }

        $footerMenu = Menu::firstOrCreate(['location' => 'footer'], ['name' => 'Footer Navigation']);

        // ── Social Links ─────────────────────────────────────────────────
        $socialLinks = [
            ['twitter', 'https://twitter.com/7aitechnologies', 10],
            ['linkedin', 'https://linkedin.com/company/7ai-technologies', 20],
            ['youtube', 'https://youtube.com/@7aitechnologies', 30],
            ['instagram', 'https://instagram.com/7aitechnologies', 40],
        ];

        foreach ($socialLinks as [$platform, $url, $sort]) {
            SocialLink::firstOrCreate(['platform' => $platform], [
                'url' => $url, 'is_active' => true, 'sort_order' => $sort,
            ]);
        }

        // ── Site Settings ─────────────────────────────────────────────────
        $siteSettings = [
            ['site_name', '7AI Technologies', 'general'],
            ['site_tagline', 'African Intelligence, Amplified.', 'general'],
            ['logo', '/assets/images/logo-white.svg', 'general'],
            ['contact_phone', '+234 800 7AI-TECH', 'general'],
            ['contact_email', 'hello@7ai.africa', 'general'],
            ['whatsapp_number', '+2348007248324', 'general'],
            ['address', 'Victoria Island, Lagos, Nigeria', 'general'],
            ['footer_text', 'African Intelligence, Amplified. Transforming homes and businesses through AI-powered automation built for Africa\'s future.', 'general'],
            ['copyright_text', '© 2025 7AI Technologies. All rights reserved. Built for Africa.', 'general'],
            ['default_seo_title', '7AI — African Intelligence, Amplified', 'seo'],
            ['default_seo_description', 'Smart home automation and enterprise AI solutions built for Africa.', 'seo'],
            ['primary_color', '#0B4F6C', 'design'],
            ['secondary_color', '#3EE07F', 'design'],
        ];

        foreach ($siteSettings as [$key, $value, $group]) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        }

        // ── Sample Pages ─────────────────────────────────────────────────
        if ($admin) {
            Page::firstOrCreate(['slug' => 'home'], [
                'title' => 'Home',
                'hero_title' => 'African Intelligence, Amplified.',
                'hero_subtitle' => 'Now Available Across Africa',
                'hero_description' => 'Transforming homes, businesses, and communities through AI-powered automation and intelligent technology solutions built for Africa\'s future.',
                'cta_text' => 'Book Consultation',
                'cta_link' => '/contact',
                'template' => 'home',
                'status' => 'published',
                'published_at' => now(),
                'created_by' => $admin->id,
            ]);

            Page::firstOrCreate(['slug' => 'about'], [
                'title' => 'About 7AI',
                'hero_title' => 'Built for Africa\'s Future',
                'hero_subtitle' => 'Our Story',
                'hero_description' => 'We are a technology company on a mission to bring intelligent automation to every African home and business.',
                'template' => 'default',
                'status' => 'published',
                'published_at' => now(),
                'created_by' => $admin->id,
            ]);
        }

        $this->command->info('CMS content seeded successfully!');
        $this->command->info('Seeded: Services, Cards, Testimonials, FAQs, CTAs, Forms, Menus, Social Links, Settings');
    }
}
