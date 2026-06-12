<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add welcome email columns to forms table
        Schema::table('forms', function (Blueprint $table) {
            $table->boolean('welcome_email_enabled')->default(false)->after('is_active');
            $table->string('welcome_email_subject')->nullable()->after('welcome_email_enabled');
            $table->longText('welcome_email_body')->nullable()->after('welcome_email_subject');
            $table->string('welcome_email_from_name')->nullable()->after('welcome_email_body');
            $table->string('welcome_email_from_address')->nullable()->after('welcome_email_from_name');
            $table->string('welcome_email_field')->nullable()->after('welcome_email_from_address')
                ->comment('Which form field holds the registrant email');
        });

        // Fix the abuja form title and name
        DB::table('forms')
            ->where('public_path', '/abuja')
            ->update([
                'name'     => 'Abuja AI Conference Registration',
                'title'    => 'Abuja AI Conference Registration',
                'subtitle' => 'Register for FREE to learn how AI can impact your work, home and organisation',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn([
                'welcome_email_enabled',
                'welcome_email_subject',
                'welcome_email_body',
                'welcome_email_from_name',
                'welcome_email_from_address',
                'welcome_email_field',
            ]);
        });
    }
};
