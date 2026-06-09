<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Service categories
        if (!Schema::hasTable('service_categories')) {
            Schema::create('service_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('icon')->nullable();
                $table->string('image')->nullable();
                $table->foreignId('parent_id')->nullable()->constrained('service_categories')->nullOnDelete();
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Services
        if (!Schema::hasTable('services')) {
            Schema::create('services', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('short_description')->nullable();
                $table->longText('full_description')->nullable();
                $table->foreignId('category_id')->nullable()->constrained('service_categories')->nullOnDelete();
                $table->string('featured_image')->nullable();
                $table->string('icon')->nullable();
                $table->string('price')->nullable();
                $table->string('cta_text')->nullable();
                $table->string('cta_link')->nullable();
                $table->string('meta_title')->nullable();
                $table->string('meta_description')->nullable();
                $table->enum('status', ['draft', 'published'])->default('published');
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        // Page sections (dynamic sections per page)
        if (!Schema::hasTable('page_sections')) {
            Schema::create('page_sections', function (Blueprint $table) {
                $table->id();
                $table->foreignId('page_id')->nullable()->constrained('pages')->nullOnDelete();
                $table->string('title')->nullable();
                $table->string('subtitle')->nullable();
                $table->text('description')->nullable();
                $table->string('section_type')->default('text_block'); // hero, text_block, image_text, service_cards, feature_cards, cta, faq, testimonials, contact_form, gallery, custom_html, stats
                $table->string('image')->nullable();
                $table->string('background_color')->nullable();
                $table->string('background_image')->nullable();
                $table->string('button_text')->nullable();
                $table->string('button_link')->nullable();
                $table->string('button2_text')->nullable();
                $table->string('button2_link')->nullable();
                $table->string('css_class')->nullable();
                $table->longText('custom_html')->nullable();
                $table->json('data')->nullable(); // extra flexible data
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // CTAs
        if (!Schema::hasTable('ctas')) {
            Schema::create('ctas', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // internal name
                $table->string('title')->nullable();
                $table->text('text')->nullable();
                $table->string('button_label')->nullable();
                $table->string('button_url')->nullable();
                $table->string('button2_label')->nullable();
                $table->string('button2_url')->nullable();
                $table->string('background_image')->nullable();
                $table->string('background_color')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Cards / Feature items
        if (!Schema::hasTable('cards')) {
            Schema::create('cards', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('subtitle')->nullable();
                $table->text('description')->nullable();
                $table->string('icon')->nullable();
                $table->string('image')->nullable();
                $table->string('link')->nullable();
                $table->string('button_text')->nullable();
                $table->string('group')->nullable(); // for grouping cards together
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Testimonials
        if (!Schema::hasTable('testimonials')) {
            Schema::create('testimonials', function (Blueprint $table) {
                $table->id();
                $table->string('author_name');
                $table->string('author_role')->nullable();
                $table->string('author_company')->nullable();
                $table->string('author_avatar')->nullable();
                $table->text('content');
                $table->integer('rating')->default(5);
                $table->boolean('is_featured')->default(false);
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        // FAQs
        if (!Schema::hasTable('faqs')) {
            Schema::create('faqs', function (Blueprint $table) {
                $table->id();
                $table->string('question');
                $table->text('answer');
                $table->string('category')->nullable();
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Forms (custom form builder)
        if (!Schema::hasTable('forms')) {
            Schema::create('forms', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->text('success_message')->nullable();
                $table->string('redirect_url')->nullable();
                $table->string('notification_email')->nullable();
                $table->boolean('store_submissions')->default(true);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Form fields
        if (!Schema::hasTable('form_fields')) {
            Schema::create('form_fields', function (Blueprint $table) {
                $table->id();
                $table->foreignId('form_id')->constrained('forms')->cascadeOnDelete();
                $table->string('label');
                $table->string('name'); // input name attribute
                $table->string('field_type')->default('text'); // text, email, phone, number, textarea, select, radio, checkbox, file, date, hidden
                $table->string('placeholder')->nullable();
                $table->text('help_text')->nullable();
                $table->boolean('is_required')->default(false);
                $table->text('options')->nullable(); // JSON options for select/radio/checkbox
                $table->string('validation_rules')->nullable();
                $table->string('default_value')->nullable();
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Form submissions
        if (!Schema::hasTable('form_submissions')) {
            Schema::create('form_submissions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('form_id')->constrained('forms')->cascadeOnDelete();
                $table->string('ip_address')->nullable();
                $table->string('user_agent')->nullable();
                $table->json('data'); // all field values
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }

        // Banners
        if (!Schema::hasTable('banners')) {
            Schema::create('banners', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->string('link')->nullable();
                $table->string('button_text')->nullable();
                $table->string('position')->default('home_hero'); // home_hero, top_bar, sidebar
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        // Social links (standalone for easy site settings)
        if (!Schema::hasTable('social_links')) {
            Schema::create('social_links', function (Blueprint $table) {
                $table->id();
                $table->string('platform'); // twitter, linkedin, facebook, youtube, instagram
                $table->string('url');
                $table->string('icon')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('form_submissions');
        Schema::dropIfExists('form_fields');
        Schema::dropIfExists('forms');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('cards');
        Schema::dropIfExists('ctas');
        Schema::dropIfExists('page_sections');
        Schema::dropIfExists('services');
        Schema::dropIfExists('service_categories');
    }
};
