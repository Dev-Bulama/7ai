<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            if (!Schema::hasColumn('menu_items', 'type')) {
                $table->string('type')->default('custom')->after('label'); // page, custom, service, category
            }
            if (!Schema::hasColumn('menu_items', 'page_id')) {
                $table->foreignId('page_id')->nullable()->constrained('pages')->nullOnDelete()->after('type');
            }
            if (!Schema::hasColumn('menu_items', 'icon')) {
                $table->string('icon')->nullable()->after('target');
            }
            if (!Schema::hasColumn('menu_items', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('icon');
            }
        });
    }
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn(['type', 'page_id', 'icon', 'is_active']);
        });
    }
};
