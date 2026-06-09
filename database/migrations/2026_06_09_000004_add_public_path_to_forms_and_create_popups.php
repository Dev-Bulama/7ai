<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('forms', function (Blueprint $table) {
            $table->string('public_path')->nullable()->after('slug')->comment('Public URL path e.g. /abuja');
            $table->string('title')->nullable()->after('public_path');
            $table->string('subtitle')->nullable()->after('title');
            $table->string('bg_color')->default('#ffffff')->after('subtitle');
        });

        Schema::create('site_popups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_path')->nullable();
            $table->string('link_url')->nullable();
            $table->string('link_text')->nullable()->default('Learn More');
            $table->integer('show_times')->default(2);
            $table->boolean('is_active')->default(true);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn(['public_path','title','subtitle','bg_color']);
        });
        Schema::dropIfExists('site_popups');
    }
};
