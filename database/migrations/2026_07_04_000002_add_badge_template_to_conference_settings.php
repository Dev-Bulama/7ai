<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conference_settings', function (Blueprint $table) {
            $table->longText('badge_html_template')->nullable()->after('badge_logo_path');
        });
    }

    public function down(): void
    {
        Schema::table('conference_settings', function (Blueprint $table) {
            $table->dropColumn('badge_html_template');
        });
    }
};
