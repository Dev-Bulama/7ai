<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conference_settings', function (Blueprint $table) {
            $table->string('flyer_hashtag', 100)->nullable()->after('badge_html_template');
            $table->longText('flyer_html_template')->nullable()->after('flyer_hashtag');
        });
    }

    public function down(): void
    {
        Schema::table('conference_settings', function (Blueprint $table) {
            $table->dropColumn(['flyer_hashtag', 'flyer_html_template']);
        });
    }
};
