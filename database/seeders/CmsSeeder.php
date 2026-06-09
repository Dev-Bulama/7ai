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
use App\Models\Banner;
use App\Models\User;
use App\Models\Page;
use App\Models\SitePopup;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@7ai.africa')->first();

        // ═══════════════════════════════════════════════════════════════
        //  SITE SETTINGS
        // ═══════════════════════════════════════════════════════════════
        $siteSettings = [
            // General
            ['site_name',               '7AI Technologies',                                                       'general'],
            ['site_tagline',            'African Intelligence, Amplified.',                                       'general'],
            ['logo',                    '/assets/images/logo-white.svg',                                          'general'],
            ['favicon',                 '/favicon.ico',                                                           'general'],
            ['contact_phone',           '+234 800 7AI-TECH',                                                      'general'],
            ['contact_email',           'hello@7ai.africa',                                                       'general'],
            ['whatsapp_number',         '+2348007248324',                                                         'general'],
            ['address',                 'Victoria Island, Lagos, Nigeria',                                        'general'],
            ['footer_text',             'African Intelligence, Amplified. Transforming homes and businesses through AI-powered automation built for Africa\'s future.', 'general'],
            ['copyright_text',          '© 2025 7AI Technologies. All rights reserved. Built for Africa.',       'general'],
            // SEO
            ['default_seo_title',       '7AI — African Intelligence, Amplified',                                  'seo'],
            ['default_seo_description', 'Smart home automation and enterprise AI solutions built for Africa.',   'seo'],
            ['default_seo_keywords',    'smart home Africa, AI solutions Africa, home automation Nigeria, AI technology', 'seo'],
            ['og_image',                '/assets/images/og-image.jpg',                                           'seo'],
            // Design
            ['primary_color',           '#0B4F6C',                                                               'design'],
            ['secondary_color',         '#3EE07F',                                                               'design'],
            ['accent_color',            '#0D1B2A',                                                               'design'],
            // Company
            ['company_founded',         '2020',                                                                   'company'],
            ['company_countries',       'Nigeria, Ghana, Kenya, South Africa, Egypt, Tanzania',                  'company'],
            ['company_employees',       '50+',                                                                    'company'],
            ['homes_automated',         '500+',                                                                   'company'],
            ['business_clients',        '120+',                                                                   'company'],
            ['satisfaction_rate',       '98%',                                                                    'company'],
            ['african_countries',       '12+',                                                                    'company'],
            // Contact page
            ['contact_hours',           'Monday – Friday: 8am – 6pm WAT',                                        'contact'],
            ['contact_response_time',   'We respond within 24 hours',                                            'contact'],
            ['contact_whatsapp_label',  'Chat on WhatsApp',                                                      'contact'],
            // Investors
            ['investor_min_investment',  '$10,000',                                                               'investors'],
            ['investor_valuation',       '$5M pre-money valuation',                                              'investors'],
            ['investor_equity',          '15% equity available',                                                  'investors'],
            ['investor_raise',           '$750,000 target raise',                                                 'investors'],
        ];

        foreach ($siteSettings as [$key, $value, $group]) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        }

        // ═══════════════════════════════════════════════════════════════
        //  SOCIAL LINKS
        // ═══════════════════════════════════════════════════════════════
        $socialLinks = [
            ['twitter',   'https://twitter.com/7aitechnologies',         10],
            ['linkedin',  'https://linkedin.com/company/7ai-technologies', 20],
            ['youtube',   'https://youtube.com/@7aitechnologies',         30],
            ['instagram', 'https://instagram.com/7aitechnologies',        40],
            ['facebook',  'https://facebook.com/7aitechnologies',         50],
        ];
        foreach ($socialLinks as [$platform, $url, $sort]) {
            SocialLink::updateOrCreate(['platform' => $platform], ['url' => $url, 'is_active' => true, 'sort_order' => $sort]);
        }

        // ═══════════════════════════════════════════════════════════════
        //  SERVICE CATEGORIES
        // ═══════════════════════════════════════════════════════════════
        $smartHome = ServiceCategory::updateOrCreate(['slug' => 'smart-homes'], [
            'name' => 'Smart Homes', 'description' => 'Complete smart home automation systems designed for African homes and climates.', 'sort_order' => 1, 'is_active' => true,
        ]);
        $aiCat = ServiceCategory::updateOrCreate(['slug' => 'ai-solutions'], [
            'name' => 'AI Solutions', 'description' => 'Enterprise-grade artificial intelligence and machine learning solutions.', 'sort_order' => 2, 'is_active' => true,
        ]);
        $energyCat = ServiceCategory::updateOrCreate(['slug' => 'energy'], [
            'name' => 'Energy & Solar', 'description' => 'Intelligent energy management and solar integration solutions.', 'sort_order' => 3, 'is_active' => true,
        ]);
        $securityCat = ServiceCategory::updateOrCreate(['slug' => 'security'], [
            'name' => 'Security Systems', 'description' => 'AI-powered security, surveillance, and access control solutions.', 'sort_order' => 4, 'is_active' => true,
        ]);

        // ═══════════════════════════════════════════════════════════════
        //  SERVICES
        // ═══════════════════════════════════════════════════════════════
        $services = [
            [$smartHome->id, 'Smart Lighting', 'smart-lighting', 'Adaptive lighting that learns your routines and reduces energy by up to 60%.', '<p>Our Smart Lighting systems use AI to learn your daily routines and automatically adjust lighting to suit your activities, time of day, and mood. The system reduces energy consumption by up to 60% compared to traditional lighting setups.</p><h3>Key Features</h3><ul><li>Automated scheduling based on your routine</li><li>Motion-triggered lighting for security and convenience</li><li>Colour temperature adjustment for health and comfort</li><li>Remote control via mobile app from anywhere</li><li>Integration with voice assistants</li><li>Energy usage reports and analytics</li></ul>', 10],
            [$smartHome->id, 'Smart Security', 'smart-security', 'AI-powered security with facial recognition, motion detection, and real-time alerts 24/7.', '<p>Protect what matters most with our AI-powered security system. Using advanced facial recognition and motion detection, the system identifies threats and sends real-time alerts to your phone, 24 hours a day, 7 days a week.</p><h3>Key Features</h3><ul><li>Facial recognition with allowlist/blocklist</li><li>Motion detection with AI filtering (no false alerts)</li><li>Real-time push notifications</li><li>24/7 cloud recording and storage</li><li>Two-way audio communication</li><li>Integration with alarm systems</li></ul>', 20],
            [$smartHome->id, 'Climate Control', 'climate-control', 'AI-driven climate management optimised for African temperatures and weather patterns.', '<p>Our Climate Control system uses AI to learn your comfort preferences and automatically maintains the ideal temperature and humidity in your home. Designed specifically for African climate conditions.</p><h3>Key Features</h3><ul><li>AI learns your comfort preferences automatically</li><li>Weather-predictive pre-cooling and heating</li><li>Zone-based control for different rooms</li><li>Integration with solar power for energy efficiency</li><li>Air quality monitoring and filtering</li><li>Mobile app control from anywhere</li></ul>', 30],
            [$smartHome->id, 'Smart Access', 'smart-access', 'Biometric locks, smart intercom, and keyless entry — grant or revoke access from anywhere.', '<p>Replace traditional keys with our intelligent access control system. Biometric authentication, smart intercoms, and remote access management give you complete control over who enters your property.</p><h3>Key Features</h3><ul><li>Fingerprint, PIN, and card access options</li><li>Video intercom with two-way communication</li><li>Remote access granting and revoking</li><li>Access history and audit logs</li><li>Temporary guest codes for visitors</li><li>Integration with security cameras</li></ul>', 40],
            [$smartHome->id, 'IoT Integration', 'iot-integration', 'Connect all smart devices through one unified platform — from appliances to infrastructure.', '<p>Bring all your smart devices together under one platform. Our IoT Integration solution connects your lighting, security, climate, appliances, and more into a single, easy-to-manage ecosystem.</p><h3>Key Features</h3><ul><li>Supports 200+ device brands and protocols</li><li>Single app to control everything</li><li>Automated routines and scenes</li><li>Cross-device automation triggers</li><li>API integration for custom devices</li><li>Local and cloud processing</li></ul>', 50],
            [$smartHome->id, 'Voice Automation', 'voice-automation', 'Full voice control supporting English, French, Swahili, and major African languages.', '<p>Control your entire smart home with your voice. Our system supports multiple languages including English, French, Swahili, Hausa, Yoruba, and Zulu — making it truly built for Africa.</p><h3>Key Features</h3><ul><li>Multi-language voice recognition</li><li>Works offline for privacy and reliability</li><li>Custom voice commands creation</li><li>Integration with Alexa, Google Home, and Siri</li><li>Natural language processing</li><li>Voice-activated routines and scenes</li></ul>', 60],
            [$smartHome->id, 'Smart Surveillance', 'smart-surveillance', 'HD cameras with AI analytics, person detection, license plate recognition, and cloud storage.', '<p>Our Smart Surveillance system goes beyond basic recording. AI-powered analytics detect people, vehicles, and unusual activity in real-time, giving you complete situational awareness of your property.</p><h3>Key Features</h3><ul><li>4K HD cameras with night vision</li><li>AI person and vehicle detection</li><li>License plate recognition</li><li>Cloud storage with 30-day retention</li><li>Multi-site management</li><li>Instant alert clips sent to your phone</li></ul>', 70],
            [$smartHome->id, 'Smart Energy', 'smart-energy', 'Solar integration, load management, and predictive energy monitoring to cut your bills.', '<p>Maximise the power of solar energy with intelligent load management. Our system monitors your energy production and consumption in real-time and automatically optimises usage to minimise costs and reliance on the grid.</p><h3>Key Features</h3><ul><li>Solar inverter integration and monitoring</li><li>Battery storage management</li><li>Load shedding prediction and preparation</li><li>Real-time energy dashboard</li><li>Automated appliance scheduling</li><li>ROI tracking and savings reports</li></ul>', 80],
            [$aiCat->id, 'Machine Learning', 'machine-learning', 'Custom ML models trained on local African datasets for accurate, relevant predictions.', '<p>We build machine learning models tailored to African data and contexts. Whether you need fraud detection, demand forecasting, or customer behaviour analysis, our models are trained on local datasets for maximum accuracy.</p><h3>Key Features</h3><ul><li>Custom model development and training</li><li>Local African dataset sourcing</li><li>Continuous model improvement</li><li>Model deployment and API integration</li><li>Performance monitoring and reporting</li><li>Explainable AI outputs</li></ul>', 10],
            [$aiCat->id, 'Predictive Analytics', 'predictive-analytics', 'Turn raw data into forward-looking intelligence — forecast demand and detect anomalies before they occur.', '<p>Stop reacting and start predicting. Our Predictive Analytics solutions use historical data and machine learning to forecast future outcomes, helping you make smarter business decisions.</p><h3>Key Features</h3><ul><li>Demand and inventory forecasting</li><li>Customer churn prediction</li><li>Equipment failure prediction</li><li>Price optimisation models</li><li>Supply chain risk analysis</li><li>Custom dashboards and reports</li></ul>', 20],
            [$aiCat->id, 'AI Agents', 'ai-agents', 'Autonomous AI agents that handle complex workflows and customer interactions around the clock.', '<p>Deploy intelligent AI agents that work autonomously to handle customer service, lead qualification, data processing, and complex multi-step workflows — all without human intervention.</p><h3>Key Features</h3><ul><li>24/7 autonomous operation</li><li>Multi-channel deployment (web, WhatsApp, SMS)</li><li>Human handoff when needed</li><li>Learning from interactions</li><li>CRM and system integration</li><li>Detailed analytics and reporting</li></ul>', 30],
            [$aiCat->id, 'AI Automation', 'ai-automation', 'End-to-end process automation with intelligent decision-making to eliminate repetitive work.', '<p>Automate your most time-consuming business processes with intelligent AI. From document processing to multi-step workflows, our automation solutions free your team to focus on high-value work.</p><h3>Key Features</h3><ul><li>Document and data extraction</li><li>Multi-step workflow automation</li><li>Intelligent decision routing</li><li>Exception handling and escalation</li><li>Integration with existing systems</li><li>Audit trails and compliance reporting</li></ul>', 40],
            [$aiCat->id, 'Business Intelligence', 'business-intelligence', 'Real-time dashboards, automated reports, and actionable insights for faster decisions.', '<p>Transform your data into a competitive advantage. Our Business Intelligence solutions provide real-time visibility into your business performance through beautiful, actionable dashboards and automated reports.</p><h3>Key Features</h3><ul><li>Real-time KPI dashboards</li><li>Automated report generation and distribution</li><li>Multi-source data integration</li><li>Self-service analytics for non-technical users</li><li>Mobile-friendly reporting</li><li>Predictive insights and alerts</li></ul>', 50],
            [$aiCat->id, 'Conversational AI', 'conversational-ai', 'Multilingual chatbots and voice assistants supporting customer service across Africa.', '<p>Deploy intelligent conversational AI across your customer touchpoints. Our chatbots and voice assistants understand natural language in multiple African languages and resolve customer queries instantly.</p><h3>Key Features</h3><ul><li>Multi-language support (10+ African languages)</li><li>WhatsApp, web, and mobile integration</li><li>Intent recognition and entity extraction</li><li>Seamless human agent handoff</li><li>Conversation analytics</li><li>CRM integration</li></ul>', 60],
            [$aiCat->id, 'Computer Vision', 'computer-vision', 'Visual AI for quality control, safety monitoring, agricultural assessment, and retail analytics.', '<p>Give your business the power of sight. Our Computer Vision solutions use AI to analyse images and video in real-time for quality control, safety compliance, agricultural assessment, and customer behaviour analysis.</p><h3>Key Features</h3><ul><li>Real-time video analysis</li><li>Object and defect detection</li><li>Agricultural crop health assessment</li><li>Retail foot traffic and shelf analytics</li><li>Safety and PPE compliance monitoring</li><li>Custom model training</li></ul>', 70],
            [$aiCat->id, 'Custom AI Solutions', 'custom-ai', 'Bespoke AI development for unique business challenges — designed to your exact requirements.', '<p>No two businesses are alike. Our Custom AI Solutions team designs and builds bespoke artificial intelligence systems from the ground up, tailored precisely to your industry, data, and objectives.</p><h3>Key Features</h3><ul><li>Discovery and requirements workshops</li><li>Custom architecture design</li><li>Data engineering and pipeline setup</li><li>Model development and validation</li><li>Production deployment and monitoring</li><li>Ongoing support and improvement</li></ul>', 80],
        ];

        foreach ($services as $i => [$catId, $title, $slug, $short, $full, $sort]) {
            Service::updateOrCreate(['slug' => $slug], [
                'title' => $title, 'category_id' => $catId,
                'short_description' => $short, 'full_description' => $full,
                'cta_text' => 'Get Started', 'cta_link' => '/contact',
                'meta_title' => $title . ' — 7AI Technologies',
                'meta_description' => $short,
                'status' => 'published', 'sort_order' => $sort,
            ]);
        }

        // ═══════════════════════════════════════════════════════════════
        //  CARDS — Smart Home
        // ═══════════════════════════════════════════════════════════════
        $shCards = [
            ['Smart Lighting',     'Adaptive lighting that reduces energy by 60% and sets the perfect ambiance automatically.',                                            '<path d="M12 2L2 7v10a2 2 0 002 2h16a2 2 0 002-2V7L12 2z"/><path d="M9 22V12h6v10"/>'],
            ['Smart Security',     'AI-powered security with facial recognition, motion detection, and 24/7 real-time alerts.',                                            '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>'],
            ['Smart Energy',       'Solar integration and load management — cut bills and maximise renewable energy intelligently.',                                        '<path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>'],
            ['Climate Control',    'AI-driven climate management adapted to African weather patterns, occupancy, and your preferences.',                                    '<path d="M14 14.76V3.5a2.5 2.5 0 00-5 0v11.26A4.5 4.5 0 1014 14.76z"/>'],
            ['Smart Access',       'Biometric locks and keyless entry — grant or revoke access instantly from anywhere in the world.',                                     '<rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"/>'],
            ['IoT Integration',    'Connect all your smart devices through one unified platform — from appliances to full infrastructure.',                                 '<circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/><path d="M2 12h20"/>'],
            ['Voice Automation',   'Seamless voice control supporting English, French, Swahili, and major African languages.',                                             '<path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/>'],
            ['AI Assistants',      'Personalised AI assistants that learn your household patterns, anticipate needs, and make intelligent recommendations daily.',         '<path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>'],
            ['Smart Surveillance', 'HD cameras with AI analytics, person detection, license plate recognition, and cloud storage — full awareness.',                      '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>'],
        ];
        foreach ($shCards as $i => [$title, $desc, $svg]) {
            Card::updateOrCreate(['title' => $title, 'group' => 'smart-home'], [
                'description' => $desc,
                'icon' => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">' . $svg . '</svg>',
                'link' => '/smart-homes', 'button_text' => 'Learn More',
                'group' => 'smart-home', 'sort_order' => ($i + 1) * 10, 'is_active' => true,
            ]);
        }

        // ═══════════════════════════════════════════════════════════════
        //  CARDS — AI Solutions
        // ═══════════════════════════════════════════════════════════════
        $aiCards = [
            ['Machine Learning',       'Custom ML models trained on local datasets — delivering accurate predictions for agriculture, finance, healthcare, and logistics.', '<path d="M2 20h20M4 20V10l8-8 8 8v10"/><path d="M10 20v-5h4v5"/>'],
            ['Predictive Analytics',   'Turn raw data into forward-looking intelligence. Forecast demand, detect anomalies, and make decisions before problems arise.',      '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>'],
            ['AI Agents',              'Autonomous AI agents that handle complex workflows, customer interactions, and business processes around the clock.',                '<circle cx="12" cy="12" r="3"/><path d="M12 2v4m0 12v4M4.22 4.22l2.83 2.83m9.9 9.9l2.83 2.83M2 12h4m12 0h4"/>'],
            ['AI Automation',          'End-to-end process automation with intelligent decision-making — eliminating repetitive work and accelerating operations.',          '<rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/>'],
            ['Business Intelligence',  'Real-time dashboards, automated reports, and actionable insights — giving executives the data they need, instantly.',               '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>'],
            ['Computer Vision',        'Visual AI for quality control, safety monitoring, agricultural assessment, and retail analytics — seeing what humans miss.',        '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'],
            ['Conversational AI',      'Multilingual chatbots and voice assistants supporting customer service, sales, and operations across your organisation.',           '<path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>'],
            ['Data Analytics',         'Comprehensive data engineering, lake architecture, and analytics pipelines — turning data into Africa\'s most powerful asset.',    '<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>'],
            ['Custom AI Solutions',    'Bespoke AI development for unique business challenges — we design, build, and deploy AI that fits your exact requirements.',        '<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>'],
        ];
        foreach ($aiCards as $i => [$title, $desc, $svg]) {
            Card::updateOrCreate(['title' => $title, 'group' => 'ai-solutions'], [
                'description' => $desc,
                'icon' => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">' . $svg . '</svg>',
                'link' => '/ai-solutions', 'button_text' => 'Learn More',
                'group' => 'ai-solutions', 'sort_order' => ($i + 1) * 10, 'is_active' => true,
            ]);
        }

        // ═══════════════════════════════════════════════════════════════
        //  CARDS — Industries
        // ═══════════════════════════════════════════════════════════════
        $industries = [
            ['Residential',   'Smart home automation for villas, apartments, and estates across Africa.',              'M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z'],
            ['Commercial',    'Intelligent building management for offices, retail spaces, and commercial properties.', 'M2 3h20v14H2zM8 21h8M12 17v4'],
            ['Manufacturing', 'AI-driven production optimisation, quality control, and predictive maintenance.',       'M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z'],
            ['Healthcare',    'Smart hospital management, patient monitoring, and medical data analytics.',             'M22 12h-4l-3 9L9 3l-3 9H2'],
            ['Hospitality',   'Guest experience automation, energy management, and smart room systems for hotels.',    'M2 7h20v14H2zM16 3H8a2 2 0 00-2 2v2h12V5a2 2 0 00-2-2z'],
            ['Education',     'Smart classrooms, campus security, and AI-powered learning management systems.',        'M3 3h18v18H3zM3 9h18M9 21V9'],
            ['Agriculture',   'Precision farming, crop monitoring, irrigation automation, and yield prediction.',      'M12 2a10 10 0 100 20A10 10 0 0012 2zm0 0v20M2 12h20'],
            ['Finance',       'Fraud detection, credit scoring, customer analytics, and compliance automation.',       'M2 2h20v20H2zM16 8h-6a2 2 0 00-2 2v5a2 2 0 002 2h6M14 15l3-3-3-3'],
            ['Logistics',     'Fleet tracking, route optimisation, warehouse automation, and demand forecasting.',     'M1 3h15v13H1zM16 8h4l3 5v4h-7V8z'],
            ['Real Estate',   'Smart property management, tenant experience, and building performance analytics.',     'M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2zM9 22V12h6v10'],
            ['Energy',        'Grid optimisation, renewable energy management, and consumption analytics.',            'M13 2L3 14h9l-1 8 10-12h-9l1-8z'],
            ['Government',    'Smart city infrastructure, public safety monitoring, and citizen services automation.', 'M3 3h18v4H3zM3 9h18v4H3zM3 15h18v4H3z'],
        ];
        foreach ($industries as $i => [$name, $desc, $svg]) {
            Card::updateOrCreate(['title' => $name, 'group' => 'industries'], [
                'description' => $desc,
                'icon' => '<svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="' . $svg . '"/></svg>',
                'link' => '/industries',
                'group' => 'industries', 'sort_order' => ($i + 1) * 10, 'is_active' => true,
            ]);
        }

        // ═══════════════════════════════════════════════════════════════
        //  CARDS — Why Choose Us / Features
        // ═══════════════════════════════════════════════════════════════
        $features = [
            ['Built for Africa',       'Every solution we build is designed with African infrastructure, power conditions, connectivity, and local context in mind.',         'M12 2a10 10 0 100 20A10 10 0 0012 2zm0 0v20M2 12h20'],
            ['Proven Results',         'Our clients see real, measurable results — from 60% energy savings to 70% reduction in stockouts.',                                  'M22 11.08V12a10 10 0 11-5.93-9.14M22 4L12 14.01l-3-3'],
            ['24/7 Support',           'Round-the-clock technical support from our expert team. We monitor your systems and resolve issues before you notice them.',          'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z'],
            ['Rapid Deployment',       'From consultation to fully operational system in days, not months. We move fast without compromising on quality.',                    'M13 10V3L4 14h7v7l9-11h-7z'],
            ['Scalable Solutions',     'Start with one room or one department and scale to your entire home, campus, or enterprise as needed.',                               'M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z'],
            ['Data Privacy',           'Your data stays yours. We use enterprise-grade encryption and comply with data protection regulations across Africa.',                '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>'],
            ['Local Expertise',        'Our team combines deep local knowledge with world-class technical expertise — we understand African business and home environments.', '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>'],
            ['Ongoing Innovation',     'We continuously update and improve your systems with new AI capabilities and features as they become available.',                     '<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>'],
        ];
        foreach ($features as $i => [$title, $desc, $svg]) {
            Card::updateOrCreate(['title' => $title, 'group' => 'features'], [
                'description' => $desc,
                'icon' => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="' . $svg . '"/></svg>',
                'group' => 'features', 'sort_order' => ($i + 1) * 10, 'is_active' => true,
            ]);
        }

        // ═══════════════════════════════════════════════════════════════
        //  CARDS — Pricing Plans
        // ═══════════════════════════════════════════════════════════════
        $pricingCards = [
            ['Starter',     'Perfect for single-room or basic home automation.',             'From $999', 'Get Started', '/contact', 'pricing', 10],
            ['Smart Home',  'Complete whole-home automation with all essential features.',   'From $3,499', 'Get Quote', '/contact', 'pricing', 20],
            ['Enterprise',  'Full AI + smart building deployment for businesses.',           'Custom Pricing', 'Contact Us', '/contact', 'pricing', 30],
        ];
        foreach ($pricingCards as [$title, $desc, $price, $btn, $link, $group, $sort]) {
            Card::updateOrCreate(['title' => $title, 'group' => $group], [
                'subtitle' => $price, 'description' => $desc,
                'button_text' => $btn, 'link' => $link,
                'group' => $group, 'sort_order' => $sort, 'is_active' => true,
            ]);
        }

        // ═══════════════════════════════════════════════════════════════
        //  CARDS — Process Steps
        // ═══════════════════════════════════════════════════════════════
        $processSteps = [
            ['1. Discovery Call',    'We understand your goals, environment, infrastructure, and requirements in depth.',                                     'process', 10],
            ['2. Custom Design',     'Our engineers design a tailored solution architecture specifically for your home or business.',                          'process', 20],
            ['3. Installation',      'Certified technicians deploy and configure all hardware, software, and network infrastructure.',                        'process', 30],
            ['4. Training',          'Full onboarding and training for you, your family, or your team — ensuring everyone gets the most from the system.',   'process', 40],
            ['5. 24/7 Support',      'Ongoing remote monitoring, software updates, and technical support to keep everything running at peak performance.',    'process', 50],
        ];
        foreach ($processSteps as [$title, $desc, $group, $sort]) {
            Card::updateOrCreate(['title' => $title, 'group' => $group], [
                'description' => $desc, 'group' => $group, 'sort_order' => $sort, 'is_active' => true,
            ]);
        }

        // ═══════════════════════════════════════════════════════════════
        //  TESTIMONIALS
        // ═══════════════════════════════════════════════════════════════
        $testimonials = [
            ['Adewale Okonkwo',  'CEO',               'Meridian Group, Lagos',        '"7AI transformed our office building into a fully intelligent workspace. Energy costs dropped 45% in the first month. The AI is genuinely impressive and their team is excellent."', 5, true,  10],
            ['Fatima Mensah',    'Director',          'Solaris Estates, Accra',        '"The smart security system and AI surveillance gave us total peace of mind. Setup was seamless, the technology works flawlessly, and their support team is exceptional."',         5, true,  20],
            ['Kwame Nkosi',      'Operations Head',   'PanAfrica Hub, Nairobi',        '"We integrated 7AI\'s predictive analytics into our supply chain. Stockouts reduced by 70% and our planning is now fully data-driven. Outstanding and measurable results."',       5, true,  30],
            ['Amara Diallo',     'Founder & CEO',     'TechCorp Africa, Dakar',        '"The IoT integration platform connected all our devices seamlessly. Our team productivity has gone up and our customers are delighted with the intelligent experiences."',           5, false, 40],
            ['Grace Kimani',     'CTO',               'NovaBuild, Nairobi',            '"The custom AI solution 7AI built for our manufacturing line reduced waste by 35%. ROI was achieved in under 3 months. I recommend them to every business leader in Africa."',     5, false, 50],
            ['Chukwudi Obi',     'Managing Director', 'Greenfield Co., Abuja',         '"Our smart home system from 7AI is incredible. Voice control in Yoruba, automated lights, and solar management — all through one app. This is the future of living in Africa."',  5, false, 60],
            ['Amina Hassan',     'Property Manager',  'Azizi Developments, Cairo',     '"7AI deployed smart systems across 200 units in our complex. Energy bills dropped dramatically and tenants love the app. Professional, reliable, and truly cutting-edge."',        5, false, 70],
            ['Sipho Dlamini',    'Head of IT',        'Standard Bank Group, Joburg',   '"Their AI fraud detection model cut our false positives by 60% while catching 40% more actual fraud. The ROI was evident within the first quarter of deployment."',               5, false, 80],
        ];
        foreach ($testimonials as [$name, $role, $company, $content, $rating, $featured, $sort]) {
            Testimonial::updateOrCreate(['author_name' => $name, 'author_company' => $company], [
                'author_role' => $role, 'content' => $content, 'rating' => $rating,
                'is_featured' => $featured, 'is_active' => true, 'sort_order' => $sort,
            ]);
        }

        // ═══════════════════════════════════════════════════════════════
        //  FAQs
        // ═══════════════════════════════════════════════════════════════
        $faqs = [
            // General
            ['What countries do you operate in?',          'We currently operate across Nigeria, Ghana, Kenya, South Africa, Egypt, Tanzania, Uganda, Senegal, and Ivory Coast. We are expanding continuously — contact us to check availability in your specific location.',                                                                            'General',      10],
            ['How do I get started with 7AI?',             'Getting started is simple. Book a free 30-minute consultation through our Contact page or call us directly. Our team will assess your needs and design a custom solution proposal within 48 hours.',                                                                                          'General',      20],
            ['Do you offer free consultations?',           'Yes! We offer a completely free 30-minute consultation for all prospective clients. During this call, our experts will understand your requirements and provide initial recommendations with no obligation.',                                                                                   'General',      30],
            ['What payment methods do you accept?',        'We accept bank transfers, mobile money (M-Pesa, MTN MoMo, Opay), credit/debit cards, and offer flexible payment plans. Contact us to discuss payment options for your specific project.',                                                                                                  'General',      40],
            // Smart Home
            ['How long does installation take?',           'A standard smart home installation typically takes 2–5 days depending on the size and complexity of your home. We provide a detailed timeline during your initial consultation.',                                                                                                            'Smart Home',   50],
            ['Do your systems work during power outages?', 'Yes! Our systems include battery backup and UPS solutions to ensure continuous operation during power cuts. We also fully integrate with solar power systems for complete energy independence.',                                                                                               'Smart Home',   60],
            ['Can I control my home remotely?',            'Absolutely. All our smart home systems come with a mobile app that lets you control every device, monitor energy usage, receive alerts, and manage access from anywhere in the world — as long as you have internet access.',                                                                 'Smart Home',   70],
            ['What smart devices do you support?',         'We support over 200 device brands and protocols including Zigbee, Z-Wave, Matter, Wi-Fi, and Bluetooth. During the consultation, our team will assess compatibility with any devices you already own.',                                                                                       'Smart Home',   80],
            ['Is my data secure?',                         'Absolutely. We use enterprise-grade end-to-end encryption for all data transmission and storage. Your data is never sold or shared with third parties. We comply with NDPR (Nigeria), POPIA (South Africa), and other applicable data protection regulations.',                              'Smart Home',   90],
            // AI Solutions
            ['What AI platforms do you integrate with?',   'We integrate with leading AI platforms including Google Cloud AI, AWS AI Services, Microsoft Azure AI, and also build completely custom AI solutions from scratch using our own infrastructure.',                                                                                            'AI Solutions', 100],
            ['How long does an AI project take?',          'Timelines vary by complexity. A basic AI deployment can be completed in 2–4 weeks. Custom model development and enterprise rollouts typically take 6–12 weeks. We provide detailed project timelines during the proposal phase.',                                                             'AI Solutions', 110],
            ['Do you train AI on our own data?',           'Yes. For maximum accuracy and relevance, we train custom AI models on your organisation\'s data. We can also source and curate local African datasets appropriate to your use case.',                                                                                                        'AI Solutions', 120],
            ['What happens after deployment?',             'We provide comprehensive post-deployment support including system monitoring, model performance tracking, regular updates, and ongoing improvements. We offer support packages ranging from basic technical support to fully managed AI operations.',                                            'AI Solutions', 130],
            // Pricing
            ['Do you offer financing options?',            'Yes, we offer flexible payment plans for residential and commercial projects. Enterprise clients can also access phased deployment options to spread costs over time. Contact us to discuss what works for your budget.',                                                                       'Pricing',      140],
            ['Is there a minimum project size?',           'We work with both small residential projects starting from a single room, and large enterprise deployments across multiple sites. Our smallest packages start from $999 for basic room automation.',                                                                                           'Pricing',      150],
            // Support
            ['Do you offer ongoing support?',              'Yes, we offer 24/7 technical support via phone, WhatsApp, and email. All installations include a 12-month warranty and access to our support portal. Extended support and maintenance contracts are available.',                                                                             'Support',      160],
            ['Do you have local technicians?',             'Yes! We have certified technicians in Lagos, Abuja, Accra, Nairobi, Cape Town, Johannesburg, and Cairo. Remote support is available across all other regions.',                                                                                                                              'Support',      170],
            // Contact
            ['How quickly do you respond to enquiries?',   'We respond to all enquiries within 24 hours on business days. For urgent matters, you can reach us via WhatsApp for a faster response. Our office hours are Monday–Friday, 8am–6pm WAT.',                                                                                                   'Contact',      180],
        ];
        foreach ($faqs as [$q, $a, $cat, $sort]) {
            Faq::updateOrCreate(['question' => $q], ['answer' => $a, 'category' => $cat, 'sort_order' => $sort, 'is_active' => true]);
        }

        // ═══════════════════════════════════════════════════════════════
        //  CTAs
        // ═══════════════════════════════════════════════════════════════
        $ctas = [
            ['home_hero',           'African Intelligence, Amplified.',                        'Transforming homes, businesses, and communities through AI-powered automation and intelligent technology solutions built for Africa\'s future.',      'Book Consultation',      '/contact',  'Register as Investor', '/investors', true],
            ['home_cta',            'Ready to Transform Your Home or Business?',               'Book a free 30-minute consultation with our experts and discover what AI automation can do for you. No obligation, no pressure.',                     'Book Free Consultation', '/contact',  'View Pricing',         '/pricing',  true],
            ['solutions_hero',      'Intelligent Solutions Built for Africa',                  'From smart homes to enterprise AI — every solution we build is designed with African infrastructure, connectivity, and culture in mind.',              'Explore Solutions',      '/solutions','Book Consultation',     '/contact',  true],
            ['smart_homes_hero',    'Smart Home Automation for African Living',                'Complete home intelligence systems designed for African homes, climates, and lifestyles. Reliable, beautiful, and built to last.',                    'Book Site Visit',        '/contact',  'View Packages',        '/pricing',  true],
            ['smart_homes_cta',     'Ready to Make Your Home Intelligent?',                   'Our certified smart home consultants will design the perfect automation system for your home. Free 30-minute consultation, no obligation.',           'Book Free Consultation', '/contact',  'View Pricing',         '/pricing',  true],
            ['ai_solutions_hero',   'Enterprise AI Solutions for African Business',            'Machine learning, predictive analytics, AI automation, and custom AI — all engineered for Africa\'s data, languages, and business environment.',      'Start Your AI Journey',  '/contact',  'View Case Studies',    '/case-studies', true],
            ['ai_solutions_cta',    'Let\'s Build Your AI Solution',                           'Tell us your business challenge and we\'ll design an AI solution that solves it. Free consultation, detailed proposal, measurable results.',         'Book AI Consultation',   '/contact',  'View Case Studies',    '/case-studies', true],
            ['about_cta',           'Join Africa\'s AI Revolution',                            'Whether you\'re a homeowner, business leader, or investor, there\'s a place for you in the 7AI ecosystem. Get in touch today.',                     'Get in Touch',           '/contact',  'Register as Investor', '/investors', true],
            ['contact_hero',        'Let\'s Talk',                                             'Our team of experts is ready to help you transform your home or business. Book a free consultation or send us a message.',                          'Book Free Consultation', '/contact',  null,                    null,        true],
            ['investors_hero',      'Invest in Africa\'s AI Future',                           'Join our growing network of investors backing Africa\'s leading AI and smart technology company. Limited equity available.',                        'Register Interest',      '/investors','Download Deck',         '/contact',  true],
            ['pricing_cta',         'Not Sure Which Plan Is Right for You?',                  'Our consultants will help you choose the right solution for your needs and budget. Free consultation, no obligation.',                               'Book Free Consultation', '/contact',  'Contact Us',            '/contact',  true],
            ['support_hero',        'We\'re Here to Help',                                    'Our expert support team is available 24/7 to assist you. Browse our FAQs, open a ticket, or chat with us directly.',                                'Open Support Ticket',    '/login',    'Chat on WhatsApp',      '#',         true],
            ['careers_hero',        'Build Africa\'s AI Future With Us',                       'We\'re looking for passionate engineers, designers, sales professionals, and operators who want to make a difference across the continent.',         'View Open Roles',        '/careers',  null,                    null,        true],
            ['blog_cta',            'Stay Ahead of the Curve',                                'Subscribe to our newsletter for the latest insights on AI, smart home technology, and innovation from across Africa.',                               'Subscribe Now',          '/contact',  null,                    null,        true],
        ];
        foreach ($ctas as [$name, $title, $text, $btn1, $url1, $btn2, $url2, $active]) {
            Cta::updateOrCreate(['name' => $name], [
                'title' => $title, 'text' => $text,
                'button_label' => $btn1, 'button_url' => $url1,
                'button2_label' => $btn2, 'button2_url' => $url2,
                'is_active' => $active,
            ]);
        }

        // ═══════════════════════════════════════════════════════════════
        //  BANNERS
        // ═══════════════════════════════════════════════════════════════
        Banner::updateOrCreate(['name' => 'Free Consultation Offer'], [
            'title' => 'Free 30-Minute Consultation — Limited Slots Available',
            'description' => 'Book your free smart home or AI consultation today. Our experts will design a custom solution for your needs.',
            'link' => '/contact', 'button_text' => 'Book Now',
            'position' => 'top_bar', 'is_active' => true, 'sort_order' => 10,
        ]);
        Banner::updateOrCreate(['name' => 'Investor Open Round'], [
            'title' => 'Investor Round Open — $750K Target Raise',
            'description' => 'Join Africa\'s leading AI and smart technology company. Equity available from $10K.',
            'link' => '/investors', 'button_text' => 'Register Interest',
            'position' => 'home_hero', 'is_active' => false, 'sort_order' => 20,
        ]);

        // ═══════════════════════════════════════════════════════════════
        //  FORMS
        // ═══════════════════════════════════════════════════════════════
        // Contact Form
        $contactForm = Form::updateOrCreate(['slug' => 'contact'], [
            'name' => 'Contact Form',
            'description' => 'Main contact and lead capture form',
            'success_message' => 'Thank you for reaching out! Our team will contact you within 24 hours.',
            'notification_email' => 'hello@7ai.africa',
            'store_submissions' => true, 'is_active' => true,
        ]);
        $this->seedFormFields($contactForm->id, [
            ['First Name',              'first_name',       'text',     'John',                    true,  10],
            ['Last Name',               'last_name',        'text',     'Doe',                     true,  20],
            ['Email Address',           'email',            'email',    'john@example.com',        true,  30],
            ['Phone Number',            'phone',            'phone',    '+234 800 000 0000',       false, 40],
            ['Company / Organisation',  'company',          'text',     'Your company',            false, 50],
            ['Country',                 'country',          'select',   '',                        false, 60, "Nigeria\nGhana\nKenya\nSouth Africa\nEgypt\nTanzania\nUganda\nSenegal\nCameroon\nEthiopia\nIvory Coast\nOther"],
            ['Service Interest',        'service_interest', 'select',   '',                        true,  70, "Smart Home Automation\nAI Solutions\nEnergy Management\nSecurity Systems\nIoT Integration\nPredictive Analytics\nCustom AI Development\nGeneral Enquiry"],
            ['Budget Range',            'budget',           'select',   '',                        false, 80, "Under \$5,000\n\$5,000 – \$20,000\n\$20,000 – \$100,000\n\$100,000+\nNot sure"],
            ['How did you hear about us?','source',         'select',   '',                        false, 90, "Google\nSocial Media\nReferral\nEvent / Conference\nNews Article\nOther"],
            ['Message',                 'message',          'textarea', 'Tell us about your project or requirements...', true, 100],
        ]);

        // Investor Registration Form
        $investorForm = Form::updateOrCreate(['slug' => 'investor-registration'], [
            'name' => 'Investor Registration',
            'description' => 'Investor interest registration form',
            'success_message' => 'Thank you for your interest! Our investor relations team will contact you within 48 hours.',
            'notification_email' => 'investors@7ai.africa',
            'store_submissions' => true, 'is_active' => true,
        ]);
        $this->seedFormFields($investorForm->id, [
            ['Full Name',           'full_name',        'text',     'Your full name',          true,  10],
            ['Email Address',       'email',            'email',    'your@email.com',          true,  20],
            ['Phone Number',        'phone',            'phone',    '+1 234 567 8900',         true,  30],
            ['Country of Residence','country',          'select',   '',                        true,  40, "Nigeria\nGhana\nKenya\nSouth Africa\nUnited Kingdom\nUSA\nUAE\nSingapore\nFrance\nGermany\nOther"],
            ['Investment Range',    'investment_range', 'select',   '',                        true,  50, "\$10,000 – \$50,000\n\$50,000 – \$250,000\n\$250,000 – \$1,000,000\n\$1,000,000+"],
            ['Investor Type',       'investor_type',    'select',   '',                        true,  60, "Individual Angel\nFamily Office\nVC Fund\nCorporate / Strategic\nPrivate Equity\nOther"],
            ['LinkedIn Profile',    'linkedin',         'text',     'https://linkedin.com/in/','false', 70],
            ['Additional Notes',    'notes',            'textarea', 'Tell us about your investment background and interests...', false, 80],
        ]);

        // Newsletter Subscribe Form
        $newsletterForm = Form::updateOrCreate(['slug' => 'newsletter'], [
            'name' => 'Newsletter Subscription',
            'description' => 'Email newsletter signup form',
            'success_message' => 'Thank you for subscribing! Check your inbox for a confirmation email.',
            'store_submissions' => true, 'is_active' => true,
        ]);
        $this->seedFormFields($newsletterForm->id, [
            ['First Name',    'first_name', 'text',  'Your name',        false, 10],
            ['Email Address', 'email',      'email', 'your@email.com',   true,  20],
        ]);

        // Support Request Form
        $supportForm = Form::updateOrCreate(['slug' => 'support-request'], [
            'name' => 'Support Request',
            'description' => 'Customer support request form',
            'success_message' => 'Your support request has been received. Our team will respond within 4 hours.',
            'notification_email' => 'support@7ai.africa',
            'store_submissions' => true, 'is_active' => true,
        ]);
        $this->seedFormFields($supportForm->id, [
            ['Full Name',       'full_name',    'text',     'Your name',                true,  10],
            ['Email',           'email',        'email',    'your@email.com',           true,  20],
            ['Phone',           'phone',        'phone',    '+234...',                  false, 30],
            ['Issue Type',      'issue_type',   'select',   '',                         true,  40, "Device Not Working\nApp / Software Issue\nInstallation Help\nBilling Question\nUpgrade / Change Request\nOther"],
            ['Priority',        'priority',     'select',   '',                         true,  50, "Low\nMedium\nHigh\nUrgent"],
            ['Description',     'description',  'textarea', 'Describe your issue in detail...', true, 60],
        ]);

        // Abuja registration form
        $abujaForm = Form::updateOrCreate(['slug' => 'abuja'], [
            'name'              => 'Abuja Registration',
            'public_path'       => '/abuja',
            'title'             => 'Register for 7AI — Abuja',
            'subtitle'          => 'Join the 7AI community in Abuja. Fill in your details below and we\'ll be in touch.',
            'description'       => 'Abuja community registration form',
            'success_message'   => 'Thank you for registering! We\'ll reach out to you shortly.',
            'notification_email'=> 'hello@7ai.africa',
            'store_submissions' => true,
            'is_active'         => true,
        ]);
        $this->seedFormFields($abujaForm->id, [
            ['Full Name',          'full_name',    'text',     'Enter your full name',            true,  10],
            ['What Do You Do?',    'occupation',   'text',     'e.g. Engineer, Business Owner…',  true,  20],
            ['Attendance Type',    'attendance',   'select',   '',                                true,  30, "Online\nPhysical"],
            ['Phone Number',       'phone',        'phone',    '+234…',                           true,  40],
            ['Email Address',      'email',        'email',    'you@example.com',                 true,  50],
        ]);

        // ═══════════════════════════════════════════════════════════════
        //  MENUS
        // ═══════════════════════════════════════════════════════════════
        $headerMenu = Menu::updateOrCreate(['location' => 'header'], ['name' => 'Main Navigation']);
        // Rebuild items only if empty
        if ($headerMenu->allItems()->count() === 0) {
            $sol = MenuItem::create(['menu_id' => $headerMenu->id, 'label' => 'Solutions', 'type' => 'custom', 'url' => '/solutions', 'target' => '_self', 'order' => 10, 'is_active' => true]);
            MenuItem::create(['menu_id' => $headerMenu->id, 'parent_id' => $sol->id, 'label' => 'Smart Homes',  'type' => 'custom', 'url' => '/smart-homes',  'order' => 10, 'is_active' => true, 'target' => '_self']);
            MenuItem::create(['menu_id' => $headerMenu->id, 'parent_id' => $sol->id, 'label' => 'AI Solutions', 'type' => 'custom', 'url' => '/ai-solutions',  'order' => 20, 'is_active' => true, 'target' => '_self']);
            MenuItem::create(['menu_id' => $headerMenu->id, 'parent_id' => $sol->id, 'label' => 'Industries',   'type' => 'custom', 'url' => '/industries',    'order' => 30, 'is_active' => true, 'target' => '_self']);
            MenuItem::create(['menu_id' => $headerMenu->id, 'parent_id' => $sol->id, 'label' => 'All Solutions','type' => 'custom', 'url' => '/solutions',     'order' => 40, 'is_active' => true, 'target' => '_self']);
            foreach ([['Pricing','/pricing',20],['Case Studies','/case-studies',30],['Blog','/blog',40],['About','/about',50],['Contact','/contact',60],['Investors','/investors',70]] as [$lbl,$url,$ord]) {
                MenuItem::create(['menu_id' => $headerMenu->id, 'label' => $lbl, 'type' => 'custom', 'url' => $url, 'target' => '_self', 'order' => $ord, 'is_active' => true]);
            }
        }

        $footerMenu = Menu::updateOrCreate(['location' => 'footer'], ['name' => 'Footer Navigation']);
        if ($footerMenu->allItems()->count() === 0) {
            foreach ([['Smart Homes','/smart-homes',10],['AI Solutions','/ai-solutions',20],['Industries','/industries',30],['Pricing','/pricing',40],['About Us','/about',50],['Case Studies','/case-studies',60],['Blog','/blog',70],['Careers','/careers',80],['Support','/support',90],['Documentation','/docs',100],['Contact','/contact',110],['Privacy Policy','/privacy',120],['Terms of Service','/terms',130]] as [$lbl,$url,$ord]) {
                MenuItem::create(['menu_id' => $footerMenu->id, 'label' => $lbl, 'type' => 'custom', 'url' => $url, 'target' => '_self', 'order' => $ord, 'is_active' => true]);
            }
        }

        Menu::updateOrCreate(['location' => 'mobile'], ['name' => 'Mobile Navigation']);

        // ═══════════════════════════════════════════════════════════════
        //  PAGES — All public pages with full content
        // ═══════════════════════════════════════════════════════════════
        if (!$admin) {
            $this->command->warn('Admin user not found — skipping page seeding.');
            return;
        }

        $pages = [
            [
                'title' => 'Home',
                'slug'  => 'home',
                'template' => 'home',
                'hero_title'       => 'African Intelligence, Amplified.',
                'hero_subtitle'    => 'Now Available Across Africa',
                'hero_description' => 'Transforming homes, businesses, and communities through AI-powered automation and intelligent technology solutions built for Africa\'s future.',
                'cta_text' => 'Book Consultation', 'cta_link' => '/contact',
                'meta_title' => '7AI — African Intelligence, Amplified',
                'meta_description' => 'Smart home automation and enterprise AI solutions built for Africa. 500+ homes automated, 120+ business clients, 98% satisfaction.',
                'seo_keywords' => 'smart home Africa, AI solutions Africa, home automation Nigeria, AI technology Africa',
                'content' => "Trusted by leading organizations across Africa including TechCorp Africa, NovaBuild, Solaris Estates, PanAfrica Hub, Greenfield Co., and Meridian Group.\n\n## Smart Home Solutions\nComplete smart home automation systems tailored for African homes and climates — reliable, efficient, and beautifully designed.\n\n## AI Services\nEnterprise-grade AI solutions designed for African businesses — from predictive analytics to autonomous agents.\n\n## Our Process\n1. Discovery Call — We understand your goals in depth\n2. Custom Design — Architecture tailored to your needs\n3. Installation — Certified technicians deploy everything\n4. Training — Full onboarding for you and your team\n5. 24/7 Support — Ongoing monitoring and updates",
            ],
            [
                'title' => 'Solutions',
                'slug'  => 'solutions',
                'template' => 'default',
                'hero_title'       => 'Intelligent Solutions Built for Africa',
                'hero_subtitle'    => 'Our Solutions',
                'hero_description' => 'From smart homes to enterprise AI, every solution we build is designed with African infrastructure, connectivity, climate, and culture in mind.',
                'cta_text' => 'Book Consultation', 'cta_link' => '/contact',
                'meta_title' => 'Smart Home & AI Solutions — 7AI Technologies',
                'meta_description' => 'Explore 7AI\'s complete range of smart home automation, AI solutions, and intelligent technology for homes and businesses across Africa.',
                'seo_keywords' => 'smart home solutions Africa, AI solutions Africa, IoT Africa, automation Africa',
                'content' => "## All Solutions\n7AI offers a comprehensive range of intelligent technology solutions for residential and commercial clients across Africa.\n\n### Smart Home Automation\nComplete home intelligence systems including lighting, security, climate control, access management, and IoT integration.\n\n### AI Solutions\nMachine learning, predictive analytics, AI agents, business intelligence, conversational AI, and custom AI development.\n\n### Energy & Solar\nSmart energy management, solar integration, load management, and energy monitoring.\n\n### Security Systems\nAI-powered surveillance, facial recognition, access control, and monitoring.",
            ],
            [
                'title' => 'Smart Homes',
                'slug'  => 'smart-homes',
                'template' => 'default',
                'hero_title'       => 'Smart Home Automation for African Living',
                'hero_subtitle'    => 'Smart Home Solutions',
                'hero_description' => 'Complete home intelligence systems designed for African homes, climates, and lifestyles. Reliable, beautiful, and built to last.',
                'cta_text' => 'Book Site Visit', 'cta_link' => '/contact',
                'meta_title' => 'Smart Home Automation Africa — 7AI Technologies',
                'meta_description' => 'Complete smart home automation for African homes. Smart lighting, security, climate control, access, IoT integration, and more.',
                'seo_keywords' => 'smart home Nigeria, smart home Ghana, home automation Africa, smart lighting Africa, smart security Africa',
                'content' => "## Transform Your Home\n7AI smart home systems bring together lighting, security, climate, energy, access, and entertainment into one intelligent ecosystem controlled from your phone or by voice.\n\n### Why 7AI Smart Homes?\n- Designed for African power conditions including load shedding\n- Works with solar and battery backup systems\n- Supports local languages including Yoruba, Hausa, Swahili, and Zulu\n- Remote monitoring and control from anywhere in the world\n- Energy savings of up to 60%\n- 12-month installation warranty\n- 24/7 technical support\n\n## Our Smart Home Services",
            ],
            [
                'title' => 'AI Solutions',
                'slug'  => 'ai-solutions',
                'template' => 'default',
                'hero_title'       => 'Enterprise AI Solutions for African Business',
                'hero_subtitle'    => 'AI & Machine Learning',
                'hero_description' => 'Machine learning, predictive analytics, AI automation, and custom AI — all engineered for Africa\'s data, languages, and business environment.',
                'cta_text' => 'Start Your AI Journey', 'cta_link' => '/contact',
                'meta_title' => 'Enterprise AI Solutions Africa — 7AI Technologies',
                'meta_description' => 'Machine learning, predictive analytics, AI agents, business intelligence, and custom AI development for African businesses.',
                'seo_keywords' => 'AI solutions Africa, machine learning Africa, predictive analytics Africa, AI development Nigeria',
                'content' => "## AI Built for Africa\nOur AI solutions are trained on African data, tuned for African contexts, and deployed with African infrastructure in mind.\n\n### What Makes Our AI Different?\n- Models trained on local African datasets for relevance and accuracy\n- Supports 10+ African languages including Swahili, Hausa, Yoruba, Zulu\n- Designed for intermittent connectivity environments\n- Compliant with NDPR, POPIA, and other African data regulations\n- Experienced team with deep understanding of African markets\n\n## Our AI Services",
            ],
            [
                'title' => 'Pricing',
                'slug'  => 'pricing',
                'template' => 'default',
                'hero_title'       => 'Simple, Transparent Pricing',
                'hero_subtitle'    => 'Pricing',
                'hero_description' => 'Choose the right plan for your home or business. All packages include installation, training, and 12-month support.',
                'cta_text' => 'Get Custom Quote', 'cta_link' => '/contact',
                'meta_title' => 'Smart Home & AI Pricing — 7AI Technologies',
                'meta_description' => 'Transparent pricing for smart home automation and AI solutions. Packages start from $999. Free consultation available.',
                'seo_keywords' => 'smart home pricing Africa, AI solution cost Africa, home automation price Nigeria',
                'content' => "## Smart Home Packages\n\n### Starter — From $999\nPerfect for single rooms or small apartments.\n- Smart lighting (1 room)\n- Mobile app control\n- Basic scheduling\n- Installation and training\n- 12-month warranty\n\n### Smart Home — From $3,499\nComplete whole-home automation.\n- Full-home lighting control\n- Smart security system\n- Climate control\n- Voice automation\n- Mobile app control\n- Energy monitoring\n- Installation and training\n- 12-month warranty + support\n\n### Premium — From $8,999\nThe ultimate smart home experience.\n- Everything in Smart Home\n- AI-powered learning\n- Biometric access control\n- Solar integration\n- HD surveillance system\n- Premium 24/7 support\n\n### Enterprise — Custom Pricing\nFor businesses, commercial properties, and multi-site deployments.\nContact us for a custom quote.\n\n## AI Solution Pricing\nAI solution pricing varies based on project scope, data requirements, and deployment complexity. Contact us for a detailed proposal.",
            ],
            [
                'title' => 'Case Studies',
                'slug'  => 'case-studies',
                'template' => 'default',
                'hero_title'       => 'Real Results Across Africa',
                'hero_subtitle'    => 'Case Studies',
                'hero_description' => 'See how 7AI is transforming homes and businesses with measurable, real-world results across the African continent.',
                'cta_text' => 'Book Consultation', 'cta_link' => '/contact',
                'meta_title' => 'Case Studies — 7AI Technologies',
                'meta_description' => 'Real results from 7AI smart home and AI deployments across Nigeria, Ghana, Kenya, South Africa, and more.',
                'seo_keywords' => 'AI case studies Africa, smart home results Africa, 7AI success stories',
                'content' => "## Meridian Group — Lagos, Nigeria\n**Challenge:** High energy costs across 12-floor office building.\n**Solution:** Smart lighting, climate control, and energy management system.\n**Results:** 45% reduction in energy costs. Full ROI in 8 months.\n\n---\n\n## Solaris Estates — Accra, Ghana\n**Challenge:** Security concerns across 200-unit residential complex.\n**Solution:** AI surveillance, facial recognition access control, smart intercoms.\n**Results:** Zero security incidents since deployment. Tenant satisfaction up 40%.\n\n---\n\n## PanAfrica Hub — Nairobi, Kenya\n**Challenge:** Supply chain stockouts affecting revenue.\n**Solution:** Custom ML demand forecasting model integrated with ERP.\n**Results:** Stockouts reduced by 70%. Inventory costs down 25%.\n\n---\n\n## NovaBuild — Nairobi, Kenya\n**Challenge:** Manufacturing waste and quality control issues.\n**Solution:** Computer vision quality inspection and AI process optimisation.\n**Results:** Waste reduced 35%. ROI achieved in under 3 months.\n\n---\n\n## Standard Bank Group — Johannesburg, South Africa\n**Challenge:** High fraud losses and excessive false positive alerts.\n**Solution:** Custom AI fraud detection model.\n**Results:** False positives reduced 60%. Fraud detection rate up 40%.",
            ],
            [
                'title' => 'Industries',
                'slug'  => 'industries',
                'template' => 'default',
                'hero_title'       => 'Built for Every African Sector',
                'hero_subtitle'    => 'Industries We Serve',
                'hero_description' => 'Our solutions adapt to the unique requirements, data types, and workflows of different industries across the continent.',
                'cta_text' => 'Find Your Solution', 'cta_link' => '/contact',
                'meta_title' => 'Industries We Serve — 7AI Technologies',
                'meta_description' => 'Smart home and AI solutions for residential, commercial, manufacturing, healthcare, hospitality, education, agriculture, and more.',
                'seo_keywords' => 'AI for healthcare Africa, smart building Africa, AI agriculture Africa, AI logistics Africa',
                'content' => "## Our Industry Solutions\n7AI serves clients across 12+ industry sectors in Africa. Each solution is tailored to the specific processes, regulations, and data environments of that industry.\n\n- **Residential** — Smart homes, energy management, security\n- **Commercial** — Smart buildings, HVAC, access control, occupancy analytics\n- **Manufacturing** — Quality control, predictive maintenance, process optimisation\n- **Healthcare** — Patient monitoring, medical imaging AI, hospital management\n- **Hospitality** — Guest experience, smart rooms, energy management\n- **Education** — Smart classrooms, campus security, learning analytics\n- **Agriculture** — Precision farming, crop monitoring, irrigation automation\n- **Finance** — Fraud detection, credit scoring, customer analytics\n- **Logistics** — Fleet tracking, route optimisation, warehouse automation\n- **Real Estate** — Smart property management, building performance\n- **Energy** — Grid optimisation, renewable energy management\n- **Government** — Smart city infrastructure, public safety\n\nContact us to discuss your specific industry requirements.",
            ],
            [
                'title' => 'About Us',
                'slug'  => 'about',
                'template' => 'default',
                'hero_title'       => 'Built for Africa\'s Future',
                'hero_subtitle'    => 'Our Story',
                'hero_description' => 'We are a technology company on a mission to bring intelligent automation to every African home and business — empowering people with technology that just works.',
                'cta_text' => 'Get in Touch', 'cta_link' => '/contact',
                'meta_title' => 'About 7AI Technologies',
                'meta_description' => 'Learn about 7AI Technologies — Africa\'s leading smart home and AI company. Our mission, team, and values.',
                'seo_keywords' => 'about 7AI, AI company Africa, smart home company Nigeria, 7AI Technologies',
                'content' => "## Our Mission\nTo make intelligent technology accessible to every African home and business, empowering people with tools that simplify life, reduce costs, and unlock new opportunities.\n\n## Our Story\n7AI Technologies was founded in 2020 by a team of engineers and technologists who believed that Africa deserved world-class smart technology built specifically for its unique context — not imported solutions that barely work.\n\nWe started with smart home automation in Lagos and Accra, and have since expanded to 12+ African countries, deploying solutions for residential, commercial, and enterprise clients.\n\n## Our Values\n\n**African First** — Every product, solution, and decision starts with the African context. We design for African power conditions, connectivity, languages, and culture.\n\n**Results Driven** — We are measured by our clients' results, not our technology. Every engagement has clear, measurable success metrics.\n\n**Innovation** — We continuously push the boundaries of what's possible with AI and smart technology on the continent.\n\n**Integrity** — We are honest, transparent, and do what we say we will do.\n\n## Our Numbers\n- 500+ homes automated\n- 120+ business clients\n- 98% client satisfaction rate\n- 12+ African countries\n- 50+ team members\n- Founded 2020\n\n## Our Team\nOur team of 50+ engineers, designers, sales professionals, and operators spans Nigeria, Ghana, Kenya, and South Africa, bringing together deep local knowledge and world-class technical expertise.",
            ],
            [
                'title' => 'Careers',
                'slug'  => 'careers',
                'template' => 'default',
                'hero_title'       => 'Build Africa\'s AI Future With Us',
                'hero_subtitle'    => 'Careers at 7AI',
                'hero_description' => 'We\'re looking for passionate engineers, designers, sales professionals, and operators who want to make a real difference across the African continent.',
                'cta_text' => 'Send Your CV', 'cta_link' => '/contact',
                'meta_title' => 'Careers — 7AI Technologies',
                'meta_description' => 'Join 7AI Technologies and build Africa\'s AI future. Open roles in engineering, sales, design, and operations.',
                'seo_keywords' => 'careers 7AI, AI jobs Africa, smart home jobs Nigeria, tech jobs Africa',
                'content' => "## Why Work at 7AI?\n\n**Meaningful work** — Your work directly improves the lives of African homeowners, business owners, and communities.\n\n**Growth opportunity** — We're growing fast across the continent. There's space for ambitious people to grow quickly with us.\n\n**Competitive compensation** — We offer competitive salaries, performance bonuses, and equity for senior roles.\n\n**Flexible working** — We support hybrid and remote work across our markets.\n\n**Learning culture** — Continuous learning and development is built into how we work.\n\n## Open Roles\n\n### Engineering\n- Senior AI/ML Engineer (Lagos, Nairobi, Remote)\n- Full-Stack Developer — Laravel/React (Lagos, Remote)\n- IoT Systems Engineer (Lagos, Accra)\n- Mobile Developer (iOS/Android) (Remote)\n\n### Sales & Business Development\n- Sales Manager — Smart Homes (Lagos, Accra, Nairobi)\n- Enterprise Account Executive — AI Solutions (Lagos, Johannesburg)\n- Business Development Representative (Multiple Markets)\n\n### Design & Product\n- Product Designer — Smart Home App (Remote)\n- UX Research Lead (Lagos)\n\n### Operations\n- Smart Home Technician (Lagos, Accra, Nairobi, Cape Town)\n- Customer Success Manager (Lagos, Remote)\n\n## How to Apply\nSend your CV and a brief cover letter to careers@7ai.africa or use our contact form. We review all applications within 5 business days.",
            ],
            [
                'title' => 'Blog',
                'slug'  => 'blog',
                'template' => 'default',
                'hero_title'       => 'Insights & Ideas from 7AI',
                'hero_subtitle'    => 'Blog',
                'hero_description' => 'The latest thinking on AI, smart home technology, energy, and innovation from across Africa.',
                'cta_text' => 'Subscribe to Newsletter', 'cta_link' => '/contact',
                'meta_title' => 'Blog — 7AI Technologies',
                'meta_description' => 'Latest insights on AI, smart home technology, and innovation in Africa from the 7AI Technologies team.',
                'seo_keywords' => 'AI blog Africa, smart home news Nigeria, AI technology Africa, tech blog Africa',
                'content' => "Our blog covers AI, smart home automation, energy management, and technology innovation across Africa. Subscribe to our newsletter to receive new articles directly in your inbox.",
            ],
            [
                'title' => 'Contact',
                'slug'  => 'contact',
                'template' => 'contact',
                'hero_title'       => 'Let\'s Talk',
                'hero_subtitle'    => 'Contact Us',
                'hero_description' => 'Our team of experts is ready to help you transform your home or business. Book a free consultation or send us a message — we respond within 24 hours.',
                'cta_text' => 'Book Free Consultation', 'cta_link' => '#contact-form',
                'meta_title' => 'Contact 7AI Technologies',
                'meta_description' => 'Get in touch with 7AI Technologies. Book a free consultation, call us, or send a message. We respond within 24 hours.',
                'seo_keywords' => 'contact 7AI, smart home consultation Africa, AI consultation Nigeria',
                'content' => "## Get In Touch\nWe'd love to hear from you. Use the form below to send us a message, or reach out directly using the details on this page.\n\n**Email:** hello@7ai.africa\n**Phone:** +234 800 7AI-TECH\n**WhatsApp:** +2348007248324\n\n**Office Hours:** Monday – Friday, 8am – 6pm WAT\n\n**Lagos Office:** Victoria Island, Lagos, Nigeria\n**Accra Office:** Cantonments, Accra, Ghana\n**Nairobi Office:** Westlands, Nairobi, Kenya",
            ],
            [
                'title' => 'Support',
                'slug'  => 'support',
                'template' => 'default',
                'hero_title'       => 'We\'re Here to Help',
                'hero_subtitle'    => 'Support Center',
                'hero_description' => 'Get help with your 7AI products and services. Browse our FAQs, submit a support request, or chat with our team directly.',
                'cta_text' => 'Open Support Ticket', 'cta_link' => '/login',
                'meta_title' => 'Support — 7AI Technologies',
                'meta_description' => 'Get support for your 7AI smart home or AI solution. FAQs, support tickets, phone, and WhatsApp support available 24/7.',
                'seo_keywords' => 'smart home support Africa, 7AI support, AI solution help',
                'content' => "## Support Channels\n\n**Existing Customers**\nLog in to your dashboard to open a support ticket, check ticket status, and access your project documentation.\n\n**Phone Support**\nCall us on +234 800 7AI-TECH for immediate assistance. Available Monday–Friday, 8am–6pm WAT.\n\n**WhatsApp**\nMessage us on WhatsApp at +2348007248324 for quick responses, 7 days a week.\n\n**Email**\nEmail support@7ai.africa — we respond within 4 business hours.\n\n## Frequently Asked Questions\nFind answers to the most common questions below.",
            ],
            [
                'title' => 'Documentation',
                'slug'  => 'docs',
                'template' => 'default',
                'hero_title'       => 'Product Documentation',
                'hero_subtitle'    => 'Docs',
                'hero_description' => 'Guides, tutorials, and technical documentation for all 7AI products and services.',
                'cta_text' => 'Contact Support', 'cta_link' => '/support',
                'meta_title' => 'Documentation — 7AI Technologies',
                'meta_description' => 'Technical documentation, user guides, and tutorials for 7AI smart home and AI products.',
                'content' => "## Getting Started\n\n### 7AI Mobile App\n- Download from App Store or Google Play\n- Create your account at app.7ai.africa\n- Scan QR code to pair your home hub\n\n### Smart Home Quick Start\n1. Ensure your hub is powered and connected to Wi-Fi\n2. Download the 7AI app\n3. Tap 'Add Home' and follow the setup wizard\n4. Add devices using the + button in each room\n\n### AI Solution Documentation\nFor enterprise AI solution documentation, log in to your client portal at portal.7ai.africa or contact your account manager.\n\n## User Guides\n- Smart Lighting User Guide\n- Smart Security System Guide\n- Climate Control Setup Guide\n- Solar Energy Monitor Guide\n- Voice Automation Guide\n- Mobile App User Manual\n\nFor detailed documentation, download the PDF guides from your client portal or contact our support team.",
            ],
            [
                'title' => 'Investors',
                'slug'  => 'investors',
                'template' => 'default',
                'hero_title'       => 'Invest in Africa\'s AI Future',
                'hero_subtitle'    => 'Investor Relations',
                'hero_description' => 'Join our growing network of investors backing Africa\'s leading AI and smart technology company. We are on a mission to transform 1 million homes and businesses by 2030.',
                'cta_text' => 'Register Interest', 'cta_link' => '#investor-form',
                'meta_title' => 'Investors — 7AI Technologies',
                'meta_description' => 'Investment opportunity in 7AI Technologies — Africa\'s leading smart home and AI company. $750K target raise with $5M pre-money valuation.',
                'seo_keywords' => 'invest in African AI, tech investment Africa, 7AI investors, AI startup Africa',
                'content' => "## The Opportunity\nAfrica's smart home and AI market is projected to reach $10 billion by 2030. 7AI is positioned to capture a significant share of this market with our first-mover advantage and deep local expertise.\n\n## Investment Highlights\n- **$750,000** target raise in current round\n- **$5M** pre-money valuation\n- **15%** equity available\n- **Minimum investment:** $10,000\n- **12-month** minimum holding period\n\n## Traction\n- 500+ homes and businesses automated\n- $2.1M revenue in 2024\n- 120%+ year-on-year revenue growth\n- 98% client satisfaction rate\n- Operations in 12+ African countries\n- 50+ team members\n\n## Use of Funds\n- 40% — Sales and market expansion across 8 new markets\n- 30% — Engineering and product development\n- 20% — Hiring and team scaling\n- 10% — Marketing and brand building\n\n## Why Invest Now?\nWe are at an inflection point. Our proven product, strong client retention, and expanding team make this the ideal time to invest before our Series A in 2026.\n\n## Register Your Interest\nFill in the form below and our investor relations team will send you our full pitch deck and invite you to an investor briefing call.",
            ],
            [
                'title' => 'Privacy Policy',
                'slug'  => 'privacy',
                'template' => 'default',
                'hero_title'       => 'Privacy Policy',
                'hero_subtitle'    => 'Last updated: January 2025',
                'hero_description' => 'How 7AI Technologies collects, uses, and protects your personal information.',
                'meta_title' => 'Privacy Policy — 7AI Technologies',
                'meta_description' => 'Read the 7AI Technologies privacy policy. How we collect, use, and protect your personal information.',
                'content' => "## 1. Introduction\n7AI Technologies Ltd (\"7AI\", \"we\", \"us\") is committed to protecting your personal information. This Privacy Policy explains how we collect, use, share, and safeguard your data.\n\n## 2. Information We Collect\n- Contact information (name, email, phone number)\n- Account credentials\n- Device and usage data from smart home systems\n- Payment information (processed securely by third-party providers)\n- Communication records (support tickets, emails)\n\n## 3. How We Use Your Information\n- To provide and improve our services\n- To communicate with you about your account and services\n- To send relevant marketing communications (with your consent)\n- To comply with legal obligations\n- To ensure the security of our systems and services\n\n## 4. Data Sharing\nWe do not sell your personal data. We may share it with trusted service providers who assist us in delivering our services, subject to strict data processing agreements.\n\n## 5. Data Security\nWe use industry-standard encryption and security practices to protect your data. We are compliant with NDPR (Nigeria), POPIA (South Africa), and relevant data protection regulations.\n\n## 6. Your Rights\nYou have the right to access, correct, or delete your personal data. Contact privacy@7ai.africa to exercise your rights.\n\n## 7. Contact\nFor privacy enquiries, contact: privacy@7ai.africa",
            ],
            [
                'title' => 'Terms of Service',
                'slug'  => 'terms',
                'template' => 'default',
                'hero_title'       => 'Terms of Service',
                'hero_subtitle'    => 'Last updated: January 2025',
                'hero_description' => 'The terms governing your use of 7AI Technologies products and services.',
                'meta_title' => 'Terms of Service — 7AI Technologies',
                'meta_description' => 'Read the 7AI Technologies terms of service governing use of our smart home and AI products and services.',
                'content' => "## 1. Acceptance of Terms\nBy using 7AI Technologies services, you agree to these Terms of Service. If you do not agree, do not use our services.\n\n## 2. Services\n7AI provides smart home automation, AI solutions, and related technology services. Specific terms for each service are outlined in your service agreement.\n\n## 3. User Obligations\n- Provide accurate information\n- Maintain the security of your account credentials\n- Use services only for lawful purposes\n- Not attempt to reverse-engineer or copy our technology\n\n## 4. Payment\nPayment terms are outlined in your service agreement. Late payments may result in service suspension. All prices are exclusive of applicable taxes.\n\n## 5. Warranties and Liability\nWe provide a 12-month warranty on all hardware installations. Software is provided \"as is\" with continuous updates. We are not liable for indirect or consequential damages.\n\n## 6. Termination\nEither party may terminate service agreements with 30 days written notice, subject to terms in your specific agreement.\n\n## 7. Governing Law\nThese terms are governed by the laws of the Federal Republic of Nigeria.\n\n## 8. Contact\nLegal enquiries: legal@7ai.africa",
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                array_merge($pageData, [
                    'status'       => 'published',
                    'published_at' => now(),
                    'created_by'   => $admin->id,
                    'sort_order'   => 0,
                ])
            );
        }

        // ═══════════════════════════════════════════════════════════════
        //  BLOG POSTS — Extra ones
        // ═══════════════════════════════════════════════════════════════
        $cat = Category::where('slug', 'smart-home')->first();
        $aiCatBlog = Category::where('slug', 'ai-technology')->first();
        $energyCatBlog = Category::where('slug', 'energy-solar')->first();

        $posts = [
            ['The Future of Smart Homes in Sub-Saharan Africa',            'smart-homes-africa',          'How AI-powered home automation is reshaping urban living across Nigeria, Ghana, and Kenya.',                                                    $cat?->id,        'published', 8],
            ['Predictive Analytics: Africa\'s Competitive Edge',           'predictive-analytics-africa', 'Why African businesses leveraging AI are outperforming traditional competitors by 3x.',                                                       $aiCatBlog?->id,  'published', 7],
            ['Solar + AI: The Intelligent Energy Revolution',              'solar-ai-energy',             'Combining solar power with AI management systems for maximum efficiency and resilience.',                                                       $energyCatBlog?->id, 'published', 6],
            ['How AI is Transforming Manufacturing in Nigeria',            'ai-manufacturing-nigeria',    'Case study: How a Lagos manufacturer cut waste by 35% using computer vision and predictive maintenance.',                                      $aiCatBlog?->id,  'published', 6],
            ['Smart Security: Why AI-Powered Surveillance is the Future',  'ai-smart-security',           'Traditional CCTV is dead. Here\'s how AI surveillance is changing safety and security for African homes and businesses.',                      $cat?->id,        'published', 5],
            ['Building a Smart City: Lessons from Nairobi',               'smart-city-nairobi',          'How Nairobi is using IoT, AI, and data to become one of Africa\'s most intelligent cities.',                                                  $aiCatBlog?->id,  'published', 7],
            ['The ROI of Smart Home Automation for African Property',      'smart-home-roi-africa',       'Numbers from 100+ installations: the real return on investment for smart home technology across different African markets.',                    $cat?->id,        'published', 8],
            ['7 Ways AI is Changing Agriculture in Africa',                'ai-agriculture-africa',       'From crop disease detection to precision irrigation — how artificial intelligence is helping African farmers produce more with less.',            $aiCatBlog?->id,  'draft',     7],
        ];

        foreach ($posts as [$title, $slug, $excerpt, $catId, $status, $readTime]) {
            Post::updateOrCreate(['slug' => $slug], [
                'title' => $title, 'excerpt' => $excerpt,
                'content' => "# $title\n\n$excerpt\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\n\nDuis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n\n## Key Takeaways\n- Point one of the article's key insight\n- Point two with actionable recommendation\n- Point three with data or evidence\n\n## Conclusion\nThe future of AI and smart technology in Africa is bright. [Contact 7AI](/contact) to learn how we can help your home or business.",
                'author_id' => $admin->id, 'category_id' => $catId,
                'status' => $status, 'published_at' => $status === 'published' ? now()->subDays(rand(1, 90)) : null,
                'read_time' => $readTime, 'featured' => in_array($slug, ['smart-homes-africa','predictive-analytics-africa','solar-ai-energy']),
            ]);
        }

        $this->command->info('✅ Full CMS content seeded successfully!');
        $this->command->info('   Pages: ' . Page::count());
        $this->command->info('   Services: ' . Service::count());
        $this->command->info('   Cards: ' . \App\Models\Card::count());
        $this->command->info('   Testimonials: ' . Testimonial::count());
        $this->command->info('   FAQs: ' . Faq::count());
        $this->command->info('   CTAs: ' . Cta::count());
        $this->command->info('   Forms: ' . Form::count());
        $this->command->info('   Blog Posts: ' . Post::count());
        $this->command->info('   Settings: ' . Setting::count());

        // Default popup (disabled by default — admin activates it)
        \App\Models\SitePopup::updateOrCreate(['name' => 'Welcome Flyer'], [
            'image_path'  => null,
            'link_url'    => '/abuja',
            'link_text'   => 'Register Now',
            'show_times'  => 2,
            'is_active'   => false,
        ]);
    }

    private function seedFormFields(int $formId, array $fields): void
    {
        foreach ($fields as $field) {
            [$label, $name, $type, $placeholder, $required, $sort] = $field;
            $options = $field[6] ?? null;
            FormField::updateOrCreate(
                ['form_id' => $formId, 'name' => $name],
                [
                    'label'       => $label,
                    'field_type'  => $type,
                    'placeholder' => $placeholder,
                    'is_required' => (bool) $required,
                    'options'     => $options,
                    'sort_order'  => $sort,
                    'is_active'   => true,
                ]
            );
        }  // end foreach
    }
}
