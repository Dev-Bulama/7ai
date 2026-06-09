<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            if (!Schema::hasColumn('pages', 'parent_id')) {
                $table->foreignId('parent_id')->nullable()->constrained('pages')->nullOnDelete()->after('slug');
            }
            if (!Schema::hasColumn('pages', 'page_type')) {
                $table->string('page_type')->default('standard')->after('parent_id'); // standard, home, landing, service
            }
            if (!Schema::hasColumn('pages', 'featured_image')) {
                $table->string('featured_image')->nullable()->after('page_type');
            }
            if (!Schema::hasColumn('pages', 'hero_title')) {
                $table->string('hero_title')->nullable()->after('featured_image');
            }
            if (!Schema::hasColumn('pages', 'hero_subtitle')) {
                $table->string('hero_subtitle')->nullable()->after('hero_title');
            }
            if (!Schema::hasColumn('pages', 'hero_description')) {
                $table->text('hero_description')->nullable()->after('hero_subtitle');
            }
            if (!Schema::hasColumn('pages', 'cta_text')) {
                $table->string('cta_text')->nullable()->after('hero_description');
            }
            if (!Schema::hasColumn('pages', 'cta_link')) {
                $table->string('cta_link')->nullable()->after('cta_text');
            }
            if (!Schema::hasColumn('pages', 'seo_keywords')) {
                $table->string('seo_keywords')->nullable()->after('meta_description');
            }
            if (!Schema::hasColumn('pages', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('seo_keywords');
            }
        });
    }
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['parent_id','page_type','featured_image','hero_title','hero_subtitle','hero_description','cta_text','cta_link','seo_keywords','sort_order']);
        });
    }
};
