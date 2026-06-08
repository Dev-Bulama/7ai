<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Contact / Lead forms
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('country')->nullable();
            $table->text('message')->nullable();
            $table->string('service_interest')->nullable();
            $table->enum('status', ['new', 'contacted', 'qualified', 'proposal', 'won', 'lost'])->default('new');
            $table->string('source')->default('website');
            $table->string('ip_address')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Support tickets
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();
            $table->string('subject');
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['open', 'in_progress', 'waiting', 'resolved', 'closed'])->default('open');
            $table->string('category')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('first_response_at')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->text('content');
            $table->boolean('is_staff')->default(false);
            $table->boolean('is_internal')->default(false);
            $table->timestamps();
        });

        // Projects (client dashboard)
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type')->nullable();
            $table->enum('status', ['planning', 'in_progress', 'installation', 'completed', 'on_hold'])->default('planning');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->string('location')->nullable();
            $table->json('devices')->nullable();
            $table->timestamps();
        });

        // Invoices
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->string('currency')->default('USD');
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue', 'cancelled'])->default('draft');
            $table->date('due_date')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total', 12, 2);
            $table->timestamps();
        });

        // Subscriptions
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('plan_name');
            $table->string('plan_slug');
            $table->decimal('price', 10, 2);
            $table->string('currency')->default('USD');
            $table->enum('billing_cycle', ['monthly', 'annual'])->default('monthly');
            $table->enum('status', ['active', 'cancelled', 'expired', 'trial'])->default('active');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('current_period_start')->nullable();
            $table->timestamp('current_period_end')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });

        // Activity logs
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action');
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->text('description')->nullable();
            $table->json('properties')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('ticket_replies');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('leads');
    }
};
