<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Subscriber lists
        Schema::create('subscriber_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('subscriber_count')->default(0);
            $table->timestamps();
        });

        // Subscribers
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->json('tags')->nullable();
            $table->json('custom_fields')->nullable();
            $table->enum('status', ['subscribed', 'unsubscribed', 'bounced', 'complained'])->default('subscribed');
            $table->string('source')->nullable();
            $table->timestamp('subscribed_at')->useCurrent();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('subscriber_list', function (Blueprint $table) {
            $table->foreignId('subscriber_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscriber_list_id')->constrained()->cascadeOnDelete();
            $table->primary(['subscriber_id', 'subscriber_list_id']);
        });

        // Campaigns
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subject');
            $table->string('preview_text')->nullable();
            $table->longText('content');
            $table->string('from_name');
            $table->string('from_email');
            $table->string('reply_to')->nullable();
            $table->enum('type', ['newsletter', 'promotional', 'drip', 'transactional', 'automated'])->default('newsletter');
            $table->enum('status', ['draft', 'scheduled', 'sending', 'sent', 'paused', 'cancelled'])->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('subscriber_list_id')->nullable()->constrained('subscriber_lists')->nullOnDelete();
            // AI generation fields
            $table->text('ai_prompt')->nullable();
            $table->string('ai_goal')->nullable();
            $table->string('ai_tone')->nullable();
            $table->string('ai_audience')->nullable();
            // Stats
            $table->unsignedInteger('total_sent')->default(0);
            $table->unsignedInteger('total_delivered')->default(0);
            $table->unsignedInteger('total_opened')->default(0);
            $table->unsignedInteger('total_clicked')->default(0);
            $table->unsignedInteger('total_bounced')->default(0);
            $table->unsignedInteger('total_unsubscribed')->default(0);
            $table->timestamps();
        });

        // Campaign sends (individual tracking)
        Schema::create('campaign_sends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscriber_id')->constrained()->cascadeOnDelete();
            $table->string('message_id')->nullable();
            $table->enum('status', ['pending', 'sent', 'delivered', 'opened', 'clicked', 'bounced', 'complained', 'unsubscribed'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->unsignedInteger('open_count')->default(0);
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('country')->nullable();
            $table->string('device')->nullable();
            $table->timestamps();
        });

        // Link clicks tracking
        Schema::create('campaign_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_send_id')->constrained()->cascadeOnDelete();
            $table->string('url');
            $table->string('ip_address')->nullable();
            $table->string('country')->nullable();
            $table->string('device')->nullable();
            $table->timestamp('clicked_at')->useCurrent();
            $table->timestamps();
        });

        // Email Automation sequences
        Schema::create('automation_sequences', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('trigger', ['subscribe', 'unsubscribe', 'welcome', 'date', 'tag_added', 'link_clicked', 'form_submitted'])->default('subscribe');
            $table->json('trigger_config')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('subscriber_list_id')->nullable()->constrained('subscriber_lists')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('automation_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sequence_id')->constrained('automation_sequences')->cascadeOnDelete();
            $table->integer('delay_days')->default(0);
            $table->integer('delay_hours')->default(0);
            $table->string('subject');
            $table->string('preview_text')->nullable();
            $table->longText('content');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // A/B Tests
        Schema::create('ab_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->string('variant_name');
            $table->string('subject');
            $table->string('preview_text')->nullable();
            $table->longText('content')->nullable();
            $table->unsignedInteger('send_percentage')->default(50);
            $table->unsignedInteger('total_sent')->default(0);
            $table->unsignedInteger('total_opened')->default(0);
            $table->unsignedInteger('total_clicked')->default(0);
            $table->boolean('is_winner')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ab_tests');
        Schema::dropIfExists('automation_emails');
        Schema::dropIfExists('automation_sequences');
        Schema::dropIfExists('campaign_clicks');
        Schema::dropIfExists('campaign_sends');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('subscriber_list');
        Schema::dropIfExists('subscribers');
        Schema::dropIfExists('subscriber_lists');
    }
};
