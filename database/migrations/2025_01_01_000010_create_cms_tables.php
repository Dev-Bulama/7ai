<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Extend users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('country')->nullable()->after('phone');
            $table->string('company')->nullable()->after('country');
            $table->string('avatar')->nullable()->after('company');
            $table->boolean('is_active')->default(true)->after('avatar');
            $table->boolean('two_factor_enabled')->default(false)->after('is_active');
            $table->string('two_factor_secret')->nullable()->after('two_factor_enabled');
            $table->timestamp('last_login_at')->nullable()->after('two_factor_secret');
        });

        // Pages CMS
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('og_image')->nullable();
            $table->json('schema_markup')->nullable();
            $table->string('template')->default('default');
            $table->enum('status', ['draft', 'published', 'scheduled'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->json('sections')->nullable();
            $table->timestamps();
        });

        // Blog
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('color')->default('#0B4F6C');
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->foreignId('author_id')->constrained('users');
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->enum('status', ['draft', 'published', 'scheduled'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->integer('read_time')->default(5);
            $table->unsignedBigInteger('views')->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('allow_comments')->default(true);
            $table->timestamps();
        });

        Schema::create('post_tag', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['post_id', 'tag_id']);
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();
            $table->text('content');
            $table->enum('status', ['pending', 'approved', 'spam'])->default('pending');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->nullOnDelete();
            $table->timestamps();
        });

        // Media Library
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type');
            $table->string('disk')->default('public');
            $table->string('path');
            $table->unsignedBigInteger('size');
            $table->string('collection')->default('default');
            $table->json('custom_properties')->nullable();
            $table->string('alt_text')->nullable();
            $table->timestamps();
        });

        // Navigation / Menus
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->unique();
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->nullOnDelete();
            $table->string('label');
            $table->string('url')->nullable();
            $table->string('target')->default('_self');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Settings / SEO
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('media');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('settings');
    }
};
