<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->boolean('discount_enabled')->default(false)->after('is_conference_form');
            $table->decimal('discount_percent', 5, 2)->default(50)->after('discount_enabled');
            $table->unsignedBigInteger('discount_check_form_id')->nullable()->after('discount_percent');
            $table->string('discount_email_subject')->nullable()->after('discount_check_form_id');
            $table->longText('discount_email_body')->nullable()->after('discount_email_subject');
            $table->string('discount_email_from_name')->nullable()->after('discount_email_body');
            $table->string('discount_email_from_address')->nullable()->after('discount_email_from_name');
            $table->foreign('discount_check_form_id')->references('id')->on('forms')->nullOnDelete();
        });

        Schema::table('form_submissions', function (Blueprint $table) {
            $table->boolean('discount_applied')->default(false)->after('badge_exported_at');
            $table->decimal('discount_pct', 5, 2)->nullable()->after('discount_applied');
            $table->timestamp('discount_email_sent_at')->nullable()->after('discount_pct');
        });
    }

    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropForeign(['discount_check_form_id']);
            $table->dropColumn([
                'discount_enabled', 'discount_percent', 'discount_check_form_id',
                'discount_email_subject', 'discount_email_body',
                'discount_email_from_name', 'discount_email_from_address',
            ]);
        });

        Schema::table('form_submissions', function (Blueprint $table) {
            $table->dropColumn(['discount_applied', 'discount_pct', 'discount_email_sent_at']);
        });
    }
};
