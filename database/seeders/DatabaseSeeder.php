<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Lead;
use App\Models\Subscriber;
use App\Models\SubscriberList;
use App\Models\Campaign;
use App\Models\Setting;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $roles = ['super-admin','admin','marketing-manager','content-manager','support-staff','customer'];
        foreach ($roles as $role) Role::firstOrCreate(['name' => $role]);

        // Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@7ai.africa'],
            ['name' => '7AI Admin', 'password' => Hash::make('password'), 'email_verified_at' => now(), 'is_active' => true]
        );
        $admin->assignRole('super-admin');

        // Marketing manager
        $marketing = User::firstOrCreate(
            ['email' => 'marketing@7ai.africa'],
            ['name' => 'Marketing Manager', 'password' => Hash::make('password'), 'email_verified_at' => now(), 'is_active' => true]
        );
        $marketing->assignRole('marketing-manager');

        // Demo customer
        $customer = User::firstOrCreate(
            ['email' => 'demo@example.com'],
            ['name' => 'Demo Customer', 'password' => Hash::make('password'), 'email_verified_at' => now(), 'company' => 'Demo Corp', 'country' => 'Nigeria', 'is_active' => true]
        );
        $customer->assignRole('customer');

        // Categories
        $cats = [
            ['Smart Home', 'smart-home', '#0B4F6C'],
            ['AI & Technology', 'ai-technology', '#3EE07F'],
            ['Energy & Solar', 'energy-solar', '#f59e0b'],
            ['Security', 'security', '#ef4444'],
            ['Industry News', 'industry-news', '#8b5cf6'],
        ];
        foreach ($cats as [$name, $slug, $color]) {
            Category::firstOrCreate(['slug' => $slug], ['name' => $name, 'color' => $color]);
        }

        // Tags
        $tags = ['IoT','Automation','Solar','AI','Machine Learning','Smart Cities','Africa','Energy Efficiency'];
        foreach ($tags as $tag) {
            Tag::firstOrCreate(['slug' => \Illuminate\Support\Str::slug($tag)], ['name' => $tag]);
        }

        // Sample posts
        $category = Category::where('slug','smart-home')->first();
        $posts = [
            ['The Future of Smart Homes in Africa', 'smart-homes-africa', 'As African cities grow rapidly, smart home technology is becoming more accessible and relevant than ever before.', 'published'],
            ['How AI is Transforming Energy Management', 'ai-energy-management', 'Artificial intelligence is revolutionizing how homes and businesses manage energy consumption across Africa.', 'published'],
            ['7AI Launches New Solar Integration Platform', 'solar-integration-platform', 'Our latest platform enables seamless integration between solar inverters and home automation systems.', 'published'],
        ];
        foreach ($posts as [$title, $slug, $excerpt, $status]) {
            Post::firstOrCreate(['slug' => $slug], [
                'title' => $title,
                'excerpt' => $excerpt,
                'content' => "# $title\n\n$excerpt\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.",
                'author_id' => $admin->id,
                'category_id' => $category?->id,
                'status' => $status,
                'published_at' => $status === 'published' ? now() : null,
                'read_time' => rand(3, 8),
            ]);
        }

        // Sample leads
        $leads = [
            ['Akin', 'Johnson', 'akin@example.com', '+234 801 234 5678', 'Lagos Residences Ltd', 'Nigeria', 'Smart Home Installation', 'new'],
            ['Amara', 'Osei', 'amara@example.com', '+233 24 567 8901', null, 'Ghana', 'AI Solutions', 'contacted'],
            ['Fatima', 'Al-Hassan', 'fatima@example.com', '+254 712 345 678', 'Nairobi Tech Hub', 'Kenya', 'Energy Management', 'qualified'],
            ['David', 'Mensah', 'david@example.com', null, null, 'Ghana', 'Security Systems', 'new'],
            ['Ngozi', 'Adeyemi', 'ngozi@example.com', '+234 803 456 7890', 'Adeyemi Holdings', 'Nigeria', 'Smart Home', 'proposal'],
        ];
        foreach ($leads as [$fn, $ln, $email, $phone, $company, $country, $interest, $status]) {
            Lead::firstOrCreate(['email' => $email], [
                'first_name' => $fn, 'last_name' => $ln,
                'phone' => $phone, 'company' => $company, 'country' => $country,
                'service_interest' => $interest, 'status' => $status,
                'message' => "I am interested in your $interest services and would like to know more about pricing and availability.",
            ]);
        }

        // Subscriber list
        $list = SubscriberList::firstOrCreate(['name' => 'Main Newsletter'], ['description' => 'Primary newsletter subscribers']);

        // Sample subscribers
        $subs = [
            ['sub1@example.com', 'Kofi', 'Mensah', 'Ghana'],
            ['sub2@example.com', 'Amina', 'Bello', 'Nigeria'],
            ['sub3@example.com', 'James', 'Kariuki', 'Kenya'],
            ['sub4@example.com', 'Priya', 'Naidoo', 'South Africa'],
            ['sub5@example.com', 'Emeka', 'Okafor', 'Nigeria'],
        ];
        foreach ($subs as [$email, $first, $last, $country]) {
            $sub = Subscriber::firstOrCreate(['email' => $email], [
                'first_name' => $first, 'last_name' => $last, 'country' => $country, 'status' => 'subscribed',
            ]);
            $list->subscribers()->syncWithoutDetaching([$sub->id]);
        }
        $list->update(['subscriber_count' => $list->subscribers()->count()]);

        // Sample campaign
        Campaign::firstOrCreate(['name' => 'Welcome to 7AI'], [
            'subject' => 'Welcome to 7AI — African Intelligence, Amplified',
            'preview_text' => 'Thank you for joining the 7AI community',
            'content' => '<h1>Welcome to 7AI</h1><p>Thank you for joining us. We are excited to help you transform your home or business with intelligent technology.</p>',
            'from_name' => '7AI Technologies',
            'from_email' => 'hello@7ai.africa',
            'type' => 'newsletter',
            'status' => 'draft',
            'created_by' => $admin->id,
            'subscriber_list_id' => $list->id,
        ]);

        // Settings
        $settings = [
            ['site_name', '7AI Technologies', 'general'],
            ['site_email', 'hello@7ai.africa', 'general'],
            ['site_phone', '+234 800 7AI-TECH', 'general'],
            ['site_address', 'Victoria Island, Lagos, Nigeria', 'general'],
            ['smtp_host', 'smtp.mailgun.org', 'email'],
            ['smtp_port', '587', 'email'],
            ['support_email', 'support@7ai.africa', 'email'],
        ];
        foreach ($settings as [$key, $value, $group]) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        }

        $this->command->info('7AI database seeded successfully.');
        $this->command->info('Admin: admin@7ai.africa / password');
        $this->command->info('Demo customer: demo@example.com / password');
    }
}
