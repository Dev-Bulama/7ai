<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Expand user_agent from VARCHAR(255) to TEXT in all affected tables
        // Fixes SQLSTATE[22001] truncation error for long browser strings (e.g. Instagram WebView)
        foreach (['form_submissions', 'leads', 'campaign_opens'] as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'user_agent')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->text('user_agent')->nullable()->change();
                });
            }
        }
    }

    public function down(): void
    {
        foreach (['form_submissions', 'leads', 'campaign_opens'] as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'user_agent')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->string('user_agent')->nullable()->change();
                });
            }
        }
    }
};
