<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Add payment + duplicate-prevention columns to forms ─────────────
        Schema::table('forms', function (Blueprint $table) {
            // Payment
            $table->boolean('payment_enabled')->default(false)->after('welcome_email_field');
            $table->decimal('payment_amount', 10, 2)->nullable()->after('payment_enabled');
            $table->string('payment_currency', 10)->default('NGN')->after('payment_amount');
            $table->string('payment_description')->nullable()->after('payment_currency');
            // Duplicate prevention
            $table->boolean('prevent_duplicates')->default(false)->after('payment_description');
            $table->string('duplicate_check_fields')->nullable()->after('prevent_duplicates')
                  ->comment('Comma-separated field names to check for duplicates, e.g. email,phone');
        });

        // ── 2. Create /learnai form ────────────────────────────────────────────
        if (DB::table('forms')->where('slug', 'learnai')->doesntExist()) {
            $formId = DB::table('forms')->insertGetId([
                'name'               => 'Learn AI Registration',
                'slug'               => 'learnai',
                'public_path'        => 'learnai',
                'title'              => 'Learn AI — Register Now',
                'subtitle'           => 'Join Africa\'s fastest-growing AI training programme. Choose your course and start your journey today.',
                'description'        => 'AI training course registration form',
                'success_message'    => 'Thank you for registering! We will be in touch shortly with your course details.',
                'store_submissions'  => 1,
                'is_active'          => 1,
                'welcome_email_enabled' => 0,
                'prevent_duplicates' => 1,
                'duplicate_check_fields' => 'email,phone',
                'payment_enabled'    => 0,
                'payment_currency'   => 'NGN',
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            $fields = [
                [
                    'label'      => 'Full Name',
                    'name'       => 'full_name',
                    'field_type' => 'text',
                    'placeholder'=> 'Enter your full name',
                    'is_required'=> 1,
                    'sort_order' => 10,
                ],
                [
                    'label'      => 'Email Address',
                    'name'       => 'email',
                    'field_type' => 'email',
                    'placeholder'=> 'your@email.com',
                    'is_required'=> 1,
                    'sort_order' => 20,
                ],
                [
                    'label'      => 'Phone Number',
                    'name'       => 'phone',
                    'field_type' => 'phone',
                    'placeholder'=> '+234 800 000 0000',
                    'is_required'=> 1,
                    'sort_order' => 30,
                ],
                [
                    'label'      => 'Course of Interest',
                    'name'       => 'course',
                    'field_type' => 'select',
                    'placeholder'=> 'Select a course',
                    'is_required'=> 1,
                    'sort_order' => 40,
                    'options'    => json_encode([
                        'AI & Machine Learning Fundamentals',
                        'Prompt Engineering & ChatGPT Mastery',
                        'AI for Business & Productivity',
                        'Data Science & Analytics with AI',
                        'Computer Vision & Image Recognition',
                        'Natural Language Processing (NLP)',
                        'AI Automation & No-Code Tools',
                    ]),
                ],
                [
                    'label'      => 'Current Occupation',
                    'name'       => 'occupation',
                    'field_type' => 'select',
                    'placeholder'=> 'Select your occupation',
                    'is_required'=> 1,
                    'sort_order' => 50,
                    'options'    => json_encode([
                        'Student',
                        'Business Owner',
                        'Employee / Professional',
                        'Government Worker',
                        'Freelancer',
                        'Job Seeker',
                        'Other',
                    ]),
                ],
                [
                    'label'      => 'Experience Level',
                    'name'       => 'experience_level',
                    'field_type' => 'select',
                    'placeholder'=> 'Select your experience level',
                    'is_required'=> 1,
                    'sort_order' => 60,
                    'options'    => json_encode([
                        'Complete Beginner — No tech background',
                        'Some Technical Background',
                        'Intermediate — I know some programming',
                        'Advanced — I work in tech',
                    ]),
                ],
                [
                    'label'      => 'Preferred Learning Mode',
                    'name'       => 'learning_mode',
                    'field_type' => 'select',
                    'placeholder'=> 'How do you prefer to learn?',
                    'is_required'=> 1,
                    'sort_order' => 70,
                    'options'    => json_encode([
                        'Online (Live Sessions)',
                        'Physical (In-Person)',
                        'Hybrid (Online + Physical)',
                        'Self-Paced (Recorded)',
                    ]),
                ],
                [
                    'label'      => 'How Did You Hear About Us?',
                    'name'       => 'referral_source',
                    'field_type' => 'select',
                    'placeholder'=> 'Select an option',
                    'is_required'=> 0,
                    'sort_order' => 80,
                    'options'    => json_encode([
                        'Instagram',
                        'Facebook',
                        'Twitter / X',
                        'TikTok',
                        'Friend or Colleague',
                        'Google Search',
                        'WhatsApp Group',
                        'Event or Conference',
                        'Other',
                    ]),
                ],
            ];

            foreach ($fields as $field) {
                DB::table('form_fields')->insert(array_merge([
                    'form_id'     => $formId,
                    'is_active'   => 1,
                    'is_required' => 0,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ], $field));
            }
        }
    }

    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn([
                'payment_enabled', 'payment_amount', 'payment_currency',
                'payment_description', 'prevent_duplicates', 'duplicate_check_fields',
            ]);
        });

        DB::table('form_fields')->whereIn('form_id',
            DB::table('forms')->where('slug','learnai')->pluck('id')
        )->delete();
        DB::table('forms')->where('slug','learnai')->delete();
    }
};
